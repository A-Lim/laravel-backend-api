<?php
namespace App\Repositories\Order;

use DB;
use App\Order;
use App\OrderRequirement;
use App\OrderTransaction;
use App\Product;
use App\OrderItem;
use App\OrderWorkItem;

use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderRepository implements IOrderRepository {

    /**
     * {@inheritdoc}
     */
    public function find($id, $details = false, $requirement = false, $transactions = false, $workitems = false) {
        $query = Order::where('id', $id);
        
        if ($details)
            $query->with('items');

        if ($requirement)
            $query->with('requirement');
        
        if ($transactions)
            $query->with('transactions');

        if ($workitems)
            $query->with('workitems');
        
        return $query->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function findByRefNo($refNo, $details = false, $requirement = false, $transactions = false) {
        $query = Order::where('refNo', $refNo);
        
        if ($details)
            $query->with('items');

        if ($requirement)
            $query->with('requirement');

        if ($transactions)
            $query->with('transactions');
        
        return $query->firstOrFail();
    }

     /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $query = Order::buildQuery($data)->orderBy('id', 'DESC');

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->paginate($limit);
        }

        return $query->get();
    }

    /**
     * {@inheritdoc}
     */
    public function create($cart, $currency) {
        $total = 0;

        // calculate total
        foreach ($cart as $cartItem) {
            $total += $cartItem['product']->price * $cartItem['quantity'];
        }

        DB::beginTransaction();
        $order = Order::create([
            'currency' => $currency,
            'status' => Order::STATUS_PENDING,
            'password' => Str::random(10),
            'refNo' => md5(time()),
            'total' => $total
        ]);

        $orderItems = [];

        foreach ($cart as $cartItem) {
            $orderItem = [
                'order_id' => $order->id,
                'product_id' => $cartItem['product']->id,
                'name' => $cartItem['product']->name,
                'description' => $cartItem['product']->description,
                'delivery_days' => $cartItem['product']->delivery_days,
                'quantity' => $cartItem['quantity'],
                'unit_price' => $cartItem['product']->price,
            ];
            array_push($orderItems, $orderItem);
        }

        OrderItem::insert($orderItems);
        DB::commit();

        return Order::with('items')->where('id', $order->id)->firstOrFail();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Order $order, $data) {
        $order->fill($data);
        $order->save();
        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function statistics($date) {
        $orders_today = Order::whereDate('created_at', $date)->get();
        $data['orders_today_count'] = count($orders_today);
        $data['orders_today_total'] = $orders_today->sum('total');

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function count_by_status(array $statuses) {
        return DB::table('orders')->select('status', DB::raw('count(*) as total'))
            ->whereIn('status', $statuses)
            ->groupBy('status')
            ->get();
    }

    public function create_work_item(Order $order, $data) {
        $data['order_id'] = $order->id;
        return OrderWorkItem::create($data);
    }

    public function update_order_requirements(Order $order, $data) {
        $requirement = $order->requirement;
        $data['order_id'] = $order->id;
        $data['submitted'] = true;

        if ($requirement != null)
            $requirement->update($data);
        else
            OrderRequirement::create($data);

        return $requirement;
    }   

    public function create_stripe_transaction(Order $order, $action, $payment_data) {
        $data['order_id'] = $order->id;
        $data['payment_transaction_id'] = $payment_data['id'];
        $data['action'] = $action;
        $data['payment_platform'] = OrderTransaction::PLATFORM_STRIPE;
        $data['status'] = $payment_data['status'];
        $data['details'] = json_encode($payment_data);
        return OrderTransaction::create($data);
    }

    public function create_paypal_transaction(Order $order, $action, $payment_data) {
        $data['order_id'] = $order->id;
        $data['payment_transaction_id'] = $payment_data['id'];
        $data['action'] = $action;
        $data['payment_platform'] = OrderTransaction::PLATFORM_PAYPAL;
        $data['status'] = $payment_data['state'];
        $data['details'] = json_encode($payment_data);
        return OrderTransaction::create($data);
    }

    public function create_error_transaction(Order $order, $action, $payment_platform, $exception) {
        $data['order_id'] = $order->id;
        $data['action'] = $action;
        $data['payment_platform'] = $payment_platform;
        $data['status'] = OrderTransaction::STATUS_FAIL;
        $data['details'] = json_encode((array) $exception);
        return OrderTransaction::create($data);
    }
    
}