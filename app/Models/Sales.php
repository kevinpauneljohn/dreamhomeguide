<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory, SoftDeletes;

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
