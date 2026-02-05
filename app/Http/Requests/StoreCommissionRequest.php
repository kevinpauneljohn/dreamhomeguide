<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('add commission');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => [
                'nullable',
                Rule::unique('commissions')
                    ->where(fn ($query) =>
                    $query->where('user_id', $this->input('user_id'))
                    )
                    ->ignore($this->route('commission')) // safe for update
            ],
            'rate' => ['required','numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.unique' => 'This user already has a commission for this project.',
        ];
    }
}
