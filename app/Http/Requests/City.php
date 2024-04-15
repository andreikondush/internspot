<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class City extends Request
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strtolower( (string)$this->get('name', '') ),
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
            'name' => [
                'required', 'string', 'max:535',
                Rule::unique('cities')->where(function ($query) {
                    if ($this->routeIs('cities.editAction')) {
                        $query->where('id', '!=', intval($this->route('id')));
                    }
                    return $query;
                })
            ],
        ];


    }
}
