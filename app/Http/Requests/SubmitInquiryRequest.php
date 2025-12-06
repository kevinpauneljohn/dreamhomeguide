<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitInquiryRequest extends FormRequest
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
            'email' => 'nullable|email|required_without:phone',
            'phone' => [
                'nullable',
                'required_without:email',
                'regex:/^(09\d{9}|\+639\d{9})$/',
            ],
            'message' => 'nullable|string|max:1000',
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
            'g-recaptcha-response.required' => 'reCaptcha is required.',
            'phone.required_without' => 'Mobile Number is required when email is not provided.',
            'phone.regex' => 'Please enter a valid Philippine mobile number (0917xxxxxxx or +63917xxxxxxx).',
        ];
    }
}
