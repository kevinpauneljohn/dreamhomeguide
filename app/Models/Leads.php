<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Leads extends Model
{
    use SoftDeletes, HasUuids, LogsActivity;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone','address','source',
        'source_url','status','user_id','birthday','civil_status','income_range','gender','lead_type','message','property_id'];

    protected function casts()
    {
        return [
            'birthday' => 'date:Y-m-d'
        ];
    }

    protected $appends = ['full_name'];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->useLogName('leads');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->merge([
            'lead_id' => $this->id
        ]);
    }

    public function getFullNameAttribute(): string
    {
        return ucwords(strtolower($this->first_name.' '.$this->last_name));
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function propertyInformation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ListPropertyInformation::class);
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }


}
