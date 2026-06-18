<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResumenPagoSheet implements FromArray, ShouldAutoSize
{
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    public function array(): array
    {
        $total = $this->budget->monto ?? 0;
        $anticipo = $this->budget->monto_anticipo ?? 0;
        $iva = $total * 0.12;
        $totalPlanillado = $total + $iva;
        $deduccionAnticipo = $total * 0.3;

        return [
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', 'Número del Contrato :', '', $this->budget->no_contrato ?? '', ''],
            ['', 'Obra:', $this->budget->obra, '', ''],
            ['', 'Contratista:', $this->budget->contratista ?? '', ''],
            ['', 'Periodo:', 'ENERO - 2026', '', ''],
            ['', '', '', '', ''],
            ['', "RESUMEN DE PLANILLA DE OBRA Nº 1", '', '', ''],
            ['', '', '', '', ''],
            ['', 'Descripción', '', '', 'Monto'],
            ['', 'Planilla de Obra', '', '', $total],
            ['', "Reajuste provisional de la planilla Nº 1", '', '', 0],
            ['', '', '', '', ''],
            ['', 'Total', '', '', $total],
            ['', 'IVA 12%', '', '', $iva],
            ['', '', '', '', ''],
            ['', 'TOTAL PLANILLADO', '', '', $totalPlanillado],
            ['', '', '', '', ''],
            ['', 'Deducciones', '', '', ''],
            ['', 'ANTICIPO', '', '0.3', $deduccionAnticipo],
            ['', 'MULTAS', '', '', 0],
            ['', '', '', '', ''],
            ['', 'TOTAL DEDUCCIONES', '', '', $deduccionAnticipo],
            ['', '', '', '', ''],
            ['', 'LÍQUIDO A PAGARSE', '', '', $totalPlanillado - $deduccionAnticipo],
            ['', '', '', '', ''],
            ['', 'Nota: Se excluye en la planilla las retenciones de carácter tributarias.', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', 'f)________________________', '', 'f)________________________', ''],
            ['', $this->budget->fiscalizador ?? 'Fiscalizador', '', $this->budget->contratista ?? 'Contratista', ''],
            ['', 'Fiscalizador', '', 'Contratista', ''],
        ];
    }
}