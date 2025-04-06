<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password'],
            'role' => ['required', 'string'],
            'profile_image' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'is_active' => ['required'],
            'email_verified_at' => ['nullable'],
            'remember_token' => ['nullable', 'string'],
        ];
    }
}
