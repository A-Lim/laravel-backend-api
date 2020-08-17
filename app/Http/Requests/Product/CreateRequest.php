<?php

namespace App\Http\Requests\Product;

use App\Product;
use App\Http\Requests\CustomFormRequest;

class CreateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => 'required|string',
            'status' => 'required|string|in:'.implode(',', Product::STATUSES),
            'description' => 'string|nullable',
            'price' => 'required',
            'seqNo' => 'required|integer',
            'delivery_days' => 'required|integer',
            'custom' => 'nullable|boolean',
            'highlighted' => 'nullable|boolean',
        ];
    }

    public function messages() {
        return [
        ];
    }
}
