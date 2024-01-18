<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;


    public function Doctor(){
        return $this->belongsTo(Doctor::class , 'doctor_id');
    }
}
