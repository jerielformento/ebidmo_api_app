<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|unique:customers',
            'firstname' => 'required|regex:/^[a-zA-Z .]+$/u',
            'lastname' => 'required|regex:/^[a-zA-Z .]+$/u',
            'middlename' => 'sometimes|regex:/^[a-zA-Z ]+$/u|nullable',
            'phone' => 'sometimes|alpha_num|nullable',
            'email' => 'required|regex:/^[a-zA-Z.-_@]+$/u|unique:customers_profile,email',
            'password' => 'required|string|confirmed'
        ];
    }
}
