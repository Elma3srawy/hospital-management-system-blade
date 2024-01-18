<?php

namespace App\Livewire;

use App\Events\Test;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\DoctorServices;
use App\Services\Admin\InvoiceServices;
use App\Services\Admin\PatientServices;
use App\Services\Admin\SingleServiceServices;

#[Layout('livewire.SingleInvoice.index')]
class SingleInvoice extends Component
{
    public $InvoiceSaved = false;
    public $InvoiceUpdated = false;
    public $editMode = false;
    public $storeMode = false;
    public $show_table = true;



    #[Validate('required|numeric')]
    public $discount_value=0 ,$tax_rate=0 ,$tax_value=0;

    #[Validate('required|numeric')]
    public $subtotal, $type;

    #[Locked]
    #[Validate('required|numeric')]
    public $total_with_tax,$price;

    #[Validate('required|integer')]
    public $service_id, $patient_id , $doctor_id;


    public $single_invoices;

    #[Locked]
    public $invoice,$sections;

    protected $validationAttributes = [
        'service_id' => 'Service Name',
        'patient_id' => 'Patient Name',
        'doctor_id' => 'Doctor Name',
    ];


    public function render()
    {
        $this->GetInvoices();
        $this->tax_value();
        $this->subtotal();
        $this->total_with_tax();
        return view('livewire.SingleInvoice.single-invoice')->with([
            'Patients' =>PatientServices::GetAllPatients(),
            'Doctors' => DoctorServices::GetAllDoctor(),
            'Services' => SingleServiceServices::getAllServices(),
        ]);

    }

    public function changeStoreMode()
    {
        $this->show_table = false;
        $this->editMode = false;
        $this->storeMode = true;
    }
    public function changeTableMode()
    {
        $this->show_table = true;
        $this->editMode = false;
        $this->storeMode = false;
    }

    public function get_section()
    {
        $this->sections = DoctorServices::getSectionWithDoctor($this->doctor_id);
    }
    public function get_price()
    {
        $this->price = SingleServiceServices::getAllServices()->where('id' , $this->service_id)->value('price');
    }
    public function subtotal()
    {
        $this->subtotal = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
    }
    public function tax_value()
    {
        if(is_numeric($this->discount_value)){
            $this->tax_value = $this->subtotal * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
        }
    }
    public function total_with_tax()
    {
        $this->total_with_tax =   $this->subtotal + $this->tax_value;
    }


    public function store(){
        $this->validate();
        try {
            DB::beginTransaction();
                $validated = collect($this->only('service_id', 'patient_id' , 'doctor_id' ,'tax_value','discount_value','total_with_tax','price','tax_rate', 'type'))
                ->merge(['invoice_date' => Carbon::now() ,'created_at' => Carbon::now() ]);
            $invoice_id = DB::table('invoices')->insertGetId($validated->all());

            $patient_accounts = collect([
                'date' => Carbon::now(),
                'invoice_id' => $invoice_id,
                'patient_id' => $this->patient_id,
                'debit' => $this->total_with_tax,
                'created_at' => Carbon::now(),
            ]);



            if($this->type == 2){
                DB::table('patient_accounts')->insert($patient_accounts->all());
            }
            else{
                $fund_accounts = $patient_accounts->forget('patient_id')->all();
                DB::table('fund_accounts')->insert($fund_accounts);
            }


            $this->reset();
            $this->InvoiceSaved= true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }

    public function GetInvoices(){
        $this->single_invoices  = InvoiceServices::GetAllInvoices();
    }

    public function edit($id){
        $this->show_table = false;
        $this->storeMode = false;
        $this->editMode = true;
        $this->invoice = InvoiceServices::GetAllInvoices()->where('id',$id)->first();
        $this->doctor_id = $this->invoice->doctor_id;
        $this->patient_id = $this->invoice->patient_id;
        $this->service_id = $this->invoice->service_id;
        $this->type = $this->invoice->type;
        $this->price = $this->invoice->price;
        $this->discount_value = $this->invoice->discount_value;
        $this->tax_rate = $this->invoice->tax_rate;
        $this->tax_value = $this->invoice->tax_value;
    }

    public function update($id){
        $this->validate();
        try {
            DB::beginTransaction();

                $validated = collect($this->only('service_id', 'patient_id' , 'doctor_id' ,'tax_value','discount_value','total_with_tax','price','tax_rate', 'type'))
                ->put('updated_at' , Carbon::now());

            DB::table('invoices')->whereId($id)->update($validated->all());

            $patient_accounts = collect([
                'date' => Carbon::now(),
                'patient_id' => $this->patient_id,
                'debit' => $this->total_with_tax,
                'updated_at' => Carbon::now(),
            ]);



            if($this->type == 2){
                DB::table('fund_accounts')->where('invoice_id', $id)->delete();
                DB::table('patient_accounts')->where('invoice_id' , $id)->updateOrInsert(['invoice_id' => $id],$patient_accounts->all());

            }
            else{
                $fund_accounts = $patient_accounts->forget('patient_id')->all();

                DB::table('patient_accounts')->where('invoice_id', $id)->delete();
                DB::table('fund_accounts')->where('invoice_id' , $id)->updateOrInsert(['invoice_id' => $id] , $fund_accounts);
            }


            $this->reset();
            $this->InvoiceUpdated= true;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }
    public function destroy($id){
        try {
            DB::beginTransaction();
                DB::table('invoices')->where('invoices.id' , $id)->delete();
                $this->reset();
            DB::commit();
                return to_route('admin.single.invoice')->with('success' , "Deleted Successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }


    public function print($id){
        $invoice = InvoiceServices::GetAllInvoices()->where('id',$id)->first();
        return view('livewire.SingleInvoice.print' , ['single_invoice' => $invoice]);
    }



}
