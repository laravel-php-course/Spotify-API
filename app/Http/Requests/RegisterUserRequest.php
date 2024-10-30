<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class RegisterUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:' . User::EMAIL_MAX_LENGTH . '|unique:users',
            'mobile' => 'nullable|string|size:' . User::MOBILE_MAX_LENGTH . '|unique:users',
            'username' => 'required|string|max:' . User::USERNAME_MAX_LENGTH . '|unique:users',
            'password' => 'required|string|min:' . User::PASSWORD_MIN_LENGTH ,
        ];
    }
}
