<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillingInfoRequest extends FormRequest
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
            'shipping_address' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'full_name' => 'required|regex:/^[a-zA-Z .]+$/u',
            'mobile_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        ];
    }
}
