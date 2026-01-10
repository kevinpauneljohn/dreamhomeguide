<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

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
