<?php

namespace App\Services\Doctor;

use Illuminate\Support\Facades\DB;

class InvoiceServices {

    static  public function GetInvoices(string $id , string $invoice_status){
        return DB::table('invoices')
        ->where('invoices.doctor_id' ,$id)
        ->where('invoices.invoice_status' ,$invoice_status)
        ->leftJoin('patients' , 'invoices.patient_id' , 'patients.id')
        ->leftJoin('services' , 'invoices.service_id' , 'services.id')
        ->leftJoin('patient_translations' ,function($join){
            $join->on("patients.id" , 'patient_translations.patient_id')
            ->where('patient_translations.locale' ,app()->getLocale());
        })
        ->leftJoin('service_translations' ,function($join){
            $join->on("services.id" , 'service_translations.service_id')
            ->where('service_translations.locale' ,app()->getLocale());
        })
        ->select(
            'invoices.id',
            'invoices.invoice_date',
            'invoices.patient_id AS patient_id',
            'invoices.doctor_id AS doctor_id',
            'patient_translations.name AS patient_name',
            'service_translations.name AS service_name',
            'invoices.price',
            'invoices.discount_value',
            'invoices.tax_rate',
            'invoices.tax_value',
            'invoices.total_with_tax',
            'invoices.invoice_status',
        )
        ->get();
    }


    static public function GetPatientRecords(string $id){
        return DB::table('patients')
        ->where('patients.id' , $id)
        ->leftJoin('diagnostics' , 'patients.id' ,'diagnostics.patient_id')
        ->leftJoin('doctors' , 'diagnostics.doctor_id' ,'doctors.id')
        ->select(
            'diagnostics.diagnosis',
            'diagnostics.date',
            'doctors.id AS doctor_id',
            'doctors.name AS doctor_name',
        )
        ->get();
    }
    static public function GetPatientRays(string $id){
        return DB::table('rays')
        ->leftJoin('patients' , 'rays.patient_id' ,'patients.id')
        ->leftJoin('ray_employees' , 'rays.employee_id' ,'ray_employees.id')
        ->leftJoin('doctors' , 'rays.doctor_id' ,'doctors.id')
        ->select(
            'rays.id AS ray_id',
            'rays.employee_id AS ray_employee_id',
            'rays.description AS ray_description',
            'ray_employees.name AS ray_employee_name',
            'rays.case AS ray_case',
            'doctors.id AS doctor_id',
            'doctors.name AS doctor_name',
        )
        ->where('rays.patient_id' , $id)
        ->get();
    }
    static public function GetPatientLaboratories(string $id){
        return DB::table('laboratories')
        ->leftJoin('patients' , 'laboratories.patient_id' ,'patients.id')
        ->leftJoin('laboratorie_employees' , 'laboratories.employee_id' ,'laboratorie_employees.id')
        ->leftJoin('doctors' , 'laboratories.doctor_id' ,'doctors.id')
        ->select(
            'laboratories.id AS laboratory_id',
            'laboratories.employee_id AS laboratory_employee_id',
            'laboratories.description AS laboratory_description',
            'laboratorie_employees.name AS laboratory_employee_name',
            'laboratories.case AS laboratory_case',
            'doctors.id AS doctor_id',
            'doctors.name AS doctor_name',
        )
        ->where('laboratories.patient_id' , $id)
        ->get();
    }

    static public function GetRaysFromPatient(string $id){
        return DB::table('rays')
        ->where('rays.id' , $id)
        ->leftJoin('attachments' , function ($join){
            $join->on('attachments.attachable_id' , 'rays.id')
            ->where('attachments.attachable_type' , 'App\Models\Ray');
        })
        ->leftJoin('patients' , 'rays.patient_id' , 'patients.id')
        ->leftJoin('patient_translations' , function ($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->select(
            'rays.description_employee',
            'rays.doctor_id',
            'patient_translations.name AS patient_name',
            DB::raw('GROUP_CONCAT( DISTINCT attachments.path) AS paths')
        )
        ->groupBy('rays.description_employee' , 'patient_translations.name','rays.doctor_id')
        ->first();
    }

    static public function getLaboratoryFromPatient(string $id){
        return DB::table('laboratories')
        ->where('laboratories.id' , $id)
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
            'laboratories.doctor_id',
            'patient_translations.name AS patient_name',
            DB::raw('GROUP_CONCAT( DISTINCT attachments.path) AS paths')
        )
        ->groupBy('laboratories.description_employee' , 'patient_translations.name','laboratories.doctor_id')
        ->first();
    }
}
