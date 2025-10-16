<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string']      ,
            'email' => ['string', 'email', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
        ];
    }
}
