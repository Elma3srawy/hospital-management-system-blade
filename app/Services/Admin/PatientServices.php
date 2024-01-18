<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class PatientServices{

    static public function GetAllPatients($column = NUll , $value= Null){

        $patients = DB::table('patients')
        ->leftjoin('patient_translations' ,function($join){
            $join->on('patients.id' , 'patient_translations.patient_id')
            ->whereLocale(app()->getLocale());
        })
        ->when($column && $value , function($query) use ($column , $value){
            $query->where($column , $value);
        })
        ->select('patients.id' ,'patients.email' , 'patient_translations.name','patients.blood' ,'patients.gender','patients.date_of_birth','patients.created_at' , 'patients.phone', 'patient_translations.address')
        ->get();

        return $patients;
    }
    static public function GetPatientById($id){
        return self::GetAllPatients('patients.id' , $id)->first();
    }

    static public function GetPatientAccount(string $id){

        return  DB::table('patient_accounts')
        ->where('patient_accounts.patient_id', $id)
        ->leftJoin('invoices' , 'patient_accounts.invoice_id','invoices.id')
        ->leftJoin('services' , 'invoices.service_id','services.id')
        ->leftJoin('service_translations' , function($join){
            $join->on('services.id' ,'service_translations.service_id')
            ->where('service_translations.locale' , app()->getLocale());
        })
        ->leftJoin('receipt_accounts' , 'patient_accounts.receipt_id','receipt_accounts.id')
        ->leftJoin('payment_accounts' , 'patient_accounts.payment_id','payment_accounts.id')
        ->select(
            'patient_accounts.date' ,
            'invoices.id AS invoice_id',
            'receipt_accounts.id AS receipt_id',
            'service_translations.name AS service_name',
            'payment_accounts.id As payment_id',
            'receipt_accounts.description AS receipt_description',
            'payment_accounts.description AS payment_description',
            'patient_accounts.credit',
            'patient_accounts.debit',
            )
        ->get();

    }
}
