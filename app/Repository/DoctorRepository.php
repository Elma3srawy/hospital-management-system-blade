<?php
namespace App\Repository;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DoctorInterface;
use App\Services\Admin\DoctorServices;


class DoctorRepository implements DoctorInterface
{

    public function index()
    {
        $doctors = collect(DoctorServices::GetAllDoctor());
        return view("Dashboard.Doctors.index",['doctors' => $doctors]);

    }


    public function create()
    {
       $sections =  DB::table('sections')
       ->leftJoin('section_translations' , function ($join){
            $join->on("sections.id" ,'section_translations.section_id')
            ->whereLocale(app()->getLocale());
        })->get(['sections.id' , 'name']);

        $appointments = DB::table('appointments')
        ->leftJoin("appointment_translations" , function ($join){
            $join->on('appointments.id' , 'appointment_translations.appointment_id')
            ->whereLocale(app()->getLocale());
        })
        ->select('appointments.id',"name")
        ->get();

        return view("Dashboard.Doctors.add" , ['sections'=>$sections ,'appointments' => $appointments]);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $validated = collect($request->validated())->except(["appointments",'photo']);
            $validated['password'] = bcrypt($validated['password']);
            $validated['email_verified_at'] = Carbon::now();
            $validated['created_at'] = Carbon::now();

            $id = DB::table("doctors")->insertGetId($validated->all());

            $doctor_appointments = collect($request->appointments)->map(function($appointment_id) use($id){
                return [
                    'doctor_id' => $id,
                    'appointment_id' => $appointment_id,
                ];
            });

            DB::table('doctor_appointments')->insert($doctor_appointments->all());

            // Upload Image
            DoctorServices::UploadImage($request,$id);

            DB::commit();
            return to_route("doctor.index")->with('success',__('Doctors.add_doctor'));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("doctor.index")->with('error',$e->getMessage());
        }

    }


    public function edit(string $id)
    {
        $doctor = DoctorServices::GetDoctorById($id)->first();
        $sections = DoctorServices::GetAllSections();
        $appointments =  DoctorServices::GetAllAppointments();
        return view("Dashboard.Doctors.edit", ['doctor' => $doctor ,'sections' => $sections ,'appointments' => $appointments]);
    }
    public function show(string $id)
    {
        //
    }


    public function update($request)
    {
        try {
            DB::beginTransaction();

            $validated = collect($request->validated())
            ->put('updated_at' , Carbon::now())
            ->except('photo','appointments','id');

            $id = $request->id;

            DB::table('doctors')->whereId($id)->update($validated->all());

            $doctor_appointments = collect($request->appointments)->map(function($appointment_id) use($id){
                return [
                    'doctor_id' => $id,
                    'appointment_id' => $appointment_id,
                ];
            });

            // Delete existing records for the specified doctor
            DB::table('doctor_appointments')
            ->where('doctor_id', $id)
            ->delete();

            // Insert the new appointments for the doctor
            DB::table('doctor_appointments')->insert($doctor_appointments->all());

            DoctorServices::updateImage($request , $id);

            DB::commit();
            return to_route("doctor.index")->with('success', __("Doctors.add_doctor"));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("doctor.index")->with('error',$e->getMessage());
        }

    }


    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            if(request('page_id') == 1) {
                $id = [request('id')];
                DoctorServices::DeleteDoctor($id);
            }

            $ids = explode(',',request('delete_select_id'));
            DoctorServices::DeleteDoctor($ids);

            DB::commit();
            return to_route("doctor.index")->with('success',__('Doctors.delete_doctor'));
        } catch (\Exception $e) {
            DB::rollback();
            return to_route("doctor.index")->with('error',$e->getMessage());
        }
    }






}








?>
