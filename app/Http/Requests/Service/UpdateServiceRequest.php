<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
           'name' => 'required|unique:service_translations,name,'.$this->service_id.',service_id',
           'service_id' => 'required|exists:services,id',
           'price' => 'required|numeric',
           'description' => "nullable|string",
           'status' => 'required|in:0,1|integer',
        ];
    }
}
