<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class RayEmployeeServices {


    static public function GetALLRayEmployee(){
        return DB::table("ray_employees")
        ->select(
            'ray_employees.id',
            'ray_employees.name',
            'ray_employees.email',
            'ray_employees.created_at',
        )
        ->get();
    }

}


?>
