<?php

namespace App\Http\Requests\Ray;

use Illuminate\Foundation\Http\FormRequest;

class RayUpdateRequest extends FormRequest
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
            'ray_id' => 'exists:rays,id',
            'description' => 'required|string|max:100000000',
        ];
    }
}
