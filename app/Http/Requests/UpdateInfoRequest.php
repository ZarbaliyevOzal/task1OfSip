<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Fluent;
use Illuminate\Validation\Validator;

class UpdateInfoRequest extends FormRequest
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
            'email' => 'sometimes|nullable|email|max:255',
            'phone' => 'sometimes|nullable|max:45',
            'registration_date' => 'sometimes|nullable|date',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->sometimes(
            'email', 
            'required|email|max:255|unique:users,email', 
            function (Fluent $input) {
                if (!$input->email) return false;
                return $this->user()->email !== $input->email;
            }
        );
    }
}
