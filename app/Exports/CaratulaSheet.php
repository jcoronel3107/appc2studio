<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CaratulaSheet implements FromArray, ShouldAutoSize
{
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    public function array(): array
    {
        $obra = $this->budget->obra;
        $contrato = $this->budget->no_contrato ?? '';
        $contratista = $this->budget->contratista ?? '';
        $fiscalizador = $this->budget->fiscalizador ?? '';
        $administrador = $this->budget->administrador ?? '';
        $periodo = 'ENERO - 2026';

        return [
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['DIRECCION DE FISCALIZACION', '', '', '', ''],
            ["PLANILLA DE OBRA Nº 1", '', '', '', ''],
            [$obra, '', '', '', ''],
            ['No. CONTRATO:', '', $contrato, '', ''],
            ['CONTRATISTA:', '', $contratista, '', ''],
            ['FISCALIZADOR:', '', $fiscalizador, '', ''],
            ['SUPERVISOR:', '', $administrador, '', ''],
            ['PERIODO DE EJECUCION:', '', $periodo, 'al', $periodo],
            ['O R I G I N A L', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['', '', '', '', ''],
            ['DIRECCION DE FISCALIZACION', '', '', '', ''],
            ["PLANILLA DE OBRA Nº 1", '', '', '', ''],
            [$obra, '', '', '', ''],
            ['No. CONTRATO:', '', $contrato, '', ''],
            ['CONTRATISTA:', '', $contratista, '', ''],
            ['FISCALIZADOR:', '', $fiscalizador, '', ''],
            ['SUPERVISOR:', '', $administrador, '', ''],
            ['PERIODO DE EJECUCION:', '', $periodo, 'al', $periodo],
            ['C O P I A', '', '', '', ''],
        ];
    }
}