<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Appointment extends Model
{
    use LogsActivity;
    protected $fillable = ['title','appointment_date','location','notes','user_id','status','lead_id','appointment_type','assigned_agent'];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->useLogName('appointments');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->merge([
            'lead_id' => $this->lead_id,
            'lead_name' => $this->lead()->first()->full_name
        ]);
    }

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_agent');

    }

    public function notifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(
            \Illuminate\Notifications\DatabaseNotification::class,
            'notifiable'
        );
    }

    public function appointmentActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppointmentActivity::class);
    }

}
