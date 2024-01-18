<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ray extends Model
{
    use HasFactory;

    public function Employee(){
        return $this->belongsTo(RayEmployee::class , 'employee_id');
    }
    public function Doctor(){
        return $this->belongsTo(Doctor::class , 'doctor_id');
    }
}
