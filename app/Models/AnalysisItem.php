<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisItem extends Model
{
    protected $fillable = [
        'analysis_header_id',
        'section',
        'description',
        'quantity',
        'unit_price',
        'performance',
        'total',
        'row_position'
    ];
    
    protected $casts = [
        'section' => 'string',
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'performance' => 'decimal:2',
        'total' => 'decimal:2'
    ];
    
    public function header(): BelongsTo
    {
        return $this->belongsTo(AnalysisHeader::class, 'analysis_header_id');
    }
}