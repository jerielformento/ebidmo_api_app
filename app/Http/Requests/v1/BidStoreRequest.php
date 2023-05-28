<?php

namespace App\Http\Requests\v1;

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
            'slug' => 'required|string',
            'min_price' => 'required|integer',
            'buy_now_price' => 'required|integer',
            'increment_price' => 'required|integer',
            'expiration' => 'required|date|after:start_date'
        ];
    }
}
