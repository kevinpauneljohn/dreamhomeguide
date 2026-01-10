<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('add task');
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
            'description' => ['required', 'string','max:10000'],
            'type' => ['required', 'string', 'max:255'],
            'due_date' => ['required', 'date'],
            'priority' => ['required', 'string', 'max:255'],
            'assigned_to' => ['required', 'string', 'max:255'],
        ];
    }
}
