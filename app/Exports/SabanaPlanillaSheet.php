<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SabanaPlanillaSheet implements FromArray, ShouldAutoSize
{
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    public function array(): array
    {
        $data = [];
        $total = $this->budget->monto ?? 0;
        $iva = $total * 0.12;
        $totalConIva = $total + $iva;

        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', "PLANILLA DE OBRA No 1", '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];

        $data[] = ['', 'EMPRESA PUBLICA MUNICIPAL DE TELECOMUNICACIONES, AGUA POTABLE, ALCANTARILLADO Y SANEAMIENTO DE CUENCA ETAPA E.P', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', 'F', '', '', '', '', ''];
        $data[] = ['', 'Obra:', $this->budget->obra, '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', 'Ubicación:', '', '', 'Número Contrato:', '', $this->budget->no_contrato ?? '', '', '', 'Fiscalizador:', '', $this->budget->fiscalizador ?? '', '', '', '', ''];
        $data[] = ['', 'Período:', 'ENERO - 2026', '', 'Fecha Presentación:', '', '', '', '', 'Contratista:', '', $this->budget->contratista ?? '', '', '', '', ''];
        $data[] = ['', 'Plazo:', $this->budget->plazo_dias ?? '', '', 'Fecha de inicio:', '', $this->budget->fecha_inicio_obra ?? '', '', '', 'Monto:', '', $total, '', '', '', ''];

        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];

        // Cabeceras de la tabla
        $data[] = ['', 'Item', 'Código', 'Descripción del Rubro', 'Unidad', 'Cantidad', 'Contrato', '', 'Cantidades', '', '', 'Importe ($)', '', '', 'AVANCE (%)', '', ''];
        $data[] = ['', '', '', '', '', '', 'Precio Unitario', 'Monto', 'Acumulado Anterior', 'Presente', 'Total a la Fecha', 'Acumulado Anterior', 'Presente', 'Total a la Fecha', 'Acumulado Anterior', 'Presente', 'Total a la Fecha'];

        $counter = 1;
        foreach ($this->budget->items as $item) {
            $data[] = [
                '',
                $counter,
                $item->apu_code,
                $item->apu_name,
                $item->apu_unit,
                $item->quantity,
                $item->unit_price,
                $item->total,
                0,
                $item->quantity,
                $item->quantity,
                0,
                $item->total,
                $item->total,
                0,
                0,
                0
            ];
            $counter++;
        }

        // Totales
        $data[] = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', 'SUBTOTAL', '', '', $total, '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', 'IVA', '15 %', '', $iva, '', '', '', '', '', '', '', '', '', ''];
        $data[] = ['', '', '', 'TOTAL', '', '', $totalConIva, '', '', '', '', '', '', '', '', '', ''];

        return $data;
    }
}