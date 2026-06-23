<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends TenantModel
{
    protected $table = 'equipments';  // ← Especificar el nombre correcto de la tabla
    protected $connection = 'tenant';

    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'price',
        'termino',
        'description',
        'tenant_id'
    ];
}