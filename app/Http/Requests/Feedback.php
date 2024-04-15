<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class Feedback extends Request
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
        $rules = [
            'internship_id' => [
                'required', 'exists:internships,id'
            ],
            'text' => [
                'required', 'string',
            ],
            'score' => [
                'required', 'integer', 'between:1,5'
            ],
        ];

        if ($this->routeIs('feedbacks.editAction')) {
            unset($rules['internship_id']);
        }

        return $rules;
    }
}
