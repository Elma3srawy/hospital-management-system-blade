<?php

namespace App\Services\LaboratoryEmployee;

use Illuminate\Support\Facades\DB;

class InvoiceServices {

    static  public function getAllInvoices($case= null){
        return DB::table('laboratories')
        ->leftJoin('doctors' , 'laboratories.doctor_id' , 'doctors.id')
        ->leftJoin('patients' , 'laboratories.patient_id' , 'patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on("patients.id" , 'patient_translations.patient_id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->select(
                'laboratories.id',
                'laboratories.description',
                'laboratories.case',
                'laboratories.created_at',
                'doctors.name AS doctor_name',
                'patient_translations.name AS patient_name',
            )
        ->get();
    }
    static  public function getLaboratoryFromPatient($laboratory_id){
        return DB::table('laboratories')
        ->where('laboratories.id' , $laboratory_id)
        ->leftJoin('attachments' , function ($join){
            $join->on('attachments.attachable_id' , 'laboratories.id')
            ->where('attachments.attachable_type' , 'App\Models\Laboratory');
        })
        ->leftJoin('patients' , 'laboratories.patient_id' , 'patients.id')
        ->leftJoin('patient_translations' , function ($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->select(
            'laboratories.description_employee',
            'laboratories.employee_id',
            'patient_translations.name AS patient_name',
            'patients.id AS patient_id',
            DB::raw('GROUP_CONCAT( DISTINCT attachments.path) AS paths')
        )
        ->groupBy('laboratories.description_employee' , 'patients.id', 'patient_translations.name','laboratories.employee_id')
        ->first();

    }
}
