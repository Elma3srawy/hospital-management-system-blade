<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Collection;



class AmbulanceServices{

    public Static function GetAllAmbulances(string $column= NUll,string $value=NUll):Collection
    {
        $ambulances = DB::table('ambulances')->leftJoin('ambulance_translations' , function($join){
            $join->on('ambulances.id' ,'ambulance_translations.ambulance_id')
            ->whereLocale(app()->getLocale());
        })
        ->when($column && $value , function($query) use($column,$value){
            return $query->where($column , $value);
        })
        ->select(
                    'ambulances.id',
                    'ambulances.car_number',
                    'ambulances.car_model',
                    'ambulances.car_year_made',
                    'ambulances.car_type',
                    'ambulance_translations.driver_name',
                    'ambulances.driver_license_number',
                    'ambulances.driver_phone',
                    'ambulances.is_available',
                    'ambulance_translations.notes',
                )
        ->get();
        return  $ambulances;
    }

    public Static function GetAmbulanceByID($id)
    {
        $ambulance = self::GetAllAmbulances('ambulances.id' , $id)->first();
        return  $ambulance;
    }






}
