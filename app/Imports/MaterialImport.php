<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MaterialImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Material([
            'code' => $row['codigo'] ?? $row['code'],
            'name' => $row['nombre'] ?? $row['name'],
            'unit' => $row['unidad'] ?? $row['unit'],
            'price' => $row['precio'] ?? $row['price'],
            'category' => $row['categoria'] ?? $row['category'] ?? null,
            'description' => $row['descripcion'] ?? $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.codigo' => 'required|unique:materials,code',
            '*.nombre' => 'required',
            '*.unidad' => 'required',
            '*.precio' => 'required|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo.required' => 'El código del material es requerido',
            'codigo.unique' => 'El código :input ya existe en la base de datos',
            'nombre.required' => 'El nombre del material es requerido',
            'unidad.required' => 'La unidad del material es requerida',
            'precio.required' => 'El precio del material es requerido',
            'precio.numeric' => 'El precio debe ser un número',
        ];
    }
}