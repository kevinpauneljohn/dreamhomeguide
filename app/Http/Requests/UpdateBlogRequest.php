<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('edit blog');
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
            'thumbnail' => ['nullable','image', 'max:160000', File::types([
                'jpg','png',
            ])],
            'slug' => ['required', 'string', Rule::unique('blogs','slug')->ignore($this->blog)],
            'category' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'blog_content' => ['required', 'string', 'max:50000']
        ];
    }
}
