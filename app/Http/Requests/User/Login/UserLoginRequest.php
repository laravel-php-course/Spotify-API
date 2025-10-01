<?php

namespace App\Http\Requests\User\Login;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'nullable',
                'string',
                'min:8',
                'required_with:username'
            ],

            'email' => [
                'nullable',
                'email',
                'required_without_all:phone,username'
            ],

            'phone' => [
                'nullable',
                'min:9',
                'max:11',
                'required_without_all:email,username'
            ],

            'username' => [
                'nullable',
                'string',
                'required_with_out:email,phone'
            ]
        ];
    }
}
