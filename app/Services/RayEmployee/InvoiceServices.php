<?php

namespace App\Services\RayEmployee;

use Illuminate\Support\Facades\DB;

class InvoiceServices {

    static  public function GetInvoices(string $case = NULL , string $id = NULL ){
        return DB::table('rays')
        ->leftJoin('invoices' , 'rays.invoice_id', 'invoices.id')
        ->leftJoin('patients' , 'rays.patient_id', 'patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->where('patient_translations.locale', app()->getLocale());
        })
        ->leftJoin('doctors' , 'rays.doctor_id', 'doctors.id')
        // ->leftJoin('doctor_translations' , function($join){
        //     $join->on('doctors.id' , 'doctor_translations.doctor_id')
        //     ->where('doctor_translations.locale', app()->getLocale());
        // })
        ->leftJoin('attachments' , function ($join){
            $join->on('attachments.attachable_id' , 'rays.id')
            ->where('attachments.attachable_type' , 'App\Models\Ray');
        })
        ->when($case , function($query) use($case){
            return $query->where('rays.case' , $case);
        })
        ->when($id , function($query) use($id){
            return $query->where('rays.id' , $id);
        })
        ->select(
                'rays.id' ,
                'rays.case' ,
                'rays.description',
                'invoices.invoice_date' ,
                'patient_translations.name AS patient_name',
                'doctors.name AS doctor_name',
                'rays.employee_id',
                'rays.description_employee',
                'patients.id AS patient_id'
            )
        ->selectRaw('GROUP_CONCAT(DISTINCT attachments.path) AS paths')
        ->groupBy('rays.id','rays.case','rays.description','invoices.invoice_date','patient_translations.name','doctors.name','rays.employee_id','rays.description_employee','patients.id')
        ->get();
    }
}
