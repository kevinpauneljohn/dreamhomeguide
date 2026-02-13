<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    protected $fillable = ['user_id','file_name','extension','title','url'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);

    }
}
