<?php

namespace App\Exports;

use App\Models\Labor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaborExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Labor::all(['code', 'name', 'category', 'unit', 'hourly_rate', 'daily_rate', 'termino', 'description']);
    }

    public function headings(): array
    {
        return ['Código', 'Nombre', 'Categoría', 'Unidad', 'Tarifa Hora', 'Tarifa Día', 'Término', 'Descripción'];
    }
}