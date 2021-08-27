<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        return [
            'title'     => [ 'required', 'string' ],
            'url'       => [ 'required', 'string' ],
            'is_active' => [ 'boolean' ],
            'parent_id' => [ 'integer' ],
            'order_id'  => [ 'integer' ],
        ];
    }
}
