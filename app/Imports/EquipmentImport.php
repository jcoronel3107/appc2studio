<?php

namespace App\Imports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EquipmentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Equipment([
            'code' => $row['codigo'] ?? $row['code'],
            'name' => $row['nombre'] ?? $row['name'],
            'category' => $row['categoria'] ?? $row['category'] ?? null,
            'unit' => $row['unidad'] ?? $row['unit'],
            'price' => $row['precio'] ?? $row['price'],
            'termino' => $row['termino'] ?? null,
            'description' => $row['descripcion'] ?? $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.codigo' => 'required|unique:equipments,code',
            '*.nombre' => 'required',
            '*.unidad' => 'required',
            '*.precio' => 'required|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo.required' => 'El código del equipo es requerido',
            'codigo.unique' => 'El código :input ya existe en la base de datos',
            'nombre.required' => 'El nombre del equipo es requerido',
            'unidad.required' => 'La unidad del equipo es requerida',
            'precio.required' => 'El precio es requerido',
            'precio.numeric' => 'El precio debe ser un número',
        ];
    }
}