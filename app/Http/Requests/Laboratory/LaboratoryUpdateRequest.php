<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryUpdateRequest extends FormRequest
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
            'laboratorie_id' => 'exists:laboratories,id',
            'description' => 'required|string|max:100000000',
        ];
    }
}
