<?php

namespace App\Http\Requests\Announcement;

use App\Announcement;
use App\Http\Requests\CustomFormRequest;

class UpdateRequest extends CustomFormRequest {

    public function __construct() {
        parent::__construct();
    }
    
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'send_notification' => 'required|boolean',
            'schedule_at' => 'required_if:send_notification,1|date_format:Y-m-d H:i:s',
            // 'type' => 'required|string|in:'.implode(',', Announcement::TYPES),
            'action' => 'required|string|in:'.implode(',', Announcement::ACTIONS)
        ];
    }

    public function messages() {
        return [
            'schedule_at.required_if' => 'The schedule at field is required when send notification is set.',
            'schedule_at.date_format' => 'The schedule at value does not match the format Y-m-d H:i:s.'
        ];
    }
}
