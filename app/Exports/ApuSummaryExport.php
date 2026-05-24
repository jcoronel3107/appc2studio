<?php

namespace App\Exports;

use App\Models\AnalysisHeader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApuSummaryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return AnalysisHeader::all(['code', 'name', 'unit', 'total_direct_cost', 'indirect_cost', 'total_cost', 'created_at']);
    }
    
    public function headings(): array
    {
        return [
            'CÓDIGO',
            'RUBRO',
            'UNIDAD',
            'COSTO DIRECTO',
            'INDIRECTOS (20%)',
            'COSTO TOTAL',
            'FECHA CREACIÓN'
        ];
    }
}