<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;


class SingleServiceServices{

    static public function getAllServices(){

        $sevices = DB::table('services')
        ->leftjoin('service_translations' ,function($join){
            $join->on('services.id' , 'service_translations.service_id')
            ->whereLocale(app()->getLocale());
        })
        ->select('services.id' , 'services.description','services.price' ,'services.status','services.created_at' , 'service_translations.name',)
        ->get();

        return $sevices;
    }

}
