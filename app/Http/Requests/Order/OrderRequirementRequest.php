<?php

namespace App\Http\Requests\Order;

use App\Order;
use App\Http\Requests\CustomFormRequest;

class OrderRequirementRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'refNo' => 'required|string|exists:orders,refNo',
            'name' => 'required|string',
            'email' => 'required|string|email',
            'fromLang' => 'required|string',
            'toLang' => 'required|string',
            'file' => 'required|mimes:docx,xls,xlsx,txt,pdf'
        ];
    }

    public function messages() {
        return [
        ];
    }
}
