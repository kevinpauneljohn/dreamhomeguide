<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitListingRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'nullable|email|required_without:phone|unique:leads,email',
            'phone' => [
                'nullable',
                'required_without:email',
                'regex:/^(09\d{9}|\+639\d{9})$/',
                'unique:leads,phone'
            ],
            'location' => 'required|string|max:255',
            'property_category' => 'required|string',
            'details' => 'nullable|string|max:2000',
//            'g-recaptcha-response' => 'required|captcha'
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
            'phone.required_without' => 'Mobile Number is required when email is not provided.',
            'phone.regex' => 'Please enter a valid Philippine mobile number (0917xxxxxxx or +63917xxxxxxx).',
        ];
    }
}
