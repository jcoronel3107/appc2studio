<?php

namespace App\Imports;

use App\Models\Labor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LaborImport implements ToModel, WithHeadingRow, WithValidation
{
    private function limpiarNumero($valor)
    {
        // Si es null o vacío
        if (empty($valor)) return 0;
        
        // Si es fórmula, extraer valor o retornar 0
        if (is_string($valor) && strpos($valor, '=') === 0) {
            // Intentar extraer número de la fórmula
            preg_match('/[\d\.]+/', $valor, $matches);
            return isset($matches[0]) ? floatval($matches[0]) : 0;
        }
        
        // Si es string con número
        if (is_string($valor)) {
            $valor = preg_replace('/[^0-9.-]/', '', $valor);
        }
        
        return floatval($valor);
    }

    private function limpiarTexto($valor)
    {
        if (empty($valor)) return null;
        
        // Si es fórmula, retornar vacío
        if (is_string($valor) && strpos($valor, '=') === 0) {
            return null;
        }
        
        return trim($valor);
    }

    public function model(array $row)
    {
        // Limpiar unidad: si contiene "costo*hora", cambiarlo a "hora"
        $unidad = $this->limpiarTexto($row['unidad'] ?? $row['unit'] ?? 'hora');
        if (strpos($unidad, 'costo') !== false || strpos($unidad, '*') !== false) {
            $unidad = 'hora';
        }
        
        $tarifaHora = $this->limpiarNumero($row['tarifa_hora'] ?? $row['hourly_rate'] ?? 0);
        $tarifaDia = $this->limpiarNumero($row['tarifa_dia'] ?? $row['daily_rate'] ?? 0);
        
        // Si tarifa_dia es 0 pero tarifa_hora tiene valor, calcular tarifa_dia
        if ($tarifaDia == 0 && $tarifaHora > 0) {
            $tarifaDia = $tarifaHora * 8;
        }

        return new Labor([
            'code' => $this->limpiarTexto($row['codigo'] ?? $row['code']),
            'name' => $this->limpiarTexto($row['nombre'] ?? $row['name']),
            'category' => $this->limpiarTexto($row['categoria'] ?? $row['category']),
            'unit' => $unidad,
            'hourly_rate' => $tarifaHora,
            'daily_rate' => $tarifaDia,
            'termino' => $this->limpiarTexto($row['termino']),
            'description' => $this->limpiarTexto($row['descripcion'] ?? $row['description']),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.codigo' => 'required|unique:labors,code',
            '*.nombre' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo.required' => 'El código es requerido',
            'codigo.unique' => 'El código :input ya existe',
            'nombre.required' => 'El nombre es requerido',
        ];
    }
}