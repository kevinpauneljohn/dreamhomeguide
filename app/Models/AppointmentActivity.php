<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentActivity extends Model
{
    protected $fillable = ['appointment_id', 'user_id', 'accomplishment','status'];

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
