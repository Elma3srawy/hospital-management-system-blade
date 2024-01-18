<?php
namespace App\Repository;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\InsuranceInterface;


class InsuranceRepository implements InsuranceInterface
{


    public function index(){
        $insurances = $this->GetInsurances();
        return view('Dashboard.insurance.index' , ['insurances' => $insurances]);
    }


    public function create(){
        return view('Dashboard.insurance.create');
    }
    public function store($request){
        try {
            DB::beginTransaction();
                $validated=  collect($request->validated())->except('name' , 'notes')->put('created_at' , Carbon::now());
                $id = DB::table('insurances')->insertGetId($validated->all());
                $insurance_trans = collect(['name' => $request->name ,'notes' => $request->notes]);
                DB::table('insurance_translations')->updateOrInsert(['locale' => app()->getLocale() ,'insurance_id' => $id] ,$insurance_trans->all());
            DB::commit();
            return to_route('insurance.index')->with('success' , __('insurance.7'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return back()->with('error' , $e->getMessage());
        }

    }

    public function show(string $id){

    }
    public function edit(string $id){
        $insurance = $this->GetInsurances('insurances.id' , $id)->first();

        return view('Dashboard.insurance.edit' , ['insurances' => $insurance]);
    }

    public function update($request , $id){

        try {
            DB::beginTransaction();
                      $validated = collect($request->validated())->except('name', 'notes')->put('updated_at', Carbon::now());

            DB::table('insurances')->whereId($id)->update($validated->all());
            $insurance_trans = collect(['name' => $request->name ,'notes' => $request->notes]);

            DB::table('insurance_translations')->updateOrInsert(['locale' => app()->getLocale() ,'insurance_id' => $id] , $insurance_trans->all());
            DB::commit();
            return to_route('insurance.index')->with('success' , __('insurance.7'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return back()->with('error' , $e->getMessage());
        }


    }

    public function destroy(string $id){
        try {
            DB::table('insurances')->whereId($id)->delete();
            return to_route('insurance.index')->with('success' , __('insurance.7'));
        }
        catch (\Exception $e) {

            return back()->with('error' , $e->getMessage());
        }
    }

    public function GetInsurances(string $column =Null , string $value = Null){
        return  DB::table('insurances')->leftJoin('insurance_translations' , function ($join){
            $join->on('insurances.id' ,'insurance_translations.insurance_id')
            ->whereLocale(app()->getLocale());
        })
        ->when($column && $value , function ($query) use($column,$value){
            $query->where($column , $value);
        })
        ->select('insurance_code', 'insurances.id' ,'insurance_translations.name', 'discount_percentage' ,'company_rate' , 'status' ,'notes')
        ->get();
    }






}








?>
