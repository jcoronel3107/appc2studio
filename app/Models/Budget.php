<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'obra',
        'monto',
        'monto_anticipo',
        'contratista',
        'fiscalizador',
        'administrador',
        'no_contrato',
        'fecha_contrato',
        'fecha_entrega_anticipo',
        'fecha_inicio_obra',
        'plazo_dias',
        'ampliacion_plazo',
        'fecha_terminacion_plazo',
        'fecha_elaboracion',
    ];

    public function items()
    {
        return $this->hasMany(BudgetItem::class);
    }
}