<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class Note extends Model
{
    use LogsActivity;
    protected $fillable = ['description','user_id','lead_id','type'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->useLogName('notes');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->merge([
            'lead_id' => $this->lead_id
        ]);
    }

    public function lead()
    {
        return $this->belongsTo(Leads::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
