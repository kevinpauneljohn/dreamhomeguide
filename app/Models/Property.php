<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'location', 'property_type', 'property_category', 'lot_area', 'floor_area', 'price',
        'bedrooms','bathrooms','garage','description','status', 'slug', 'youtube_video_id','is_featured','user_id',
        'meta_title','meta_description','meta_keywords'
    ];

    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Leads::class);
    }
}
