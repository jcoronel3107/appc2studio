<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalysisHeader extends Model
{
    protected $fillable = [
        'code',
        'name', 
        'unit',
        'total_direct_cost',
        'indirect_cost',
        'total_cost',
        'word_file',  // ← Agrega esta línea
    ];
    
    public function items(): HasMany
    {
        return $this->hasMany(AnalysisItem::class);
    }
}