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
            'username' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'middlename' => 'sometimes|required|nullable',
            'phone' => 'required|string',
            'email' => 'required|string|unique:customers_profile,email',
            'password' => 'required|string|confirmed'
        ];
    }
}
