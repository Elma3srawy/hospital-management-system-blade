<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laboratory extends Model
{
    use HasFactory;


    public function Employee(){
        return $this->belongsTo(LaboratorieEmployee::class , 'employee_id');
    }
    public function Doctor(){
        return $this->belongsTo(Doctor::class , 'doctor_id');
    }
}
