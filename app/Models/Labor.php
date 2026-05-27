<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    protected $table = 'labors';
    
    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'hourly_rate',
        'daily_rate',
        'termino',
        'description'
    ];
}