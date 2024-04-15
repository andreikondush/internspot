<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Password;

class Registration extends Request
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required', 'string', 'max:535'
            ],
            'last_name' => [
                'required', 'string', 'max:535'
            ],
            'email' => [
                'required', 'string', 'email', 'unique:users,email',
            ],
            'password' => [
                'required', 'string', Password::min(6)->letters()->numbers()->mixedCase()->uncompromised(), 'max:535'
            ],
        ];
    }
}
