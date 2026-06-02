<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = [
        'budget_id',
        'apu_id',
        'apu_code',
        'apu_name',
        'apu_unit',
        'quantity',
        'unit_price',
        'total',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function apu()
    {
        return $this->belongsTo(AnalysisHeader::class, 'apu_id');
    }
}