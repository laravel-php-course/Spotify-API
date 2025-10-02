<?php

namespace App\Http\Requests\User\Verification;

use Illuminate\Foundation\Http\FormRequest;

class UserFormPhoneVerificationRequest extends FormRequest
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
            'phone' => ['required','string','min:9','max:11']
        ];
    }
}
