<?php

namespace App\Repository;

use App\Traits\Attachment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\RayEmployee\InvoiceServices;
use App\Interfaces\RayEmployeeInvoiceInterface;

class RayEmployeeInvoiceRepository implements RayEmployeeInvoiceInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $invoices = InvoiceServices::GetInvoices()->where('case' , 0);
        return view('Dashboard.dashboard_RayEmployee.invoices.index',compact('invoices'));
    }


   public function completed_invoices()
    {
        $invoices = InvoiceServices::GetInvoices(1);
        return view('Dashboard.dashboard_RayEmployee.invoices.completed_invoices',compact('invoices'));
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){

         try
        {
            DB::beginTransaction();

                //

            DB::commit();

            return to_route('route_name')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }


    /**
    * Display the specified resource.
    */
    public function show(string $id){
        //
    }


    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id){
        $invoice =  collect(InvoiceServices::GetInvoices(NULL , $id)->first())
                    ->except('invoice_date', 'case', 'description', 'doctor_name');
        return view('Dashboard.dashboard_RayEmployee.invoices.add_diagnosis',compact('invoice'));
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



            $employee_id = auth('ray_employee')->user()->id;
            $validated = collect($validated)->merge(['employee_id' => $employee_id , 'case' => 1 , 'updated_at' => Carbon::now()]);
            DB::table('rays')->whereId($id)->update($validated->all());

            if($request->hasFile('photos')){
                $this->uploadImage($request->file('photos') , $id);
            }

            DB::commit();

            return to_route('ray-employee-invoice.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id){

        try
        {
            DB::beginTransaction();

                //

            DB::commit();

            return to_route('route_name')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }

    public function uploadImage($files ,$ray_id){
        $files = is_array($files) && !empty($files)  ? $files : [$files];
        Attachment::uploadFile($files ,"Rays" , "Ray_image" , $ray_id ,"App\Models\Ray");
    }



    public function view_rays($id)
    {
        $rays = InvoiceServices::GetInvoices(Null , $id)->first();
        if(auth('ray_employee')->user()->id <> $rays->employee_id){
            return abort(404);
        }
        $rays = collect($rays)->replace(['paths' => explode(',' , $rays->paths)])->except('employee_id'.'patient_id');
        return view('Dashboard.dashboard_RayEmployee.invoices.patient_details', compact('rays'));
    }
}
