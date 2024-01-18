<?php

namespace App\Http\Requests\Ambulance;

use Illuminate\Foundation\Http\FormRequest;

class AmbulanceUpdateRequest extends FormRequest
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
            'id' => "required|exists:ambulances,id",
            'car_number' => "required|string",
            'car_model' => "required|string",
            'car_year_made' => "required|numeric",
            'car_type' => "required|numeric",
            'driver_name' => "required|string",
            'driver_license_number' => "required|numeric",
            'driver_phone' => "required|numeric",
            'notes' => "nullable|string",
            'is_available' => "nullable|in,1"
        ];
    }
}
