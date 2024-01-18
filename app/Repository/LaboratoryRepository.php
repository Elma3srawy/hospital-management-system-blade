<?php

namespace App\Repository;

use Illuminate\Support\Carbon;
use App\Interfaces\LaboratoryInterface;
use Illuminate\Support\Facades\DB;

class LaboratoryRepository implements LaboratoryInterface
{


    /**
    * Store a newly created resource in storage.
    */
    public function store(Mixed $request){

        try
        {
            DB::beginTransaction();

                $validated =  collect($request->validated())->put('created_at' , Carbon::now());
                DB::table('laboratories')->insert($validated->all());

            DB::commit();

            return back()->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }



    /**
    * Update the specified resource in storage.
    */
    public function update(Mixed $request){
        try
        {

            DB::table('laboratories')->where('id',$request->laboratorie_id)->update(['description'=> $request->description]);

            return back()->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }


    /**
    * Remove the specified resource from storage.
    */
    public function destroy(){

        try
        {

            DB::table('laboratories')->where('id', request('laboratorie_id'))->delete();

            return back()->with('success' , __('flasher::messages.success'));

        }
        catch (\Exception $e) {

            return back()->with('error', $e->getMessage());

        }

    }

}
