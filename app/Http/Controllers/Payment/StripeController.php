<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Order\IOrderRepository;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

use DB;
use App\Order;
use App\OrderTransaction;
use \Stripe\Stripe;
use \Stripe\Charge;
use \Stripe\Exception\CardException;

use App\Http\Traits\ApiResponse;

use App\Http\Requests\Payment\StripePaymentRequest;

class StripeController extends Controller
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

    public function integration(Request $request) {
        $stripeKey = $this->systemSettingRepository->findByCode('stripekey');

        return $this->responseWithData(200, ['key' => $stripeKey->value]);
    }

    public function charge(StripePaymentRequest $request) {
        $stripeSetting = $this->systemSettingRepository->findByCode('stripesecret');
        $order = $this->orderRepository->findByRefNo($request->refNo, true);
        $data = $request->all();

        Stripe::setApiKey($stripeSetting->value);
        $token = $request->stripe_token;

        try {
            $charge = Charge::create([
                'amount' => $order->total * 100,
                'currency' => $order->currency,
                'source' => $token,
                'receipt_email' => $request->email,
            ]);
        } catch (CardException $exception) {
            // record transaction error
            $this->orderRepository
                ->create_error_transaction(
                    $order, 
                    OrderTransaction::ACTION_PAY, 
                    OrderTransaction::PLATFORM_STRIPE, 
                    $exception
                );
            return $this->responseWithMessage(401, $exception->getMessage());
        }

        DB::transaction(function () use ($order, $data, $charge) {
            $order_data['email'] = $data['email'];
            if ($charge->paid)
                $order_data['status'] = Order::STATUS_PAID;
            
            $this->orderRepository->update($order, $order_data);
            $this->orderRepository->update_order_requirements($order, $data);
            $this->orderRepository->create_stripe_transaction($order, OrderTransaction::ACTION_PAY, $charge);
        });

        return $this->responseWithRedirect(200, '/order/requirement/'.$order->refNo);
    }
}
