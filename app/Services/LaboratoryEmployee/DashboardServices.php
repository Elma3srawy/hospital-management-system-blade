<?php
namespace App\Services\LaboratoryEmployee;

use Illuminate\Support\Facades\DB;



class DashboardServices {


    static public function getLatestFiveLaboratory(){
        return  DB::table('laboratories')
        ->leftJoin('patients' , 'laboratories.patient_id' , 'patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on('patient_translations.patient_id' , 'patients.id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->leftJoin('doctors' , 'laboratories.doctor_id' , 'doctors.id')
        ->select(
                'laboratories.created_at',
                'laboratories.description',
                'laboratories.case',
                'patient_translations.name AS patient_name',
                'doctors.name AS doctor_name'
            )
        ->limit(5)->latest()->get();
    }

}


?>
