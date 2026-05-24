<?php

namespace App\Imports;

use App\Models\AnalysisHeader;
use App\Models\AnalysisItem;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class ApuImport implements ToCollection, SkipsEmptyRows
{
    private $headerData = [];
    private $wasUpdate = false;  // Agrega esta propiedad
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        
        // Extraer datos de cabecera
        $this->extractHeaderData($rows);
        
        // Verificar si ya existe un APU con este código
        $existing = AnalysisHeader::where('code', $this->headerData['code'] ?? 'SIN_CODIGO')->first();
        
        if ($existing) {
            // Si existe, usar el existente
            $analysisHeader = $existing;
            $this->wasUpdate = true;  // Marcar como actualización
            // Actualizar los datos por si cambiaron
            $analysisHeader->update([
                'name' => $this->headerData['rubro'] ?? 'SIN_NOMBRE',
                'unit' => $this->headerData['unidad'] ?? 'SIN_UNIDAD',
            ]);
            
            // Eliminar items viejos para reemplazarlos con los nuevos
            AnalysisItem::where('analysis_header_id', $analysisHeader->id)->delete();
            
            Log::info('APU actualizado: ' . $this->headerData['code']);
        } else {
            // Crear nuevo APU
            $analysisHeader = AnalysisHeader::create([
                'code' => $this->headerData['code'] ?? 'SIN_CODIGO',
                'name' => $this->headerData['rubro'] ?? 'SIN_NOMBRE',
                'unit' => $this->headerData['unidad'] ?? 'SIN_UNIDAD',
            ]);
              $this->wasUpdate = false; // Marcar como creación
            Log::info('APU creado: ' . $this->headerData['code']);
        }
        
        // Procesar cada sección
        $this->processEquipmentSection($rows, $analysisHeader->id);
        $this->processLaborSection($rows, $analysisHeader->id);
        $this->processMaterialsSection($rows, $analysisHeader->id);
        $this->processTransportSection($rows, $analysisHeader->id);
        
        // Extraer totales
        $this->extractTotals($rows, $analysisHeader->id);
    }
     public function wasUpdate()
    {
        return $this->wasUpdate;
    }
    private function extractHeaderData($rows)
    {
        foreach ($rows as $row) {
            if (isset($row[0]) && $row[0] == 'CÓDIGO') {
                $this->headerData['code'] = $row[1] ?? null;
            }
            if (isset($row[0]) && $row[0] == 'RUBRO:') {
                $this->headerData['rubro'] = $row[1] ?? null;
                if (isset($row[7]) && $row[7] == 'UNIDAD:') {
                    $this->headerData['unidad'] = $row[8] ?? null;
                }
            }
        }
    }
    
    private function processEquipmentSection($rows, $headerId)
    {
        $startRow = $this->findSectionStart($rows, 'EQUIPOS');
        if (!$startRow) return;
        
        $position = 0;
        for ($i = $startRow + 2; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (isset($row[0]) && (strpos($row[0], 'SUBTOTAL') !== false || $row[0] == 'MANO DE OBRA')) {
                break;
            }
            
            if (!empty($row[0]) && $row[0] != 'Descripción') {
                AnalysisItem::create([
                    'analysis_header_id' => $headerId,
                    'section' => 'equipment',
                    'description' => $row[0],
                    'quantity' => floatval($row[2] ?? 0),
                    'unit_price' => floatval($row[3] ?? 0),
                    'performance' => floatval($row[5] ?? 0),
                    'total' => floatval($row[6] ?? 0),
                    'row_position' => $position++,
                ]);
            }
        }
    }
    
    private function processLaborSection($rows, $headerId)
    {
        $startRow = $this->findSectionStart($rows, 'MANO DE OBRA');
        if (!$startRow) return;
        
        $position = 0;
        for ($i = $startRow + 2; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (isset($row[0]) && (strpos($row[0], 'SUBTOTAL') !== false || $row[0] == 'MATERIALES')) {
                break;
            }
            
            if (!empty($row[0]) && $row[0] != 'Descripción') {
                AnalysisItem::create([
                    'analysis_header_id' => $headerId,
                    'section' => 'labor',
                    'description' => $row[0],
                    'quantity' => floatval($row[2] ?? 0),
                    'unit_price' => floatval($row[3] ?? 0),
                    'performance' => floatval($row[5] ?? 0),
                    'total' => floatval($row[6] ?? 0),
                    'row_position' => $position++,
                ]);
            }
        }
    }
    
    private function processMaterialsSection($rows, $headerId)
    {
        $startRow = $this->findSectionStart($rows, 'MATERIALES');
        if (!$startRow) return;
        
        $position = 0;
        for ($i = $startRow + 2; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (isset($row[0]) && (strpos($row[0], 'SUBTOTAL') !== false || $row[0] == 'TRANSPORTE')) {
                break;
            }
            
            if (!empty($row[0]) && $row[0] != 'Descripción') {
                AnalysisItem::create([
                    'analysis_header_id' => $headerId,
                    'section' => 'material',
                    'description' => $row[0],
                    'quantity' => floatval($row[4] ?? 0),
                    'unit_price' => floatval($row[5] ?? 0),
                    'total' => floatval($row[6] ?? 0),
                    'row_position' => $position++,
                ]);
            }
        }
    }
    
    private function processTransportSection($rows, $headerId)
    {
        $startRow = $this->findSectionStart($rows, 'TRANSPORTE');
        if (!$startRow) return;
        
        $position = 0;
        for ($i = $startRow + 2; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (isset($row[0]) && strpos($row[0], 'SUBTOTAL') !== false) {
                break;
            }
            
            if (!empty($row[0]) && $row[0] != 'Descripción') {
                AnalysisItem::create([
                    'analysis_header_id' => $headerId,
                    'section' => 'transport',
                    'description' => $row[0],
                    'quantity' => floatval($row[4] ?? 0),
                    'unit_price' => floatval($row[5] ?? 0),
                    'total' => floatval($row[6] ?? 0),
                    'row_position' => $position++,
                ]);
            }
        }
    }
    
    private function extractTotals($rows, $headerId)
    {
        foreach ($rows as $row) {
            if (isset($row[3]) && strpos($row[3], 'TOTAL COSTO DIRECTO') !== false) {
                AnalysisHeader::where('id', $headerId)->update([
                    'total_direct_cost' => floatval($row[6] ?? 0)
                ]);
            }
            if (isset($row[3]) && strpos($row[3], 'INDIRECTOS Y UTILIDADES:') !== false) {
                AnalysisHeader::where('id', $headerId)->update([
                    'indirect_cost' => floatval($row[6] ?? 0)
                ]);
            }
            if (isset($row[3]) && strpos($row[3], 'COSTO TOTAL DEL RUBRO') !== false) {
                AnalysisHeader::where('id', $headerId)->update([
                    'total_cost' => floatval($row[6] ?? 0)
                ]);
            }
        }
    }
    
    private function findSectionStart($rows, $sectionName)
    {
        foreach ($rows as $index => $row) {
            if (isset($row[0]) && trim($row[0]) === $sectionName) {
                return $index;
            }
        }
        return null;
    }
}