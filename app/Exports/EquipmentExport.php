<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquipmentExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Equipment::all(['code', 'name', 'category', 'unit', 'price', 'termino', 'description']);
    }

    public function headings(): array
    {
        return ['Código', 'Nombre', 'Categoría', 'Unidad', 'Precio', 'Término', 'Descripción'];
    }
}