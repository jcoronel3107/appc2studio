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

class BudgetHierarchicalExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $budget;

    public function __construct($budgetId)
    {
        $this->budget = Budget::with('items')->findOrFail($budgetId);
    }

    public function array(): array
    {
        $data = [];
        
        // ============================================================
        // CABECERA DEL PRESUPUESTO
        // ============================================================
        $data[] = ['PRESUPUESTO DE OBRA', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['OBRA:', $this->budget->obra, '', '', '', ''];
        $data[] = ['CONTRATISTA:', $this->budget->contratista ?? '-', '', '', '', ''];
        $data[] = ['FISCALIZADOR:', $this->budget->fiscalizador ?? '-', '', '', '', ''];
        $data[] = ['PLAZO (DIAS):', $this->budget->plazo_dias ?? '-', '', '', '', ''];
        $data[] = ['FECHA DE INICIO:', $this->budget->fecha_inicio_obra ? \Carbon\Carbon::parse($this->budget->fecha_inicio_obra)->format('d/m/Y') : '-', '', '', '', ''];
        $data[] = ['FECHA DE TERMINACIÓN:', $this->budget->fecha_terminacion_plazo ? \Carbon\Carbon::parse($this->budget->fecha_terminacion_plazo)->format('d/m/Y') : '-', '', '', '', ''];
        $data[] = ['', '', '', '', '', ''];
        
        // ============================================================
        // ORGANIZAR DATOS: Capítulo → Hito → Categoría → APU
        // ============================================================
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
        
        // ============================================================
        // DETALLE DEL PRESUPUESTO
        // ============================================================
        $data[] = ['CÓDIGO', 'DESCRIPCIÓN', 'UNIDAD', 'CANTIDAD', 'PRECIO UNIT.', 'TOTAL'];
        $data[] = ['', '', '', '', '', ''];
        
        $totalGeneral = 0;
        $chapterCounter = 1;
        
        foreach ($estructura as $chapterKey => $chapter) {
            // --- CAPÍTULO ---
            $subtotalCapitulo = 0;
            
            // Primero calculamos el subtotal del capítulo
            foreach ($chapter['hitos'] as $milestone) {
                foreach ($milestone['categorias'] as $categoria) {
                    foreach ($categoria['items'] as $item) {
                        $subtotalCapitulo += $item->total;
                    }
                }
            }
            
            // Fila del CAPÍTULO con su total al final
            $data[] = [
                '📚 ' . $chapter['code'],
                $chapter['name'],
                '',
                '',
                'SUBTOTAL CAPÍTULO:',
                number_format($subtotalCapitulo, 2)
            ];
            
            foreach ($chapter['hitos'] as $milestoneKey => $milestone) {
                // --- HITO ---
                $subtotalHito = 0;
                foreach ($milestone['categorias'] as $categoria) {
                    foreach ($categoria['items'] as $item) {
                        $subtotalHito += $item->total;
                    }
                }
                
                // Fila del HITO con su total al final
                $data[] = [
                    '    🎯 ' . $milestone['code'],
                    $milestone['name'],
                    '',
                    '',
                    'SUBTOTAL HITO:',
                    number_format($subtotalHito, 2)
                ];
                
                foreach ($milestone['categorias'] as $categoryKey => $categoria) {
                    // --- CATEGORÍA ---
                    $subtotalCategoria = 0;
                    foreach ($categoria['items'] as $item) {
                        $subtotalCategoria += $item->total;
                    }
                    
                    // Fila de la CATEGORÍA con su total al final
                    $data[] = [
                        '        📁 ' . $categoria['code'],
                        $categoria['name'],
                        '',
                        '',
                        'SUBTOTAL CATEGORÍA:',
                        number_format($subtotalCategoria, 2)
                    ];
                    
                    // APUs de la categoría
                    foreach ($categoria['items'] as $item) {
                        $totalGeneral += $item->total;
                        
                        $data[] = [
                            '            📋 ' . $item->apu_code,
                            $item->apu_name,
                            $item->apu_unit,
                            number_format($item->quantity, 2),
                            number_format($item->unit_price, 2),
                            number_format($item->total, 2)
                        ];
                    }
                }
            }
            
            // Espacio entre capítulos
            $data[] = ['', '', '', '', '', ''];
        }
        
        // ============================================================
        // TOTAL GENERAL (SIN ANTICIPO)
        // ============================================================
        $data[] = ['', '', '', '', '', ''];
        $data[] = ['', '', '', '', 'TOTAL PRESUPUESTO:', number_format($totalGeneral, 2)];
        
        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        // ============================================================
        // BORDES PARA TODAS LAS CELDAS CON DATOS
        // ============================================================
        $sheet->getStyle('A1:F' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);
        
        // ============================================================
        // TÍTULO PRINCIPAL
        // ============================================================
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // ============================================================
        // CABECERA (OBRA, CONTRATISTA, ETC)
        // ============================================================
        $sheet->getStyle('A3:F8')->applyFromArray([
            'font' => ['size' => 11],
        ]);
        
        // ============================================================
        // CABECERAS DE LA TABLA
        // ============================================================
        $sheet->getStyle('A11:F11')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // ============================================================
        // FORMATO JERÁRQUICO POR NIVELES
        // ============================================================
        for ($i = 1; $i <= $lastRow; $i++) {
            $cellA = $sheet->getCell('A' . $i);
            $cellE = $sheet->getCell('E' . $i);
            $valueA = $cellA->getValue();
            $valueE = $cellE->getValue();
            
            // --- CAPÍTULOS ---
            if (is_string($valueA) && strpos($valueA, '📚') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                ]);
                // Alinear total del capítulo a la derecha
                $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
            
            // --- HITOS ---
            if (is_string($valueA) && strpos($valueA, '🎯') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2EFDA']],
                ]);
                $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
            
            // --- CATEGORÍAS ---
            if (is_string($valueA) && strpos($valueA, '📁') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE4D6']],
                ]);
                $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
            
            // --- APUs ---
            if (is_string($valueA) && strpos($valueA, '📋') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['size' => 10],
                ]);
                $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            }
            
            // --- SUBTOTALES en columna E ---
            if (is_string($valueE) && strpos($valueE, 'SUBTOTAL') !== false) {
                $sheet->getStyle('A' . $i . ':F' . $i)->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF2CC']],
                ]);
            }
        }
        
        // ============================================================
        // TOTAL GENERAL
        // ============================================================
        $sheet->getStyle('E' . $lastRow . ':F' . $lastRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
        ]);
        $sheet->getStyle('F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        // ============================================================
        // FORMATO DE NÚMEROS
        // ============================================================
        $sheet->getStyle('F13:F' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
        
        // ============================================================
        // ALINEACIÓN DE COLUMNAS
        // ============================================================
        $sheet->getStyle('C13:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D13:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E13:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        // ============================================================
        // ALTURA DE FILAS
        // ============================================================
        for ($i = 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(18);
        }
        $sheet->getRowDimension(11)->setRowHeight(22);
        
        return [];
    }
}