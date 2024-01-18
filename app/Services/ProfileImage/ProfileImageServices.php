<?php

namespace App\Services\ProfileImage;

use Illuminate\Support\Facades\DB;


class ProfileImageServices{

    public function ProfileImage(){

        if(!empty(current_guard())){
            return
            match (current_guard()) {
                'admin' => $this->get_path_profile_image('App\Models\Admin'),
                'doctor' => $this->get_path_profile_image('App\Models\Doctor'),
                'patient' => $this->get_path_profile_image('App\Models\Patient'),
                default => null,
            };
        }
    }


    public function get_path_profile_image(string $attachable_type){
        return DB::table('attachments')
        ->where('attachable_type' , $attachable_type)
        ->where('attachable_id' , auth(current_guard())->user()->id)
        ->value('path');
    }
}

?>
