<?php

namespace App\Http\Requests\Order;

use App\OrderWorkItem;
use App\Http\Requests\CustomFormRequest;

class CreateOrderWorkItemRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
          'file' => 'nullable|mimes:docx,xls,xlsx,txt,pdf|max:1000',
          'externalFileUrl' => 'required_without:file',
          'message' => 'nullable|string'
        ];
    }

    public function messages() {
        return [
        ];
    }
}
