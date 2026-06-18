<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DatosSheet implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    public function array(): array
    {
        return [
            ['DATOS DEL PROYECTO', '', ''],
            ['OBRA:', $this->budget->obra, ''],
            ['CALLE:', '', ''],
            ['ENTRE:', '', ''],
            ['SECTOR:', '', ''],
            ['CONTRATANTE:', 'ETAPA EP.', ''],
            ['DIRECTOR:', '', ''],
            ['COORDINADOR :', '', ''],
            ['CONTRATISTA:', $this->budget->contratista ?? '', ''],
            ['FISCALIZADOR:', $this->budget->fiscalizador ?? '', ''],
            ['ADMINISTRADOR :', $this->budget->administrador ?? '', ''],
            ['SUPERVISOR ETAPA-AP:', '', ''],
            ['SUPERVISOR ETAPA-TEL:', '', ''],
            ['MONTO OBRA (USD):', $this->budget->monto ?? 0, ''],
            ['NUMERO DEL CONTRATO:', $this->budget->no_contrato ?? '', ''],
            ['FECHA CONTRATO:', $this->budget->fecha_contrato ?? '', ''],
            ['FECHA DEL ANTICIPO:', $this->budget->fecha_entrega_anticipo ?? '', ''],
            ['FECHA INICIO OBRA:', $this->budget->fecha_inicio_obra ?? '', ''],
            ['PLAZO EJECUCION (días):', $this->budget->plazo_dias ?? '', ''],
            ['INDICES INICIALES mano de obra', '', ''],
            ['INDICES INICIALES de materiales', '', ''],
            ['PORCENTAJE ANTICIPO', '0.5', ''],
            ['MONTO DEL ANTICIPO (USD):', $this->budget->monto_anticipo ?? 0, ''],
            ['AMPLIACION DE PLAZO (días):', $this->budget->ampliacion_plazo ?? 0, ''],
            ['VENCIM. PLAZO EJECUCIÓN:', $this->budget->fecha_terminacion_plazo ?? '', ''],
            ['FECHA TERMINACION DE LA OBRA:', $this->budget->fecha_terminacion_plazo ?? '', ''],
            ['TIEMPO EMPLEADO EJEC (días):', '', ''],
            ['FECHA DE LA RECEPCION PROVISIONAL:', '', ''],
            ['FECHA DE LA RECEPCION DEFINITIVA:', '', ''],
            ['MONTO FISCALIZACION (USD):', '', ''],
            ['', '', ''],
            ['PLANILLA No:', '1', ''],
            ['PERIODO :', 'ENERO - 2026', 'INGRESE PERIODO CON FORMATO DE TEXTO'],
            ['FECHA DEL:', '11 ENERO DE 2026', 'INGRESE FECHA CON FORMATO DE TEXTO'],
            ['AL:', '31 ENERO DE 2026', ''],
        ];
    }

    public function headings(): array
    {
        return [];
    }
}