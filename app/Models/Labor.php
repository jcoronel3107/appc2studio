<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Labor extends TenantModel
{
    protected $table = 'labors';
        // 👇 DEBE tener esto
    protected $connection = 'tenant';

    protected $fillable = [
        'code',
        'name',
        'category',
        'unit',
        'hourly_rate',
        'daily_rate',
        'termino',
        'description', 'tenant_id'
    ];
}