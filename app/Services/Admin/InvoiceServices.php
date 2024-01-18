<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class InvoiceServices{

    static public function GetAllInvoices(){
        return DB::table('invoices')
        ->leftJoin('patients' ,'invoices.patient_id','patients.id')
        ->leftJoin('patient_translations' ,function($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->leftJoin('doctors' ,'invoices.doctor_id','doctors.id')
        // ->leftJoin('doctor_translations' ,function($join){
        //     $join->on('doctors.id' , 'doctor_translations.doctor_id')
        //     ->where('doctor_translations.locale' , app()->getLocale());
        // })
        ->leftJoin('services' ,'invoices.service_id','services.id')
        ->leftJoin('service_translations' ,function($join){
            $join->on('services.id' , 'service_translations.service_id')
            ->where('service_translations.locale' , app()->getLocale());
        })
        ->leftJoin('sections' ,'doctors.section_id','sections.id')
        ->leftJoin('section_translations' ,function($join){
            $join->on('sections.id' , 'section_translations.section_id')
            ->where('section_translations.locale' , app()->getLocale());
        })
        ->select(
            'invoices.id As id',
            'service_translations.name AS service_name',
            'services.id AS service_id',
            'patient_translations.name AS patient_name',
            'patients.id AS patient_id',
            'invoices.invoice_date',
            'doctors.name AS doctor_name',
            'doctors.id AS doctor_id',
            'section_translations.name AS section_name',
            'sections.id AS section_id',
            'invoices.price',
            'invoices.discount_value',
            'invoices.tax_rate',
            'invoices.tax_value',
            'invoices.total_with_tax',
            'invoices.type',
            'invoices.invoice_date',
        )
        ->get();
    }

    static public function GetInvoiceByPatientId(string $id){
        return DB::table('invoices')
        ->leftJoin('patients' ,'invoices.patient_id','patients.id')
        ->leftJoin('patient_translations' ,function($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->where('patient_translations.locale' , app()->getLocale());
        })
        ->leftJoin('services' ,'invoices.service_id','services.id')
        ->leftJoin('service_translations' ,function($join){
            $join->on('services.id' , 'service_translations.service_id')
            ->where('service_translations.locale' , app()->getLocale());
        })
        ->select(
            'service_translations.name AS service_name',
            'invoices.total_with_tax',
            'invoices.type',
            'invoices.invoice_date',
        )
        ->where('invoices.patient_id' , $id)
        ->get();
    }

}
