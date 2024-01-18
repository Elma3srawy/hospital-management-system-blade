<?php

namespace App\Repository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\ReceiptAccount;
use App\Services\Admin\PatientServices;
use App\Interfaces\ReceiptAccountInterface;


class ReceiptAccountRepository implements ReceiptAccountInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $receipt = ReceiptAccount::getAllReceipt();
        return view('Dashboard.Receipt.index' , ['receipts' => $receipt]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function create(){
        $patients = PatientServices::GetAllPatients();
        return view("Dashboard.Receipt.add" , ['Patients' => $patients]);
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){

        try
        {
            DB::beginTransaction();

                $validated = collect($request->validated())->merge(['date' => Carbon::now(), 'created_at' => Carbon::now() , 'amount' => $request->debit])->forget('debit');
                $receipt_id = DB::table('receipt_accounts')->insertGetId($validated->all());


                $patientAccount = $validated->merge(['credit' => $request->debit , 'receipt_id' => $receipt_id])->except('amount','description');
                DB::table('patient_accounts')->insert($patientAccount->all());

                $fundAccount = $patientAccount->Put('debit' , $request->debit)->except('patient_id' , 'credit');
                DB::table('fund_accounts')->insert($fundAccount->all());

            DB::commit();

            return to_route('receipt-account.index')->with('success' , __('flasher::messages.success'));

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
        $receipt = ReceiptAccount::getAllReceipt()->where('id',$id)->first();
        $patients = PatientServices::GetAllPatients();
        return view('Dashboard.Receipt.edit' , ['receipt_accounts' => $receipt , 'Patients' => $patients]);
    }


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id){
        try
        {
            DB::beginTransaction();

                $validated = collect($request->validated())->merge(['updated_at' => Carbon::now() , 'amount' => $request->debit])->forget('debit');
                DB::table('receipt_accounts')->whereId($id)->update($validated->all());

                $patientAccount = $validated->merge(['credit' => $request->debit])->except('amount','description');
                DB::table('patient_accounts')->where('receipt_id' , $id)->update($patientAccount->all());

                $fundAccount = $patientAccount->Put('debit' , $request->debit)->except('patient_id' , 'credit');
                DB::table('fund_accounts')->where('receipt_id' , $id)->update($fundAccount->all());

            DB::commit();

            return to_route('receipt-account.index')->with('success' , __('flasher::messages.success'));

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
            $id  = request('id');
            DB::beginTransaction();

                DB::table('receipt_accounts')->whereId($id)->delete();

            DB::commit();

            return to_route('receipt-account.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }

    public function print(string $id){
        $receipt = ReceiptAccount::getAllReceipt()->where('id',$id)->first();
        return view('Dashboard.Receipt.print' , ['receipt' => $receipt]);
    }

}
