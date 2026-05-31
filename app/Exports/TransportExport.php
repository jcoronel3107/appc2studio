<?php

namespace App\Exports;

use App\Models\Transport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transport::all(['code', 'name', 'category', 'unit', 'price', 'termino', 'description']);
    }

    public function headings(): array
    {
        return ['Código', 'Nombre', 'Categoría', 'Unidad', 'Precio', 'Término', 'Descripción'];
    }
}