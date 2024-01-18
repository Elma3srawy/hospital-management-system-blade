<?php

namespace App\Repository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\PaymentAccount;
use App\Services\Admin\PatientServices;
use App\Interfaces\PaymentAccountInterface;


class PaymentAccountRepository implements PaymentAccountInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $payments = PaymentAccount::getAllPayment();
        return view('Dashboard.Payment.index' , ['payments' => $payments]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function create(){
        $patients = PatientServices::GetAllPatients();
        return view("Dashboard.Payment.add" , ['Patients' => $patients]);
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){
        try
        {
            DB::beginTransaction();

                $validated = collect($request->validated())->merge(['date' => Carbon::now(), 'created_at' => Carbon::now() , 'amount' => $request->credit])->forget('credit');
                $payment_id = DB::table('payment_accounts')->insertGetId($validated->all());


                $patientAccount = $validated->merge(['debit' => $request->credit , 'payment_id' => $payment_id])->except('amount','description');
                DB::table('patient_accounts')->insert($patientAccount->all());

                $fundAccount = $patientAccount->Put('credit' , $request->credit)->except('patient_id' , 'debit');
                DB::table('fund_accounts')->insert($fundAccount->all());

            DB::commit();

            return to_route('payment-account.index')->with('success' , __('flasher::messages.success'));

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

        $payment = paymentAccount::getAllPayment()->where('id',$id)->first();
        $patients = PatientServices::GetAllPatients();
        return view('Dashboard.payment.edit' , ['payment_account' => $payment , 'Patients' => $patients]);

    }


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id){
        try
        {
            DB::beginTransaction();

                $validated = collect($request->validated())->merge(['date' => Carbon::now(), 'created_at' => Carbon::now() , 'amount' => $request->credit])->forget('credit');
                DB::table('payment_accounts')->where('id' , $id)->update($validated->all());

                $patientAccount = $validated->merge(['debit' => $request->credit])->except('amount','description');
                DB::table('patient_accounts')->where('payment_id' , $id)->update($patientAccount->all());

                $fundAccount = $patientAccount->Put('credit' , $request->credit)->except('patient_id' , 'debit');
                DB::table('fund_accounts')->where('payment_id' , $id)->update($fundAccount->all());

            DB::commit();

            return to_route('payment-account.index')->with('success' , __('flasher::messages.success'));

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

                DB::table('payment_accounts')->whereId($id)->delete();

            DB::commit();

            return to_route('payment-account.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }

    public function print(string $id){
        $payment = paymentAccount::getAllPayment()->where('id',$id)->first();
        return view('Dashboard.Payment.print', ['payment_account' => $payment]);
    }
}
