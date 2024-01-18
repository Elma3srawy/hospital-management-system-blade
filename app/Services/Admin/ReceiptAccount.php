<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class ReceiptAccount{

    static public function getAllReceipt(){
        $receipt = DB::table('receipt_accounts')
        ->leftJoin('patients','receipt_accounts.patient_id','patients.id')
        ->leftJoin('patient_translations' , function($join){
            $join->on("patients.id" , "patient_translations.patient_id")
            ->whereLocale(app()->getLocale());
        })
        ->select('receipt_accounts.id','receipt_accounts.date' ,'patient_translations.name','receipt_accounts.patient_id','amount','description','receipt_accounts.created_at')
        ->get();

        return $receipt;

    }
    static public function GetReceiptByPatientId(string $id){
        return DB::table('receipt_accounts')
        ->where('receipt_accounts.patient_id' , $id)
        ->select('receipt_accounts.date' ,'amount','description')
        ->get();
    }


}
