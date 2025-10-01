<?php

namespace App\Http\Requests\User\Login;

use Illuminate\Foundation\Http\FormRequest;

class UserValidateOtpRequest extends FormRequest
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
            "otp" => ['required','digits:' . config('app.otp_length_integer')],

            // send these fields with hidden input

            "phone" => ['nullable' , 'required_without:email'],
            "email" => ['nullable' , 'required_without:phone'],
        ];
    }
}
