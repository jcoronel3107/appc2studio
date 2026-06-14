<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetMilestone extends Model
{
    protected $fillable = [
        'budget_id',
        'chapter_code',
        'chapter_name',
        'code',
        'name',
        'order',
    ];

    public function items()
    {
        return $this->hasMany(BudgetItem::class, 'milestone_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function getTotalAttribute()
    {
        return $this->items()->sum('total');
    }
}