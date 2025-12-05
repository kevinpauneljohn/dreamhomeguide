<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPropertyInformation extends Model
{
    protected $fillable = ['lead_id','location','property_category','additional_details'];

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Leads::class);
    }
}
