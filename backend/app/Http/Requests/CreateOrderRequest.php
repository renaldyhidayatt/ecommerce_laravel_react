<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Set to true if there is no specific authorization logic for this request
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
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email',
            'postalCode' => 'required',
            'countryCode' => 'required',
            'totalProduct' => 'required',
            'totalPrice' => 'required|numeric',
        ];
    }
}
