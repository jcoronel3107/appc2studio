<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Material::all(['code', 'name', 'unit', 'price', 'category', 'description']);
    }

    public function headings(): array
    {
        return [
            'Código',
            'Nombre',
            'Unidad',
            'Precio',
            'Categoría',
            'Descripción'
        ];
    }
}