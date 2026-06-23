<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends TenantModel
{
    protected $table = 'transports';
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