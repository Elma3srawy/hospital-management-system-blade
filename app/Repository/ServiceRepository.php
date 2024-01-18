<?php
namespace App\Repository;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ServiceInterface;
use App\Services\Admin\SingleServiceServices;

class ServiceRepository implements ServiceInterface
{

    public function index()
    {
        $services =  SingleServiceServices::getAllServices();

        return view('Dashboard.Services.Single Service.index',['services' => $services]);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();

            $validated = collect($request->validated())->put('created_at',Carbon::now())->except('name');

            $service_id = DB::table('services')->insertGetId($validated->all());


            $service_trans = collect(['service_id' => $service_id, 'name' =>$request->validated('name'),'locale' => app()->getLocale()]);

            DB::table('service_translations')->insert($service_trans->all());

            DB::commit();
            return to_route('service.index')->with('success' , __('Services.add_Service'));
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


    public function update($request)
    {
        try {

            DB::beginTransaction();
            $service_id = $request->only('service_id');
            $validated = collect($request->only('price','description','status'))->put('updated_at',Carbon::now());

            DB::table('services')->whereId($service_id)->update($validated->all());

            $service_trans = $request->only('service_id','name');

            DB::table('service_translations')
            ->updateOrInsert(['service_id' => $service_id , 'locale' => app()->getlocale()],$service_trans);

            DB::commit();

            return to_route('service.index')->with('success' , __('Services.edit_Service'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {

            DB::beginTransaction();

            DB::table('services')->whereId($id)->delete();

            DB::commit();

            return to_route('service.index')->with('success' , __('Services.delete_Service'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
        }
    }






}








?>
