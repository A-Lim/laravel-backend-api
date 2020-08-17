<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Order;

class OrderSuccessDetail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function build() {
        $currency = "$";

        return $this->view('mail.orderpaidreceipt')
            ->with(['order' => $this->order, 'currency' => $currency]);
    }
}
