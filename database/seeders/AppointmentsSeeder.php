<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments =[
            'ar'=> ['السبت' ,'الاحد' ,'الاثنين' ,'الثلاثاء' ,'الاربعاء' ,'الخميس' , 'الجمعه' ],
            'en' => ['Satrday' ,'Sunday' ,"Monday" ,"tuesday" ,'wenday','thurthay' ,'fraiday' ],
        ];

        foreach($appointments['ar'] as $loop => $appointment ){
            $id =DB::table("appointments")->insertGetId(['created_at' => Carbon::now() , 'updated_at'=> Carbon::now()]);
            foreach (['ar' , 'en'] as $locale) {
                DB::table("appointment_translations")
                ->insertGetId(['locale' => $locale ,'appointment_id' => $id ,'name'=> $appointments[$locale][$loop]]);
            }
        }
    }
}
