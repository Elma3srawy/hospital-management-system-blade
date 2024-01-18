<?php
namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;



class DashboardServices {


    static public function getCountDoctors(){
        return  DB::table('doctors')->count();
    }
    static public function getCountPatients(){
        return  DB::table('patients')->count();
    }
    static public function getCountSections(){
        return  DB::table('sections')->count();
    }
}


?>
