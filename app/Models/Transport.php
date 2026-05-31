<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table = 'transports';
    
    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'price',
        'termino',
        'description'
    ];
}