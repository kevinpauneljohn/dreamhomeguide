<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['title', 'address', 'type', 'category', 'lot_area', 'floor_area', 'price', 'bedrooms','bathrooms','garage','description','status'];
}
