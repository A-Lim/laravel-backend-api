<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Repositories\Product\IProductRepository;
use App\Repositories\Order\IOrderRepository;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

use App\Order;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\Order\OrderRequirementRequest;



class OrderController extends Controller
{
    use ApiResponse;

    private $productRepository;
    private $orderRepository;
    private $systemSettingRepository;
    
    public function __construct(IOrderRepository $iOrderRepository, IProductRepository $iProductRepository,
        SystemSettingRepositoryInterface $systemSettingRepositoryInterface) {
        $this->middleware(['web', 'guest']);
        $this->orderRepository = $iOrderRepository;
        $this->productRepository = $iProductRepository;
        $this->systemSettingRepository = $systemSettingRepositoryInterface;
    }

    public function details(Request $request, $refNo) {
        $order = $this->orderRepository->findByRefNo($refNo, true);
        unset($order->id);
        unset($order->status);
        unset($order->password);
        unset($order->payment_method);
        unset($order->payment_details);
        unset($order->created_at);
        unset($order->updated_at);

        return $this->responseWithData(200, $order);
    }

    public function view(Request $request) {
        return view('order.details');
    }

    public function store(Request $request) {
        $cart = session('cart');
        
        if ($cart == null)
            return back()->with('message', 'Cart is empty.');

        $currency = $this->systemSettingRepository->findByCode('currency');

        $order = $this->orderRepository->create($cart, $currency->value);
        return redirect('order/pay/'.$order->refNo);
    }

    public function payment(Request $request, $refNo) {
        $order = $this->orderRepository->findByRefNo($refNo, true);
        
        if ($order == null)
            abort(404); 

        // TODO: check if requirement has been collected
        
        if ($order->status === ORDER::STATUS_PAID)
            return redirect('order/requirement/'.$refNo);
        
        return view('order.payment', compact('order'));
    }

    public function requirement(Request $request, $refNo) {
        $order = $this->orderRepository->findByRefNo($refNo, true, true);

        if ($order == null)
            abort(404);

        if ($order->status !== Order::STATUS_PAID)
            return redirect('order/pay/'.$refNo);

        unset($order->id);
        unset($order->password);
        unset($order->payment_method);
        unset($order->payment_details);
        unset($order->created_at);
        unset($order->updated_at);

        return view('order.requirement', compact('order'));
    }

    public function submit_requirement(OrderRequirementRequest $request) {
        $order = $this->orderRepository->findByRefNo($request->refNo);

        if ($order == null)
            abort(404);
    
        $data = $request->all();

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $path = Storage::putFileAs('public/orders/'.$request->refNo, $file, $fileName);

        $data['file'] = $path;
        $this->orderRepository->update_order_requirements($order, $data);

        return redirect('order/'.$order->refNo.'/thankyou');
    }

    public function order_submitted(Request $request, $refNo) {
        $order = $this->orderRepository->findByRefNo($refNo);

        if ($order == null)
            abort(404);

        return view('order.submitted');
    }
}
