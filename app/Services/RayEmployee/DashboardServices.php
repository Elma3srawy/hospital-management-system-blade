<?php
namespace App\Services\RayEmployee;

use Illuminate\Support\Facades\DB;



class DashboardServices {

    static public function getLatestFiverRays(){
        return  DB::table('rays')
        ->leftJoin('patients' , 'rays.patient_id' , 'patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on('patient_translations.patient_id' , 'patients.id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->leftJoin('doctors' , 'rays.doctor_id' , 'doctors.id')
        ->select(
                'rays.created_at',
                'rays.description',
                'rays.case',
                'patient_translations.name AS patient_name',
                'doctors.name AS doctor_name'
            )
        ->limit(5)->latest()->get();
    }

}


?>
