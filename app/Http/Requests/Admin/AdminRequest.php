<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use function Psy\debug;

class AdminRequest extends FormRequest
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
        $id = request()->route()->parameter( 'admin' )->id ?? 0;

        $rules = [
            'name'         => [ 'required', 'string', 'max:100' ],
            'email'        => [ 'required', 'email', 'max:100', Rule::unique( 'admins' )->ignore( $id ) ],
            'password'     => [ 'required', 'confirmed', Password::min( 8 )->letters()->numbers()->uncompromised() ],
            'photo'        => [  'nullable' ],//'image',
            'photoPreview' => [ 'string', 'nullable' ],
        ];

        if ( $id )
        {
            $rules['password'] = [ 'nullable', Password::min( 8 )->letters()->numbers()->uncompromised() ];
        }

        return $rules;
    }
}
