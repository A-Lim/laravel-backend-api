<?php

namespace App\Http\Requests\UserGroup;

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
            'code' => 'required|string|unique:usergroups,code,NULL,id,deleted_at,NULL',
            'isAdmin' => 'required|boolean',
            'permissions' => 'exists:permissions,id',
        ];
    }
}
