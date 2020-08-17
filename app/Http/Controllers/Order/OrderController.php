<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Repositories\Product\IProductRepository;
use App\Repositories\Order\IOrderRepository;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

use App\Order;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\Order\OrderRequirementRequest;
use App\Events\OrderSuccess;

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
        unset(
            $order->id, 
            $order->status, 
            $order->password, 
            $order->payment_method, 
            $order->payment_details, 
            $order->created_at, 
            $order->updated_at
        );

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

        unset($order->id, $order->password, $order->payment_method, $order->payment_details, $order->created_at, $order->updated_at);
        return view('order.requirement', compact('order'));
    }

    public function submit_requirement(OrderRequirementRequest $request) {
        $order = $this->orderRepository->findByRefNo($request->refNo, true, true);

        if ($order == null)
            abort(404);
    
        $data = $request->all();
        // upload file to storage
        $fileUploadData = $this->upload_requirement_file($request);
        $data['file'] = $fileUploadData['file'];
        $data['fileUrl'] = $fileUploadData['fileUrl'];

        $this->orderRepository->update_order_requirements($order, $data);
        event(new OrderSuccess($order));

        return redirect('order/'.$order->refNo.'/thankyou');
    }

    public function order_submitted(Request $request, $refNo) {
        $order = $this->orderRepository->findByRefNo($refNo);
        if ($order == null)
            abort(404);

        return view('order.submitted');
    }

    private function upload_requirement_file(Request $request) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $path = Storage::disk('public')->putFileAs('orders/requirements/'.$request->refNo, $file, $fileName);
        return ['file' => $fileName, 'fileUrl' => $path];
    }
}
