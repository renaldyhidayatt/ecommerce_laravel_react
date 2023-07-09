<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:6',
            'file' => 'nullable|image|mimes:png,jpeg,jpg|max:4096',
        ];
    }
}
