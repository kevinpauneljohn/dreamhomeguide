<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Sales extends Model
{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'sales';

    protected $fillable = [
        'reservation_date',
        'user_id',
        'lead_id',
        'project_id',
        'model_unit_id',
        'lot_area',
        'floor_area',
        'phase',
        'block_no',
        'lot_no',
        'total_contract_price',
        'down_payment',
        'financing',
        'dp_terms',
        'commission_rate',
        'status',
        'remarks'
    ];

    protected $casts = [
        'reservation_date' => 'date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->useLogName('sales');
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName): void
    {
        $activity->properties = $activity->properties->merge([
            'lead_id' => $this->lead_id,
            'lead_name' => !is_null($this->lead_id) ? $this->lead()->first()->full_name : null,
            'user_id' => $this->user_id,
            'agent' => $this->agent()->first()->full_name
        ]);
    }

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }

    public function modelUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ModelUnit::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
