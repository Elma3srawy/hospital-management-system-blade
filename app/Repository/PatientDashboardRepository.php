<?php

namespace App\Repository;

use App\Models\Ray;
use App\Models\Invoice;
use App\Models\Laboratory;
use App\Models\ReceiptAccount;
use App\Interfaces\PatientDashboardInterface;
use App\Services\LaboratoryEmployee\InvoiceServices;
use App\Services\RayEmployee\InvoiceServices AS RayInvoice;

class PatientDashboardRepository implements PatientDashboardInterface
{

    public function invoices(){

        $invoices = Invoice::where('patient_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.invoices',compact('invoices'));
    }

    public function laboratories(){

        $laboratories = Laboratory::where('patient_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.laboratories',compact('laboratories'));
    }

    public function viewLaboratories($id){

        $invoice = InvoiceServices::getLaboratoryFromPatient($id);
        if(auth()->user()->id <> $invoice->patient_id ){
            return abort(404);
        }

        $laboratorie = collect($invoice)->replace(['paths' => explode(',',$invoice->paths)])->except('employee_id' ,'patient_id');

        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.patient_details', compact('laboratorie'));
    }

    public function rays(){

        $rays = Ray::where('patient_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.rays',compact('rays'));
    }

    public function viewRays($id)
    {
        $rays = RayInvoice::GetInvoices(Null , $id)->first();
        if(auth()->user()->id <> $rays->patient_id){
            return abort(404);
        }
        $rays = collect($rays)->replace(['paths' => explode(',' , $rays->paths)]);
        return view('Dashboard.dashboard_RayEmployee.invoices.patient_details', compact('rays'));
    }

    public function payments(){

        $payments = ReceiptAccount::where('patient_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.payments',compact('payments'));
    }

}
