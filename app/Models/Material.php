<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends TenantModel
{
    protected $connection = 'tenant';
    protected $fillable = [
        'code',
        'name',
        'unit',
        'price',
        'category',
        'termino',      // ← Debe estar aquí
        'description', 
        'tenant_id'
    ];
}