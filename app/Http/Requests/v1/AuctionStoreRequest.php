<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class AuctionStoreRequest extends FormRequest
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
            'buy_now_price' => 'required|integer|nullable',
            'increment_price' => 'required|integer',
            'end_date' => 'required|date|after:tomorrow',
            'type' => 'required|integer'
        ];
    }
}
