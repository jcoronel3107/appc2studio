<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResumenP1Sheet implements FromArray, ShouldAutoSize
{
    protected $budget;

    public function __construct(Budget $budget)
    {
        $this->budget = $budget;
    }

    public function array(): array
    {
        $data = [];
        $data[] = ['', 'RESUMEN DE CANTIDADES', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', ''];
        $data[] = ['', 'Item', 'Descripción del Rubro', 'Unidad', 'SAN MARTÍN', 'QUEBRADA', 'TOTAL'];
        $data[] = ['', '', '', '', 'Cantidad', 'Cantidad', ''];

        $counter = 1;
        foreach ($this->budget->items as $item) {
            $data[] = [
                $counter,
                $item->apu_code,
                $item->apu_name,
                $item->apu_unit,
                $item->quantity,
                0,
                $item->quantity
            ];
            $counter++;
        }

        return $data;
    }
}