<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends TenantModel
{
    protected $connection = 'tenant';
    protected $fillable = [
        'budget_id',
        'chapter_code',
        'chapter_name',
        'milestone_id',
        'milestone_code',
        'milestone_name',
        'category_code',
        'apu_id',
        'apu_code',
        'apu_name',
        'apu_unit',
        'category',
        'quantity',
        'unit_price',
        'total',
    ];
}