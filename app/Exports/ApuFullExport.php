<?php

namespace App\Exports;

use App\Models\AnalysisHeader;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ApuFullExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $apu;
    
    public function __construct($apuId)
    {
        $this->apu = AnalysisHeader::with('items')->findOrFail($apuId);
    }
    
    public function array(): array
    {
        $data = [];
        
        // ===== CABECERA =====
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['', 'ANÁLISIS DE PRECIOS UNITARIOS', '', '', '', ''];
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['CÓDIGO:', $this->apu->code, '', '', '', ''];
        $data[] = ['RUBRO:', $this->apu->name, '', '', 'UNIDAD:', $this->apu->unit];
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', ''];
        
        // ===== EQUIPOS =====
        $equipos = $this->apu->items->where('section', 'equipment');
        if ($equipos->count() > 0) {
            $data[] = ['EQUIPOS', '', '', '', '', ''];
            $data[] = ['Descripción', '', 'Cantidad', 'Tarifa', 'Costo Hora', 'Costo'];
            
            $subtotalEquipos = 0;
            foreach ($equipos as $item) {
                $data[] = [
                    $item->description,
                    '',
                    $item->quantity,
                    $item->unit_price,
                    $item->performance ?? '',
                    $item->total
                ];
                $subtotalEquipos += $item->total;
            }
            $data[] = ['SUBTOTAL M', '', '', '', '', $subtotalEquipos];
            $data[] = ['', '', '', '', '', ''];
        }
        
        // ===== MANO DE OBRA =====
        $labor = $this->apu->items->where('section', 'labor');
        if ($labor->count() > 0) {
            $data[] = ['MANO DE OBRA', '', '', '', '', ''];
            $data[] = ['Descripción', '', 'Cantidad', 'Jornal/HR', 'Costo Hora', 'Costo'];
            
            $subtotalLabor = 0;
            foreach ($labor as $item) {
                $data[] = [
                    $item->description,
                    '',
                    $item->quantity,
                    $item->unit_price,
                    $item->performance ?? '',
                    $item->total
                ];
                $subtotalLabor += $item->total;
            }
            $data[] = ['SUBTOTAL N', '', '', '', '', $subtotalLabor];
            $data[] = ['', '', '', '', '', ''];
        }
        
        // ===== MATERIALES =====
        $materiales = $this->apu->items->where('section', 'material');
        if ($materiales->count() > 0) {
            $data[] = ['MATERIALES', '', '', '', '', ''];
            $data[] = ['Descripción', '', 'Unidad', 'Cantidad', 'Precio Unit.', 'Costo'];
            
            $subtotalMateriales = 0;
            foreach ($materiales as $item) {
                $data[] = [
                    $item->description,
                    '',
                    '',
                    $item->quantity,
                    $item->unit_price,
                    $item->total
                ];
                $subtotalMateriales += $item->total;
            }
            $data[] = ['SUBTOTAL O', '', '', '', '', $subtotalMateriales];
            $data[] = ['', '', '', '', '', ''];
        }
        
        // ===== TRANSPORTE =====
        $transporte = $this->apu->items->where('section', 'transport');
        if ($transporte->count() > 0) {
            $data[] = ['TRANSPORTE', '', '', '', '', ''];
            $data[] = ['Descripción', '', 'Unidad', 'Cantidad', 'Tarifa', 'Costo'];
            
            $subtotalTransporte = 0;
            foreach ($transporte as $item) {
                $data[] = [
                    $item->description,
                    '',
                    '',
                    $item->quantity,
                    $item->unit_price,
                    $item->total
                ];
                $subtotalTransporte += $item->total;
            }
            $data[] = ['SUBTOTAL P', '', '', '', '', $subtotalTransporte];
            $data[] = ['', '', '', '', '', ''];
        }
        
        // ===== TOTALES =====
        $totalDirecto = $this->apu->total_direct_cost ?? 0;
        $indirectos = $this->apu->indirect_cost ?? 0;
        $totalGeneral = $this->apu->total_cost ?? 0;
        
        $data[] = ['', '', '', 'TOTAL COSTO DIRECTO (M+N+O+P)', '', $totalDirecto];
        $data[] = ['', '', '', 'INDIRECTOS Y UTILIDADES: 20.00 %', '', $indirectos];
        $data[] = ['', '', '', 'OTROS INDIRECTOS: 0.00 %', '', 0];
        $data[] = ['', '', '', 'COSTO TOTAL DEL RUBRO', '', $totalGeneral];
        $data[] = ['', '', '', 'VALOR OFERTADO', '', $totalGeneral];
        
        return $data;
    }
    
    public function headings(): array
    {
        return [];
    }
    
    public function styles(Worksheet $sheet)
    {
        // Dar formato a las celdas
        $lastRow = $sheet->getHighestRow();
        
        // Formato para títulos
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Formato para encabezados de sección
        $sheet->getStyle('A8')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
        ]);
        
        // Formato para subtotales
        for ($i = 1; $i <= $lastRow; $i++) {
            $cell = $sheet->getCell('A' . $i);
            if (strpos($cell->getValue(), 'SUBTOTAL') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2EFDA']],
                ]);
            }
        }
        
        // Formato para totales finales
        $sheet->getStyle('A' . ($lastRow-4) . ':F' . $lastRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
        ]);
        
        return [];
    }
}