<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit sales');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lead_id' => ['required'],
            'user_id' => ['required'],
            'project_id' => ['required'],
            'model_unit_id' => ['required'],
            'reservation_date' => ['required','date'],
            'phase' => ['nullable', 'string', 'max:255'],
            'block_no' => ['required', 'string', 'max:255'],
            'lot_no' => ['required', 'string', 'max:255'],
            'lot_area' => ['nullable', 'numeric'],
            'floor_area' => ['nullable', 'numeric'],
            'remarks' => ['nullable', 'string', 'max:2000'],
            'total_contract_price' => ['required', 'numeric'],
            'down_payment' => ['nullable', 'numeric'],
            'dp_terms' => ['nullable', 'numeric'],
            'financing' => ['nullable', 'string', 'max:255'],
        ];
    }
}
