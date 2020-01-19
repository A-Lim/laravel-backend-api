<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomFormRequest extends FormRequest {
    protected $message = 'The given data was invalid.';

    public function setMessage($message) {
        $this->message = $message;
    }

    protected function failedValidation(Validator $validator) {
        $data = [
            'message' => $this->message,
            'errors' => $validator->errors()
        ];
        
        throw new HttpResponseException(response()->json($data, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}