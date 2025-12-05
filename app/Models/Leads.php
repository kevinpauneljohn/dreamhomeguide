<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Leads extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone','address','source',
        'source_url','status','user_id','birthday','civil_status','income_range','gender','lead_type'];

    protected function casts()
    {
        return [
            'birthday' => 'date:Y-m-d'
        ];
    }

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
}
