<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'code',
        'name',
        'unit',
        'price',
        'category',
        'termino',      // ← Debe estar aquí
        'description'
    ];
}