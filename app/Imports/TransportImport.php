<?php

namespace App\Imports;

use App\Models\Transport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransportImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Transport([
            'code' => $row['codigo'] ?? $row['code'] ?? null,
            'name' => $row['nombre'] ?? $row['name'] ?? null,
            'category' => $row['categoria'] ?? $row['category'] ?? null,
            'unit' => $row['unidad'] ?? $row['unit'] ?? 'hora',
            'price' => floatval($row['precio'] ?? $row['price'] ?? 0),
            'termino' => $row['termino'] ?? null,
            'description' => $row['descripcion'] ?? $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.codigo' => 'required|unique:transports,code',
            '*.nombre' => 'required',
            '*.precio' => 'required|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo.required' => 'El código es requerido',
            'codigo.unique' => 'El código :input ya existe',
            'nombre.required' => 'El nombre es requerido',
            'precio.required' => 'El precio es requerido',
            'precio.numeric' => 'El precio debe ser un número',
        ];
    }
}