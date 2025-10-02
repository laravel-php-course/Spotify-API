<?php

namespace App\Http\Requests\User\Register;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'username'   => ['required', 'string', 'max:50', 'unique:users,username'],
            'phone'      => ['nullable', 'string', 'min:9', 'max:11', 'unique:users,phone'],
            'email'      => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8'],
        ];
    }
}
