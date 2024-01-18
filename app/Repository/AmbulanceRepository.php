<?php
namespace App\Repository;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AmbulanceInterface;
use App\Services\Admin\AmbulanceServices;


class AmbulanceRepository implements AmbulanceInterface
{

    public function index()
    {
        $ambulances  = AmbulanceServices::GetAllAmbulances();
        return view('Dashboard.Ambulances.index' , ['ambulances' => $ambulances]);
    }

    public function create(){
        return view('Dashboard.Ambulances.create');
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $validated = collect($request->validated())->except(['driver_name', 'notes'])->put('created_at' , Carbon::now());
            $ambulance_id = DB::table('ambulances')->insertGetId($validated->all());

            $ambulance_trans = collect([
                    'ambulance_id' => $ambulance_id,
                    'locale' => app()->getLocale() ,
                    'driver_name' => $request->driver_name ,
                    'notes' => $request->notes ,
            ])->all();

            DB::table('ambulance_translations')->insert($ambulance_trans);

            DB::commit();
            return to_route('ambulance.index')->with('success' , __('success'));
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        $ambulance = AmbulanceServices::GetAmbulanceByID($id);
        return view('Dashboard.Ambulances.edit' , ['ambulance' => $ambulance]);
    }

    public function update($request)
    {


        try {

            DB::beginTransaction();
                $id = $request->validated('id');
                $validated = collect($request->validated())->except(['notes' , 'driver_name'])->put('updated_at' , Carbon::now());
                DB::table('ambulances')->whereId($id)->update($validated->all());


                $ambulance_trans = collect([
                    'driver_name' => $request->driver_name ,
                    'notes' => $request->notes ,
                ])->all();


                DB::table('ambulance_translations')
                ->updateOrInsert(['locale' => app()->getLocale() ,'ambulance_id' => $id ] , $ambulance_trans);

            DB::commit();

            return to_route('ambulance.index')->with('success' , __('flasher::messages.The resource was updated'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }


    public function destroy($id)
    {

        try {

            DB::beginTransaction();

            DB::table('ambulances')->whereId($id)->delete();

            DB::commit();

            return to_route('ambulance.index')->with('success' , __('flasher::messages.The resource was deleted'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }






}








?>
