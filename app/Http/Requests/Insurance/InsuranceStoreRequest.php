<?php

namespace App\Http\Requests\Insurance;

use Illuminate\Foundation\Http\FormRequest;

class InsuranceStoreRequest extends FormRequest
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
            'insurance_code' => 'required|string|unique:insurances,insurance_code',
            'name' => 'required|string|unique:insurance_translations,name',
            'discount_percentage' => 'required|numeric',
            'Company_rate' => 'required|numeric',
            'notes' => 'required|string',
        ];
    }
}
