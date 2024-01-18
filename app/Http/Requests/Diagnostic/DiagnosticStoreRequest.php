<?php

namespace App\Http\Requests\Diagnostic;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosticStoreRequest extends FormRequest
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
            'invoice_id' => 'required|exists:invoices,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'required|string|max:150000',
            'medicine' => 'required|string|max:150000',
        ];
    }
}
