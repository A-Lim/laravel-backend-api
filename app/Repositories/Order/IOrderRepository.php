<?php
namespace App\Repositories\Order;

use App\Order;

interface IOrderRepository {
    /**
     * Find a order by id
     * 
     * @param integer $id
     * @return Order
     */
    public function find($id);

    /**
     * Find a order by reference no
     * 
     * @param string $refNo
     * @param bool $details
     * @return Order
     */
    public function findByRefNo($refNo, $details, $requirement);

     /**
     * List orders
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return array [Order] / LengthAwarePaginator
     */
    public function list($data, $paginate = false);

    /**
     * Create an order
     * 
     * @param array $cart
     * @param string $currency
     * @return Order
     */
    public function create($cart, $currency);

     /**
     * Update an order
     * 
     * @param Order $order
     * @param array $data
     * @return void
     */
    public function update(Order $order, $data);

    /**
     * Update an order requirement
     * 
     * @param Order $order
     * @param array $data
     * @return void
     */
    public function update_order_requirements(Order $order, $data);

    /**
     * Create a stripe order transaction
     * 
     * @param Order $order
     * @param string $action - 'pay', 'refund'
     * @param array payment_data
     * @return void
     */
    public function create_stripe_transaction(Order $order, $action, $payment_data);

    /**
     * Create a paypal order transaction
     * 
     * @param Order $order
     * @param string $action - 'pay', 'refund'
     * @param array payment_data
     * @return void
     */
    public function create_paypal_transaction(Order $order, $action, $payment_data);

    /**
     * Saves an transaction error
     * 
     * @param Order $order
     * @param string $action - 'pay', 'refund'
     * @param string $payment_platform
     * @param object $exception
     * @return void
     */
    public function create_error_transaction(Order $order, $action, $payment_platform, $exception);
}