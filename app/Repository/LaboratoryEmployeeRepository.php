<?php

namespace App\Repository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\LaboratoryEmployeeInterface;
use App\Services\Admin\LaboratoryEmployeeServices;

class LaboratoryEmployeeRepository implements LaboratoryEmployeeInterface
{

    /**
    * Display a listing of the resource.
    */
    public function index(){
        $laboratorie_employees = LaboratoryEmployeeServices::GetALLLaboratoryEmployeeServices();
        return view('Dashboard.laboratorie_employee.index' , ['laboratorie_employees' => $laboratorie_employees]);
    }


    /**
    * Show the form for creating a new resource.
    */
    public function create(){
        //
    }


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){
         try
        {
            DB::beginTransaction();

            $validated =  collect($request->validated())->merge(['email_verified_at' => Carbon::now(), 'created_at' => Carbon::now()])->replaceRecursive(['password' => bcrypt($request->password)]);

            DB::table('laboratorie_employees')->insert($validated->all());

            DB::commit();

            return to_route('laboratory-employee.index')->with('success' , __('flasher::messages.success'));

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
        //
    }


    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request, string $id){
        try
        {
            DB::beginTransaction();

            $validated =  collect($request->validated())->merge(['updated_at' => Carbon::now()])->replaceRecursive(['password' => bcrypt($request->password)]);
            DB::table('laboratorie_employees')->whereId($id)->update($validated->all());

            DB::commit();

            return to_route('laboratory-employee.index')->with('success' , __('flasher::messages.success'));

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

                DB::table('laboratorie_employees')->delete($id);

            DB::commit();

            return to_route('laboratory-employee.index')->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }

}
