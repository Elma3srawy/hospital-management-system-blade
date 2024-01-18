<?php

namespace App\Repository;

use App\Services\Doctor\InvoiceServices;
use App\Interfaces\DoctorInvoiceInterface;

class DoctorInvoiceRepository implements DoctorInvoiceInterface
{

    /**
    * Display a listing of the resource.
    */
    public function pending(){
        $invoices = InvoiceServices::GetInvoices(auth(current_guard())->user()->id , 'pending');
        return view('Dashboard.doctor.invoices.index' , ['invoices' => $invoices]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function review(){
        $invoices = InvoiceServices::GetInvoices(auth(current_guard())->user()->id , 'review');
        return view('Dashboard.doctor.invoices.review_invoices' , ['invoices' => $invoices]);

    }


    /**
    * Store a newly created resource in storage.
    */
    public function completed(){
        $invoices = InvoiceServices::GetInvoices(auth(current_guard())->user()->id , 'completed');
        return view('Dashboard.doctor.invoices.completed_invoices' , ['invoices' => $invoices]);
    }


    /**
    * Display the specified resource.
    */
    public function patient_details(string $id){
        $patient_records = InvoiceServices::GetPatientRecords($id);
        $patient_rays = InvoiceServices::GetPatientRays($id);
        $patient_Laboratories = InvoiceServices::GetPatientLaboratories($id);

        return view('Dashboard.doctor.invoices.patient_details' ,[
            'patient_records' => $patient_records ,
            'patient_rays' => $patient_rays,
            'patient_Laboratories' => $patient_Laboratories,
        ]);
    }

    public function show(string $id){
        $rays = InvoiceServices::GetRaysFromPatient($id);

        if(is_null($rays) || $rays->doctor_id <> auth()->user()->id){
            return abort(404);
        }

        $rays = collect($rays)->replace(["paths" => explode(',',$rays->paths)]);
        return view('Dashboard.doctor.invoices.view_rays',compact('rays'));
    }

    public function showLaboratory(string $id){
        $laboratories = InvoiceServices::getLaboratoryFromPatient($id);

        if(is_null($laboratories) || $laboratories->doctor_id <> auth()->user()->id){
            return abort(404);
        }

        $laboratories = collect($laboratories)->replace(["paths" => explode(',',$laboratories->paths)])->forget('doctor_id');

        return view('Dashboard.Doctor.invoices.view_laboratories', compact('laboratories'));
    }


}
