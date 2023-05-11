<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidStoreRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'min_price' => 'required|integer',
            'buy_now_price' => 'required|integer',
            'currency' => 'required|string'
        ];
    }
}
