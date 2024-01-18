<?php

namespace App\Repository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PatientInterface;
use App\Services\Admin\PaymentAccount;
use App\Services\Admin\ReceiptAccount;
use App\Services\Admin\InvoiceServices;
use App\Services\Admin\PatientServices;

class PatientRepository implements PatientInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $patients  = PatientServices::GetAllPatients();

        return view('Dashboard.Patients.index', ['Patients' => $patients]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function create(){
        return view('Dashboard.Patients.create');
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){

        try {
            DB::beginTransaction();
                $validated = collect($request->validated())->except('name' , 'address')->merge(['password' => bcrypt($request->phone) , 'created_at' => Carbon::now(),'email_verified_at' =>  Carbon::now()]);
                $id = DB::table('patients')->insertGetId($validated->all());
                $validated_trans = ['patient_id' => $id , 'name' => $request->name , 'address' => $request->address , 'locale' => app()->getLocale()];
                DB::table('patient_translations')->insert($validated_trans);
            DB::commit();

            return to_route('patient.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }


    }


    /**
    * Display the specified resource.
    */
    public function show(string $id){
        $patient = PatientServices::GetPatientById($id);
        $invoices = InvoiceServices::GetInvoiceByPatientId($id);
        $receipts = ReceiptAccount::GetReceiptByPatientId($id);
        $patient_account = PatientServices::GetPatientAccount($id);

        return view('Dashboard.Patients.show', ['Patient' => $patient ,'invoices' => $invoices , 'receipt_accounts' => $receipts ,'Patient_accounts' => $patient_account]);
    }


    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id){
        $patient = PatientServices::GetPatientById($id);

        return view('Dashboard.Patients.edit' , ['Patient' => $patient]);
    }


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id){

        try
        {
            DB::beginTransaction();

                $patient_id = $request->id;

                $validated = collect($request->validated())->except('id','name' , 'address')->merge(['updated_at' => Carbon::now(),'email_verified_at' =>  Carbon::now()]);
                DB::table('patients')->whereId($patient_id)->update($validated->all());

                $validated_trans = ['name' => $request->name , 'address' => $request->address];
                DB::table('patient_translations')->updateOrInsert(['locale' => app()->getLocale() , 'patient_id' => $patient_id],$validated_trans);

            DB::commit();

            return to_route('patient.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id){
        try {
            DB::table('patients')->delete($id);
            return to_route('patient.index')->with('success' , __('flasher::messages.success'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
