<?php

namespace App\Services\Admin;

use App\Traits\Attachment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Collections\Doctor\DoctorCollection;


class DoctorServices{
    use Attachment;
    public Static function GetAllDoctor($column=Null , $value = NUll):Collection
    {
        $doctor_collection = DB::table('doctors')
        ->leftJoin("doctor_appointments" ,"doctors.id" ,"doctor_appointments.doctor_id")
        ->leftJoin("appointments" ,"doctor_appointments.appointment_id" ,"appointments.id")
        ->leftJoin("appointment_translations" ,function ($join){
            $join->on("appointments.id" ,"appointment_translations.appointment_id")
                ->where('appointment_translations.locale' , app()->getLocale());
        })
        ->leftJoin("attachments" ,function ($join){
            $join->on("doctors.id" ,"attachments.attachable_id")
                ->whereAttachable_type("App\Models\Doctor");
        })
        ->leftJoin("sections" ,"doctors.section_id" ,"sections.id")
        ->leftJoin("section_translations", function ($join) {
            $join->on("sections.id", "section_translations.section_id")
                ->where('section_translations.locale',app()->getLocale());
        })
        ->select(
            'doctors.id',
            "doctors.name",
            'doctors.email',
            'doctors.status',
            'doctors.created_at',
            'doctors.phone',
            'attachments.path AS image',
            'section_translations.name AS section_name',
            DB::raw('GROUP_CONCAT(DISTINCT  appointment_translations.name) AS appointment_name'),
            DB::raw('GROUP_CONCAT(DISTINCT  appointments.id) AS appointment_id')
        )
        ->when($column , function ($q) use($column , $value){
            $q->where($column,$value)
            ->addSelect(
                "sections.id AS section_id" ,
            );
        })

        ->groupBy(
            'doctors.id',
            "doctors.name",
            'doctors.email',
            'doctors.status',
            'doctors.created_at',
            'doctors.phone', 'attachments.path',
            'section_translations.name',
            'sections.id',
            )
        ->get();

        return DoctorCollection::GetDoctor($doctor_collection);

    }

    public Static function UploadImage($request , $id)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid() && !is_array($request->file('photo'))) {
            $file   = is_array($request->file('photo')) ? $request->file('photo') : [ $request->file('photo')];
            return self::uploadFile($file,"Doctor",'profile_image',$id ,"App\Models\Doctor");
        }
    }


    public Static function GetDoctorById(string $id)
    {

        return self::GetAllDoctor('doctors.id', $id);
    }


    public Static function GetAllSections()
    {
       $sections = DB::table('sections')
       ->leftjoin('section_translations' , function($join) {
            $join->on('sections.id' , 'section_translations.section_id')
                ->whereLocale(app()->getLocale());
       })
       ->select('sections.id', 'section_translations.name')
       ->get();
       return $sections;
    }


    public Static function GetAllAppointments()
    {
       $appointmetns = DB::table('appointments')
       ->leftjoin('appointment_translations' , function($join) {
            $join->on('appointments.id' , 'appointment_translations.appointment_id')
                ->whereLocale(app()->getLocale());
       })
       ->select('appointments.id', 'appointment_translations.name')
       ->get();
       return $appointmetns;
    }

    public Static function UpdateImage($request , $id)
    {
        if ($request->hasFile('photo') && $request->file('photo')->isValid() && !is_array($request->file('photo'))) {
            $file   = is_array($request->file('photo')) ? $request->file('photo') : [ $request->file('photo')];
            return self::updateFile($file,"Doctor",'profile_image',$id ,"App\Models\Doctor");
        }
    }
    public Static function DeleteImage($id)
    {

        $doctor =  DB::table('attachments')
        ->whereIn('attachable_id',$id)
        ->where('Attachable_type',"App\Models\Doctor")
        ->get(['id', 'path']);


        $id  = $doctor->pluck('id');
        $path  = $doctor->pluck('path');


        return self::deleteFile($id, $path);

    }

    public static function DeleteDoctor(Mixed $id){


        // Delete the doctor record
        DB::table('doctors')
        ->whereIn('doctors.id' ,$id)
        ->delete();

        // Delete appointments associated with the doctor
        DB::table('doctor_appointments')
        ->whereIn('doctor_id' , $id)
        ->delete();

        // Call the DeleteImage method from DoctorServices class to delete the profile image for the doctor with the given ID
        return self::DeleteImage($id);
    }


    public static function ChangePassword($request){
        try{

            $validated = (object)$request->validate([
                'id' => 'required|string|exists:doctors,id',
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);


            DB::table('doctors')
            ->whereId($validated->id)
            ->update(['password'=>$validated->password]);

            return to_route("doctor.index")->with('success' , __("Doctors.update_password"));
        }
        catch(\Exception $e){
            return back()->with('error' ,$e->getMessage());
        }


    }
    public static function ChangeStatus($request){
        try{
            $validated = (object)$request->validate([
                'id' => 'required|string|exists:doctors,id',
                'status' => 'required|in:0,1|numeric',
            ]);

            DB::table('doctors')
            ->whereId($validated->id)
            ->update(['status'=>$validated->status]);

            return to_route("doctor.index")->with('success' , __("Doctors.Status_change"));
        }
        catch(\Exception $e){
            return back()->with('error' ,$e->getMessage());
        }


    }
    public static function getSectionWithDoctor($doctor_id){
        try{

            $sections = DB::table('sections')
            ->rightJoin('doctors' , 'sections.id' , 'doctors.section_id')
            ->leftJoin('section_translations' , function($join){
                $join->on('sections.id' , 'section_translations.section_id')
                ->whereLocale(app()->getLocale());
            })
            ->where('doctors.id' , $doctor_id)
            ->select('section_translations.name' , 'sections.id')
            ->get();
            return $sections->first();


        }
        catch(\Exception $e){
            return back()->with('error' ,$e->getMessage());
        }


    }


}
