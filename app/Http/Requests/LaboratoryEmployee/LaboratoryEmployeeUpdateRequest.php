<?php

namespace App\Http\Requests\LaboratoryEmployee;

use Illuminate\Foundation\Http\FormRequest;

class LaboratoryEmployeeUpdateRequest extends FormRequest
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
            "name" => 'required|string|min:3|max:100',
            'email' => 'email|required|unique:laboratorie_employees,email,'.$this->id,
            'password' => 'required|min:8|max:500',
        ];
    }
}
