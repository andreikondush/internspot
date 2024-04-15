<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class Internship extends Request
{
    public function prepareForValidation(): void
    {
        // Tags
        $tags = $this->get('tags');
        if (is_string($tags)) {
            $tags = json_decode($tags, true);
            if (is_array($tags)) {
                $tags = array_column($tags, 'value');
            }
        }

        $this->merge([
            'tags' => (is_array($tags)) ? $tags : [],
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required', 'string', 'max:535',
            ],
            'description' => [
                'required', 'string', 'min:65',
            ],
            'address' => [
                'required', 'string', 'max:535',
            ],
            'city' => [
                'required', 'exists:cities,id',
            ],
            'company_name' => [
                'required', 'string', 'max:535',
            ],
            'company_email' => [
                'required', 'string', 'email',
            ],
            'tags' => [
                'array'
            ],
            'tags.*' => [
                'string',
            ],
        ];
    }
}
