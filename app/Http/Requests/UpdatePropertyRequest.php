<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit listing');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'property_type' => ['required', 'string', 'max:255'],
            'property_category' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'price' => ['numeric', 'decimal:2','required'],
            'status' => ['required','string'],
            'lot_area' => ['numeric', 'decimal:2','nullable'],
            'floor_area' => ['numeric', 'decimal:2','nullable'],
            'bedrooms' => ['numeric','nullable'],
            'bathrooms' => ['numeric','nullable'],
            'garage' => ['numeric','nullable'],
            'description' => ['string','nullable'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('properties', 'slug')->ignore($this->property)
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Property Name field is required',
        ];
    }
}
