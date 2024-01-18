<?php
namespace App\Repository;



use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DiagnosticInterface;


class DiagnosticRepository implements DiagnosticInterface
{



    public function store($request)
    {

        try {
            DB::beginTransaction();
                $validated = collect($request->validated())->merge(['date' => Carbon::now() ,'created_at' => Carbon::now()]);
                DB::table('diagnostics')->insert($validated->all());
                $this->changeInvoiceStatus($request->invoice_id , 'completed');
            DB::commit();
            return back()->with('success' , __('flasher::messages.success'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(){
        return view('Dashboard.Doctor.invoices.patient_record' , ['patient_records' => []]);
    }


    public function addReview($request)
    {

        try {
            DB::beginTransaction();
                $request->validate(['review_date' => 'required|date']);

                $validated = collect($request->validated())->put('review_date', $request->review_date)->merge(['date' => Carbon::now(),'created_at' => Carbon::now()]);
                DB::table('diagnostics')->insert($validated->all());
                $this->changeInvoiceStatus($request->invoice_id , 'review');
            DB::commit();
            return back()->with('success' ,  __('flasher::messages.success'));
        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function changeInvoiceStatus(string $invoice_id,string $status){
        return DB::table('invoices')->whereId($invoice_id)->update(['invoice_status' => $status]);
    }




}








?>
