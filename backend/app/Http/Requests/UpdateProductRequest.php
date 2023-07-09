<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'countInStock' => 'required|integer',
            'file' => 'nullable|image|mimes:png,jpeg,jpg|max:4096',
        ];
    }
}
