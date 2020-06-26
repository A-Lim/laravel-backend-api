<?php

namespace App\Http\Requests\ContactUs;

use App\Http\Requests\CustomFormRequest;

class ContactUsRequest extends CustomFormRequest {

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
            'message' => 'required',
        ];
    }

    public function messages() {
        return [
        ];
    }
}
