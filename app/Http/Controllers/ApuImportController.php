<?php

namespace App\Http\Controllers;

use App\Imports\ApuImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ApuImportController extends Controller
{
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls|max:5120'
    ]);
    
    try {
        $import = new ApuImport;
        Excel::import($import, $request->file('file'));
        
        // Verificar si fue actualización o creación
        $wasUpdate = $import->wasUpdate(); // Necesitas agregar esta propiedad
        
        $message = $wasUpdate 
            ? '✅ APU actualizado exitosamente' 
            : '✅ APU importado exitosamente';
        
        return back()->with('success', $message);
    } catch (\Exception $e) {
        return back()->with('error', 'Error al importar: ' . $e->getMessage());
    }
}
    public function test()
{
    return response()->json(['message' => 'Controlador funciona correctamente']);
}
}