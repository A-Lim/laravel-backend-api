<?php

namespace App\Http\Requests\Payment;

use App\Order;
use App\Http\Requests\CustomFormRequest;

class StripePaymentRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'refNo' => 'required|exists:orders,refNo',
            'stripe_token' => 'required|string'
        ];
    }
}
