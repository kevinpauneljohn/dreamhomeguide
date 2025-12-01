<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['title','description','user_id','lead_id','type'];

    public function lead()
    {
        return $this->belongsTo(Leads::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
