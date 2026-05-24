<?php

namespace App\Exports;

use App\Models\AnalysisHeader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ApuExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $apuId;
    
    public function __construct($apuId = null)
    {
        $this->apuId = $apuId;
    }
    
    public function collection()
    {
        if ($this->apuId) {
            // Exportar un APU específico con sus items
            $apu = AnalysisHeader::with('items')->findOrFail($this->apuId);
            return collect($apu->items);
        }
        
        // Exportar todos los APUs (resumen)
        return AnalysisHeader::all();
    }
    
    public function headings(): array
    {
        if ($this->apuId) {
            // Headers para exportar items de un APU
            return [
                'Sección',
                'Descripción',
                'Cantidad',
                'Precio Unitario',
                'Rendimiento',
                'Total'
            ];
        }
        
        // Headers para resumen de APUs
        return [
            'Código',
            'Rubro',
            'Unidad',
            'Costo Directo',
            'Indirectos (20%)',
            'Costo Total',
            'Fecha Creación'
        ];
    }
    
    public function map($item): array
    {
        if ($this->apuId) {
            // Mapeo para items de un APU
            $sections = [
                'equipment' => 'EQUIPOS',
                'labor' => 'MANO DE OBRA',
                'material' => 'MATERIALES',
                'transport' => 'TRANSPORTE'
            ];
            
            return [
                $sections[$item->section] ?? $item->section,
                $item->description,
                $item->quantity,
                $item->unit_price,
                $item->performance ?? '-',
                $item->total
            ];
        }
        
        // Mapeo para resumen de APUs
        return [
            $item->code,
            $item->name,
            $item->unit,
            $item->total_direct_cost ?? 0,
            $item->indirect_cost ?? 0,
            $item->total_cost ?? 0,
            $item->created_at->format('d/m/Y H:i')
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}