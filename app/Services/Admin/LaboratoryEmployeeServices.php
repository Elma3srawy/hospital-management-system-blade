<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class LaboratoryEmployeeServices {


    static public function GetALLLaboratoryEmployeeServices(){
        return DB::table("laboratorie_employees")
        ->select(
            'laboratorie_employees.id',
            'laboratorie_employees.name',
            'laboratorie_employees.email',
            'laboratorie_employees.created_at',
        )
        ->get();
    }

}


?>
