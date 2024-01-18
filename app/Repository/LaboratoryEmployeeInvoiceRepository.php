<?php

namespace App\Repository;

use App\Traits\Attachment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\LaboratoryEmployee\InvoiceServices;
use App\Interfaces\LaboratoryEmployeeInvoiceInterface;

class LaboratoryEmployeeInvoiceRepository implements LaboratoryEmployeeInvoiceInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $invoices = InvoiceServices::getAllInvoices()->where('case' , 0);
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.index',compact('invoices'));
    }


   public function completed_invoices()
    {
        $invoices = InvoiceServices::getAllInvoices(1);
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.completed_invoices',compact('invoices'));
    }




    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id){
        $invoice =  InvoiceServices::getAllInvoices()->where('id' , $id)->first();
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.add_diagnosis',compact('invoice'));
    }


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id){
        try
        {
            DB::beginTransaction();

            $validated = $request->validate([
                'description_employee' => 'required|string',
            ]);



            $employee_id = auth('laboratorie_employee')->user()->id;
            $validated = collect($validated)->merge(['employee_id' => $employee_id , 'case' => 1 , 'updated_at' => Carbon::now()]);
            DB::table('laboratories')->whereId($id)->update($validated->all());

            if($request->hasFile('photos')){
                $this->uploadImage($request->file('photos') , $id);
            }

            DB::commit();

            return to_route('laboratory-employee-invoice.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }



    public function uploadImage($files ,$laboratory_id){
        $files = is_array($files) && !empty($files)  ? $files : [$files];
        Attachment::uploadFile($files ,"Laboratories" , "Laboratory_image" , $laboratory_id ,"App\Models\Laboratory");
    }



    public function viewLaboratory($id)
    {
        $invoice = InvoiceServices::getLaboratoryFromPatient($id);
        if(auth(current_guard())->user()->id <> $invoice->employee_id ){
            return abort(404);
        }
        $laboratorie = collect($invoice)->replace(['paths' => explode(',',$invoice->paths)])->except('employee_id' , 'patient_id');
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.patient_details', compact('laboratorie'));

    }
}
