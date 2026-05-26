<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';  // ← Especificar el nombre correcto de la tabla
    
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