<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'user_id',
        'lead_id',
        'assigned_to',
        'priority',
        'is_public',
        'status',
        'appointment_id',
        'type'
    ];

    protected $appends = ['linked_record'];

    protected $casts = [
        'due_date' => 'datetime:Y-m-d H:i:s',
        'is_public' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->useLogName('tasks');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->merge([
            'lead_id' => $this->lead_id,
            'lead_name' => !is_null($this->lead_id) ? $this->lead()->first()->full_name : null,
            'user_id' => $this->user_id,
            'creator' => !is_null($this->user_id) ? $this->creator()->first()->full_name : null,
            'assigned_to' => $this->assigned_to,
            'assigned_agent' => $this->assignedAgent()->first()->full_name
        ]);
    }


    /**
     * Task creator (who created the task)
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Assigned agent (who will execute the task)
     */
    public function assignedAgent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    // Task.php

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }

    public function appointment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }


    public function getLinkedRecordAttribute(): ?array
    {
        if ($this->lead_id) {
            return [
                'type' => 'lead',
                'label' => 'Lead',
                'id' => $this->lead_id,
            ];
        }

        if ($this->appointment_id) {
            return [
                'type' => 'appointment',
                'label' => 'Appointment',
                'id' => $this->appointment_id,
            ];
        }

        return null;
    }

}
