<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'editorial_id' => 'required|numeric',
            'authors.*.id' => 'required_with:authors.*.id|exists:authors',
            'pdf_file' => 'required|file',
            'title' => 'required|string',
            'published_at' => 'required|date',
            'price' => 'required|numeric',
        ];
    }
}
