<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LaborImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}<?php

namespace App\Imports;

use App\Models\Labor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class LaborImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Labor([
            'code' => $row['codigo'] ?? $row['code'],
            'name' => $row['nombre'] ?? $row['name'],
            'category' => $row['categoria'] ?? $row['category'] ?? null,
            'unit' => $row['unidad'] ?? $row['unit'] ?? 'hora',
            'hourly_rate' => $row['tarifa_hora'] ?? $row['hourly_rate'] ?? 0,
            'daily_rate' => $row['tarifa_dia'] ?? $row['daily_rate'] ?? null,
            'termino' => $row['termino'] ?? null,
            'description' => $row['descripcion'] ?? $row['description'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.codigo' => 'required|unique:labors,code',
            '*.nombre' => 'required',
            '*.tarifa_hora' => 'required|numeric|min:0',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo.required' => 'El código es requerido',
            'codigo.unique' => 'El código :input ya existe',
            'nombre.required' => 'El nombre es requerido',
            'tarifa_hora.required' => 'La tarifa por hora es requerida',
            'tarifa_hora.numeric' => 'La tarifa debe ser un número',
        ];
    }
}
