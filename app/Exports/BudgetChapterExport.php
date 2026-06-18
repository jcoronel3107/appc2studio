<?php

namespace App\Exports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BudgetChapterExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $budget;

    public function __construct($budgetId)
    {
        $this->budget = Budget::with('items')->findOrFail($budgetId);
    }

    public function collection()
    {
        $data = [];
        
        // ===== CABECERA DEL PRESUPUESTO =====
        $data[] = ['', 'PROYECTO:', $this->budget->obra, '', '', '', '', '', ''];
        $data[] = ['', 'UBICACIÓN:', '', '', '', '', '', '', ''];
        $data[] = ['', 'CONTRATO Nº:', $this->budget->no_contrato ?? '', '', '', '', '', '', ''];
        $data[] = ['', 'MONTO (SIN IVA):', '', 'FECHA DEL CONTRATO:', $this->budget->fecha_contrato ? \Carbon\Carbon::parse($this->budget->fecha_contrato)->format('d/m/Y') : '', '', '', '', ''];
        $data[] = ['', 'MONTO DE ANTICIPO:', number_format($this->budget->monto_anticipo ?? 0, 2), 'FECHA DE ENTREGA DE ANTICIPO:', $this->budget->fecha_entrega_anticipo ? \Carbon\Carbon::parse($this->budget->fecha_entrega_anticipo)->format('d/m/Y') : '', '', '', '', ''];
        $data[] = ['', 'CONTRATISTA:', $this->budget->contratista ?? '', 'FECHA DE INICIO DE OBRA :', $this->budget->fecha_inicio_obra ? \Carbon\Carbon::parse($this->budget->fecha_inicio_obra)->format('d/m/Y') : '', '', '', '', ''];
        $data[] = ['', 'FISCALIZADOR:', $this->budget->fiscalizador ?? '', 'PLAZO ( DIAS):', $this->budget->plazo_dias ?? '', '', '', '', ''];
        $data[] = ['', 'ADMINISTRADOR:', $this->budget->administrador ?? '', 'AMPLIACIÓN DE PLAZO (DIAS):', $this->budget->ampliacion_plazo ?? 0, '', '', '', ''];
        $data[] = ['', 'PERIODO:', '', 'FECHA TERMINACION DE PLAZO:', $this->budget->fecha_terminacion_plazo ? \Carbon\Carbon::parse($this->budget->fecha_terminacion_plazo)->format('d/m/Y') : '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '', '', ''];
        
        // ===== ENCABEZADO DE LA TABLA =====
        $data[] = ['', 'PRESUPUESTO', '', '', '', '', '', '', ''];
        $data[] = ['', 'Codigo', 'Item', 'Descripción', 'Unidad', 'Cantidad', 'Precio Unitario', 'Precio Total', ''];
        
        // ===== DATOS =====
        // Organizar datos por capítulo, hito y categoría
        $capitulos = [];
        foreach ($this->budget->items as $item) {
            $chapterKey = $item->chapter_code ?? 'sin_capitulo';
            if (!isset($capitulos[$chapterKey])) {
                $capitulos[$chapterKey] = [
                    'code' => $item->chapter_code,
                    'name' => $item->chapter_name,
                    'items' => []
                ];
            }
            $capitulos[$chapterKey]['items'][] = $item;
        }
        
        $totalGeneral = 0;
        $chapterCounter = 1;
        
        foreach ($capitulos as $chapter) {
            // Título del capítulo
            $chapterTotal = 0;
            $data[] = ['', '', $chapter['code'] . ' ' . $chapter['name'], '', '', '', '', '', ''];
            
            $itemCounter = 1;
            foreach ($chapter['items'] as $item) {
                $chapterTotal += $item->total;
                $totalGeneral += $item->total;
                
                $data[] = [
                    '',
                    $item->apu_code,
                    $chapter['code'] . '.' . $itemCounter,
                    $item->apu_name,
                    $item->apu_unit,
                    $item->quantity,
                    $item->unit_price,
                    $item->total,
                    ''
                ];
                $itemCounter++;
            }
            
            // Subtotal del capítulo
            $data[] = ['', '', '', '', '', '', '', $chapterTotal, ''];
            $data[] = ['', '', '', '', '', '', '', '', ''];
        }
        
        // ===== TOTAL GENERAL =====
        $data[] = ['', '', '', '', '', '', 'TOTAL', $totalGeneral, ''];
        
        // ===== TEXTO EN LETRAS =====
        $data[] = ['Son ' . $this->numeroALetras($totalGeneral), '', '', '', '', '', '', '', ''];
        
        return collect($data);
    }

    public function headings(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        
        // Formato para la cabecera del presupuesto
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
        ]);
        
        // Formato para "PRESUPUESTO"
        $sheet->getStyle('B11')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Formato para la cabecera de la tabla
        $sheet->getStyle('B12:I12')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        
        // Formato para los títulos de capítulos
        for ($i = 1; $i <= $lastRow; $i++) {
            $cell = $sheet->getCell('C' . $i);
            $value = $cell->getValue();
            if (is_string($value) && preg_match('/^\d+\.\d+\s/', $value)) {
                $sheet->getStyle('B' . $i . ':I' . $i)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                ]);
            }
        }
        
        // Formato para el total general
        $sheet->getStyle('G' . ($lastRow-1) . ':I' . ($lastRow-1))->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFC000']],
        ]);
        
        // Formato para números
        $sheet->getStyle('H13:H' . $lastRow)->getNumberFormat()->setFormatCode('#,##0.00');
        
        return [];
    }

    private function numeroALetras($numero)
    {
        // Función para convertir número a letras
        $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        
        $entero = intval($numero);
        $decimales = round(($numero - $entero) * 100);
        
        if ($entero == 0) {
            return 'cero con ' . $decimales . '/100 dólares';
        }
        
        $partes = [];
        $millones = intval($entero / 1000000);
        $resto = $entero % 1000000;
        $miles = intval($resto / 1000);
        $unidades_resto = $resto % 1000;
        
        if ($millones > 0) {
            $partes[] = ($millones == 1 ? 'un millón' : $this->numeroALetrasSimple($millones) . ' millones');
        }
        
        if ($miles > 0) {
            $partes[] = ($miles == 1 ? 'un mil' : $this->numeroALetrasSimple($miles) . ' mil');
        }
        
        if ($unidades_resto > 0) {
            $partes[] = $this->numeroALetrasSimple($unidades_resto);
        }
        
        $texto = implode(' ', $partes);
        
        if ($decimales > 0) {
            $texto .= ' con ' . $decimales . '/100';
        }
        
        return $texto . ' dólares';
    }

    private function numeroALetrasSimple($numero)
    {
        $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        
        $c = intval($numero / 100);
        $d = intval(($numero % 100) / 10);
        $u = $numero % 10;
        
        $texto = '';
        
        if ($c > 0) {
            $texto .= $centenas[$c];
            if ($d > 0 || $u > 0) {
                $texto .= ' ';
            }
        }
        
        if ($d > 0) {
            if ($d == 1 && $u > 0) {
                $texto .= $this->decenasEspeciales($u);
            } else {
                $texto .= $decenas[$d];
                if ($u > 0) {
                    $texto .= ' y ';
                }
            }
        }
        
        if ($u > 0 && $d != 1) {
            $texto .= $unidades[$u];
        }
        
        return trim($texto);
    }

    private function decenasEspeciales($u)
    {
        $especiales = ['', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        return $especiales[$u];
    }
}