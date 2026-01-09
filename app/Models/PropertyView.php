<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyView extends Model
{
    protected $fillable = ['property_id','ip_address','user_agent','referrer_url',
        'utm_source','utm_medium','utm_campaign','utm_content'];
}
