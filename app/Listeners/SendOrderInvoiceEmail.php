<?php

namespace App\Listeners;

use App\Events\OrderPaid;

class SendOrderInvoiceEmail {

    public function __construct() {
        //
    }

    public function handle(OrderPaid $event) {
        $order = $event->order;
        
    }
}