<?php

namespace Modules\Auth\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => __('No user found with this email address.'),
        ];
    }
}
