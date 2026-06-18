<?php

namespace App\Exports;

use App\Models\Budget;
use App\Models\BudgetItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PresupuestoExport implements WithMultipleSheets
{
    protected $budgetId;

    public function __construct($budgetId)
    {
        $this->budgetId = $budgetId;
    }

    public function sheets(): array
    {
        $budget = Budget::with('items')->findOrFail($this->budgetId);

        return [
            new DatosSheet($budget),
            new CaratulaSheet($budget),
            new ResumenPagoSheet($budget),
            new ResumenP1Sheet($budget),
            new SabanaPlanillaSheet($budget),
        ];
    }
}