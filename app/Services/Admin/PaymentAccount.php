<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class PaymentAccount{

    static public function getAllPayment(){
        $payments = DB::table('payment_accounts')
        ->leftJoin('patients','payment_accounts.patient_id','patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on("patients.id" , "patient_translations.patient_id")
            ->whereLocale(app()->getLocale());
        })
        ->select('payment_accounts.id', 'payment_accounts.date','patient_translations.name','payment_accounts.patient_id','amount','description','payment_accounts.created_at')
        ->get();

        return $payments;

    }
    static public function GetPaymentByPatientId($id){
        return  DB::table('payment_accounts')
        ->select('payment_accounts.date','amount','description')
        ->where("payment_accounts.patient_id" , $id)
        ->get();

    }

}
