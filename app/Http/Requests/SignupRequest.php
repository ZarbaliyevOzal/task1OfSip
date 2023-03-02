<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "name" => "sometimes|nullable|max:45",
            "username" => "required|max:45|unique:users,username",
            "email" => "required|email|max:255|unique:users,email",
            "phone" => "sometimes|nullable|max:45",
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
