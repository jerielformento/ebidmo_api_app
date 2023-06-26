<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Z0-9 ()_\-.+&!]+$/u',
            'details' => 'required|min:10|max:1000',
            'quantity' => 'required|integer',
            'condition' => 'required|integer',
            'brand' => 'required|integer',
            'category' => 'required|integer',
            'price' => 'required|integer',
            'images.*' => 'required|mimes:jpeg,png,jpg'
        ];
    }

    public function prepareValidation()
    {
        
    }
}
