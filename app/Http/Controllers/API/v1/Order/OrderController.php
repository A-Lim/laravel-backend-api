<?php

namespace App\Http\Controllers\API\v1\Order;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Order;
use App\Repositories\Order\IOrderRepository;
use App\Http\Requests\Order\CreateOrderWorkItemRequest;

class OrderController extends ApiController {

    private $orderRepository;

    public function __construct(IOrderRepository $iOrderRepository) {
        $this->middleware('auth:api');
        $this->orderRepository = $iOrderRepository;
    }
    
    public function list(Request $request) {
        // $this->authorize('viewAny', Order::class);
        $paginate = $request->has('paginate') ? $request->paginate : true;
        $orders = $this->orderRepository->list($request->all(), $paginate);
        return $this->responseWithData(200, $orders);
    }

    public function details(Order $order) {
        // $this->authorize('view', $order);
        $order = $this->orderRepository->find($order->id, true, true, true, true);
        return $this->responseWithData(200, $order); 
    }

    public function badges() {
        $data = $this->orderRepository->count_by_status([Order::STATUS_PENDING, Order::STATUS_PAID]);
        return $this->responseWithData(200, $data); 
    }

    public function statistics(Request $request) {
        $statistics = $this->orderRepository->statistics($request->date);
        return $this->responseWithData(200, $statistics);
    }

    public function submit_work_item(CreateOrderWorkItemRequest $request, Order $order) {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $fileUploadData = $this->upload_workitem_file($request);
            $data['file'] = $fileUploadData['file'];
            $data['fileUrl'] = $fileUploadData['fileUrl'];
        }
        $order_work_item = $this->orderRepository->create_work_item($order, $data);
        return $this->responseWithMessageAndData(200, $order_work_item, 'Order Work Item created.');
    }

    private function upload_workitem_file(Request $request) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $path = Storage::disk('public')->putFileAs('orders/workitem'.$request->refNo, $file, $fileName);

        return ['file' => $fileName, 'fileUrl' => $path];
    }
}
