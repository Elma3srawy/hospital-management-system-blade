<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllDoctors extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request):array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'phone' => $this->phone,
            'section_name' => $this->section_name,
            'appointments' => empty($this->appointments) ? null : collect(['name' => explode(',', $this->appointments)]),
        ];

    }
}
