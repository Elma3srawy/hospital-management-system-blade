<?php
namespace App\Collections\Doctor;

use Illuminate\Support\Collection;

class DoctorCollection {

    public static function GetDoctor($collection):Collection
    {
        if(empty($collection)){
            return collect([]);
        }
        $collection_return  = collect($collection)->map(function($doctor) {
            return (object)([
                'id' => $doctor->id,
                'name' => $doctor->name,
                'email' => $doctor->email,
                'status' => $doctor->status,
                'created_at' => $doctor->created_at,
                'phone' => $doctor->phone,
                'section_name' => $doctor->section_name,
                'image' => $doctor->image,
                'section_id' => $doctor->section_id ?? NULL,
                'appointments' => (object)([
                    'name' => explode(',', $doctor->appointment_name ?? NULL),
                    'id' => explode(',', $doctor->appointment_id ?? NULL),
                ]) ?? NULL,


            ]);
        });
        return $collection_return;
    }
}

?>
