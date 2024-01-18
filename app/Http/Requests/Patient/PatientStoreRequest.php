<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientStoreRequest extends FormRequest
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
            'name' =>"required|string|min:5|max:1000",
            'email' =>"required|email|unique:patients,email",
            'date_of_birth' =>"required|date",
            'phone' => 'required|string|unique:patients,phone',
            'gender' => 'required|in:1,2',
            'blood' => 'required|string',
            'address' => 'required|string',
        ];
    }
}
