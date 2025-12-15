<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['title','appointment_date','location','notes','user_id','status','lead_id'];
}
