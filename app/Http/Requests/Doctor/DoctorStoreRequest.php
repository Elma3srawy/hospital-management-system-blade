<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
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
            'name' => "required|string",
            'email' => "required|email|unique:doctors,email",
            'password' => 'required|min:8|max:30',
            'phone' => 'required|string|min:8|max:30',
            'section_id' => "required|exists:sections,id|numeric",
            'appointments' => 'array|in:1,2,3,4,5,6,7',
            'photo' => "nullable|file|image|mimes:jpeg,png,gif,jpg",
        ];
    }
}
