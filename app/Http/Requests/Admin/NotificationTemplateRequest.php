<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email_subject'     => [ 'present' ],
            'email_text'        => [ 'present' ],
            'sms_text'          => [ 'present' ],
            'notification_text' => [ 'present' ],
        ];

        return $rules;
    }
}
