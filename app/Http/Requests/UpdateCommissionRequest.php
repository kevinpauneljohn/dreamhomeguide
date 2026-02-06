<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit commission');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $commissionId = $this->route('commission'); // route-model binding or ID
        $userId = $this->user_id ?? $this->route('commission')->user_id;

        return [
            'rate' => ['required', 'numeric'],

            'project_id' => [
                'nullable',
                'integer',
                'exists:projects,id',

                Rule::unique('commissions')
                    ->where(fn ($query) => $query->where('user_id', $userId))
                    ->ignore($commissionId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.unique' => 'This user already has a commission for this project.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'project_id' => $this->project_id === '' ? null : $this->project_id,
        ]);
    }

}
