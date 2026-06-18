<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BudgetCompleteExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $budget;

    public function __construct($budgetId)
    {
        $this->budget = Budget::with('items')->findOrFail($budgetId);
    }

    public function array(): array
    {
        $data = [];
        
        // Cabecera del presupuesto
        $data[] = ['PRESUPUESTO DE OBRA', '', '', '', '', ''];
        $data[] = ['OBRA:', $this->budget->obra, '', '', '', ''];
        $data[] = ['CONTRATISTA:', $this->budget->contratista ?? '-', '', '', '', ''];
        $data[] = ['FISCALIZADOR:', $this->budget->fiscalizador ?? '-', '', '', '', ''];
        $data[] = ['MONTO DE ANTICIPO:', '$' . number_format($this->budget->monto_anticipo ?? 0, 2), '', '', '', ''];
        $data[] = ['PLAZO (DIAS):', $this->budget->plazo_dias ?? '-', '', '', '', ''];
        $data[] = ['', '', '', '', '', ''];
        
        // Organizar datos por Capítulo → Hito → Categoría → APU
        $estructura = [];
        foreach ($this->budget->items as $item) {
            $chapterKey = $item->chapter_code ?? 'sin_capitulo';
            if (!isset($estructura[$chapterKey])) {
                $estructura[$chapterKey] = [
                    'code' => $item->chapter_code,
                    'name' => $item->chapter_name,
                    'hitos' => []
                ];
            }
            $milestoneKey = $item->milestone_id ?? 'sin_hito';
            if (!isset($estructura[$chapterKey]['hitos'][$milestoneKey])) {
                $estructura[$chapterKey]['hitos'][$milestoneKey] = [
                    'code' => $item->milestone_code,
                    'name' => $item->milestone_name,
                    'categorias' => []
                ];
            }
            $categoryKey = $item->category_code ?? $item->category;
            if (!isset($estructura[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey])) {
                $estructura[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey] = [
                    'code' => $categoryKey,
                    'name' => $item->category,
                    'items' => []
                ];
            }
            $estructura[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey]['items'][] = $item;
        }
        
        // Cabeceras de la tabla
        $data[] = ['CÓDIGO', 'DESCRIPCIÓN', 'UNIDAD', 'CANTIDAD', 'PRECIO UNIT.', 'TOTAL'];
        $data[] = ['', '', '', '', '', ''];
        
        $totalGeneral = 0;
        
        foreach ($estructura as $chapterKey => $chapter) {
            // --- CAPÍTULO ---
            $subtotalCapitulo = 0;
            $data[] = [$chapter['code'], strtoupper($chapter['name']), '', '', '', ''];
            
            foreach ($chapter['hitos'] as $milestoneKey => $milestone) {
                // --- HITO ---
                $subtotalHito = 0;
                $data[] = ['  ' . $milestone['code'], '  ' . $milestone['name'], '', '', '', ''];
                
                foreach ($milestone['categorias'] as $categoryKey => $categoria) {
                    // --- CATEGORÍA ---
                    $subtotalCategoria = 0;
                    $data[] = ['    ' . $categoria['code'], '    ' . $categoria['name'], '', '', '', ''];
                    
                    foreach ($categoria['items'] as $item) {
                        $subtotalCategoria += $item->total;
                        $subtotalHito += $item->total;
                        $subtotalCapitulo += $item->total;
                        $totalGeneral += $item->total;
                        
                        $data[] = [
                            '      ' . $item->apu_code,
                            '      ' . $item->apu_name,
                            $item->apu_unit,
                            number_format($item->quantity, 2),
                            number_format($item->unit_price, 2),
                            number_format($item->total, 2)
                        ];
                    }
                    
                    // Subtotal de CATEGORÍA (con el nombre)
                    $data[] = ['', '', '', '', 'SUBTOTAL CATEGORÍA ' . $categoria['code'] . ' - ' . strtoupper($categoria['name']) . ':', number_format($subtotalCategoria, 2)];
                    $data[] = ['', '', '', '', '', ''];
                }
                
                // Subtotal de HITO (con el nombre)
                $data[] = ['', '', '', '', 'SUBTOTAL HITO ' . $milestone['code'] . ' - ' . strtoupper($milestone['name']) . ':', number_format($subtotalHito, 2)];
                $data[] = ['', '', '', '', '', ''];
            }
            
            // Subtotal de CAPÍTULO (con el nombre)
            $data[] = ['', '', '', '', 'SUBTOTAL CAPÍTULO ' . $chapter['code'] . ' - ' . strtoupper($chapter['name']) . ':', number_format($subtotalCapitulo, 2)];
            $data[] = ['', '', '', '', '', ''];
        }
        
        // Totales finales
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['', '', '', '', 'TOTAL COSTO DIRECTO:', '$' . number_format($totalGeneral, 2)];
        $data[] = ['', '', '', '', 'MONTO ANTICIPO:', '$' . number_format($this->budget->monto_anticipo ?? 0, 2)];
        $data[] = ['', '', '', '', 'TOTAL PRESUPUESTO:', '$' . number_format($totalGeneral - ($this->budget->monto_anticipo ?? 0), 2)];
        
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        // Aplicar bordes a TODAS las celdas con datos
        $sheet->getStyle('A1:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        
        // Título principal
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Datos de cabecera (filas 2-7)
        $sheet->getStyle('A2:F7')->applyFromArray([
            'font' => ['size' => 11],
        ]);
        $sheet->getStyle('A2:F7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        
        // Cabeceras de tabla
        $sheet->getStyle('A8:F9')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        
        // Formatear todas las filas
        for ($i = 1; $i <= $lastRow; $i++) {
            $cellA = $sheet->getCell('A' . $i);
            $cellE = $sheet->getCell('E' . $i);
            $valueA = $cellA->getValue();
            $valueE = $cellE->getValue();
            
            // Identificar CAPÍTULOS (sin indentación, con número y punto)
            if (is_string($valueA) && preg_match('/^\d+\.0$/', trim($valueA)) && strpos($valueA, '  ') === false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                ]);
            }
            
            // Identificar HITOS (1 nivel de indentación)
            if (is_string($valueA) && strpos($valueA, '  ') === 0 && strpos($valueA, '    ') === false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2EFDA']],
                ]);
            }
            
            // Identificar CATEGORÍAS (2 niveles de indentación)
            if (is_string($valueA) && strpos($valueA, '    ') === 0 && strpos($valueA, '      ') === false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE4D6']],
                ]);
            }
            
            // Identificar APUs (3 niveles de indentación)
            if (is_string($valueA) && strpos($valueA, '      ') === 0) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['size' => 10],
                ]);
            }
            
            // Subtotales (columna E contiene "SUBTOTAL")
            if (is_string($valueE) && strpos($valueE, 'SUBTOTAL') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2CC']],
                ]);
            }
        }
        
        // Totales finales (últimas 4 filas)
        $sheet->getStyle('A' . ($lastRow-3) . ':F' . $lastRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
        ]);
        
        // Alinear los totales a la derecha
        $sheet->getStyle('F' . ($lastRow-3) . ':F' . $lastRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);
        
        // Formato de números para la columna TOTAL (F)
        $sheet->getStyle('F10:F' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
        
        // Centrar las columnas de Unidad, Cantidad y Precio
        $sheet->getStyle('C10:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D10:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E10:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        // Ajustar altura de filas
        for ($i = 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(18);
        }
        
        // Fila de cabecera más alta
        $sheet->getRowDimension(8)->setRowHeight(22);
        
        return [];
    }
}