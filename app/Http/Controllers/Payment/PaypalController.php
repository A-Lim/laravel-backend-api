<?php

namespace App\Http\Controllers\Payment;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\IOrderRepository;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

use DB;
use App\Order;
use App\OrderTransaction;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\WebProfile;
use PayPal\Api\InputFields;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use App\Http\Traits\ApiResponse;

class PaypalController extends Controller
{
    use ApiResponse;

    private $systemSettingRepository;
    private $orderRepository;

    public function __construct(IOrderRepository $iOrderRepository,
        SystemSettingRepositoryInterface $systemSettingRepositoryInterface) {
        $this->middleware('guest');
        $this->orderRepository = $iOrderRepository;
        $this->systemSettingRepository = $systemSettingRepositoryInterface;
    }

    public function charge(Request $request) {
        $order = $this->orderRepository->findByRefNo($request->refNo, true);
        $context = $this->getApiContext();
        // has to be valid ISO currency code
        $currency = strtoupper($order->currency);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_arr = [];
        foreach ($order->items as $orderItem) {
            $item = new Item();
            $item->setName($orderItem->name)
                ->setCurrency($currency)
                ->setQuantity($orderItem->quantity)
                ->setPrice($orderItem->unit_price);
            
            array_push($item_arr, $item);
        }

        $item_list = new ItemList();
        $item_list->setItems($item_arr);

        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($order->total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setInvoiceNumber($order->refNo);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('payment/paypal/status?refNo='.$order->refNo))
            ->setCancelUrl(url('order/pay/'.$order->refNo));
    
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($context);
        } catch (PayPalConnectionException | Exception $exception) {
            // record transaction error
            $this->orderRepository
                ->create_error_transaction(
                    $order, 
                    OrderTransaction::ACTION_PAY, 
                    OrderTransaction::PLATFORM_PAYPAL, 
                    $exception
                );
            return $this->responseWithMessage(401, $exception->getMessage());
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        session()->put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            // redirect to paypal
            return $this->responseWithRedirect(200, $redirect_url);
        }

        return $this->responseWithMessage(401, 'Unknown error occurred.');
    }

    public function status(Request $request) {
        $order = $this->orderRepository->findByRefNo($request->refNo);
        $data = [];

        if ($order == null)
            abort(404);

        $payment_id = session('paypal_payment_id');

        if (!$request->filled('PayerID') || 
            !$request->filled('token')) {
            throw new Exception('PayerID and token not found.');
        }

        try {
            $context = $this->getApiContext();
            $payment = Payment::get($payment_id, $context);
            $execution = new PaymentExecution();
            $execution->setPayerId($request->PayerID);
            $result = $payment->execute($execution, $context);

            DB::transaction(function () use ($order, $result) {
                // gather requirements details from paypal info
                $requirements_data['name'] = $result->payer->payer_info->first_name.' '.$result->payer->payer_info->last_name;
                $requirements_data['email'] = $result->payer->payer_info->email;
                
                if ($result->getState() == 'approved') {
                    $this->orderRepository->update($order, [
                        'email' => $result->payer->payer_info->email,
                        'status' => Order::STATUS_PAID
                        ]
                    );
                }
                
                $this->orderRepository->update_order_requirements($order, $requirements_data);
                $this->orderRepository->create_paypal_transaction($order, OrderTransaction::ACTION_PAY, $result->toArray());
            });

            if ($result->getState() == 'approved') {
                $data['status'] = 'success';
                $data['title'] = 'Payment Successful';
                $data['description'] = 'You will be redirected to the requirements page.';
                $data['redirect'] = url('/order/requirement/'.$order->refNo);
            } else {
                $data['status'] = 'error';
                $data['title'] = 'Payment Unsuccessful';
                $data['description'] = 'An error has occured. Please try again or contact our support if you already has been charged.';
                $data['redirect'] = url('/order/pay/'.$order->refNo);
            }
            
        } catch (PayPalConnectionException | Exception $exception) {
            // save exception data
            // record transaction error
            $this->orderRepository
                ->create_error_transaction(
                    $order, 
                    OrderTransaction::ACTION_PAY, 
                    OrderTransaction::PLATFORM_PAYPAL, 
                    $exception
                );

            $data['status'] = 'error';
            $data['title'] = 'Payment Unsuccessful';
            $data['description'] = $exception->getMessage();
            $data['redirect'] = url('/order/pay/'.$order->refNo);
        }

        return view('order.paypalstatus', compact('data'));
    }

    private function getApiContext() {
        $paypalSettings = $this->systemSettingRepository->findByCodes(['paypalkey', 'paypalsecret']);
        $paypalKey = $paypalSettings->firstWhere('code', 'paypalkey');
        $paypalSecret = $paypalSettings->firstWhere('code', 'paypalsecret');

        // if paypal settings are null or empty
        if (($paypalKey == null || $paypalSecret == null) && 
            ($paypalKey->value == '' || $paypalSecret->value == ''))
                throw new Exception('Paypal integration have not been set up.');
        

        $paypal_mode = env('APP_ENV') != 'production' ? 'sandbox' : 'live';

        $paypal_conf['client_id'] = $paypalKey->value;
        $paypal_conf['secret'] = $paypalSecret->value;
        $paypal_conf['settings'] = [
            'mode' => $paypal_mode,
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR'
        ];

        $api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );

        $api_context->setConfig($paypal_conf['settings']);

        return $api_context;
    }
}
