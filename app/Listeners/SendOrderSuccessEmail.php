<?php

namespace App\Listeners;

use Mail;
use App\Events\OrderSuccess;
use App\Mail\OrderSuccessDetail;

class SendOrderSuccessEmail {

    public function __construct() {
    }

    public function handle(OrderSuccess $event) {
        $order = $event->order;
        Mail::to($order->requirement->email)
            ->send(new OrderSuccessDetail($order));
    }
}