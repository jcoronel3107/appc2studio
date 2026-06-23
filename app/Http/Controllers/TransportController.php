<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Imports\TransportImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransportController extends Controller
{
    public function index()
    {
        $transports = Transport::latest()->paginate(20);
        return view('transports.index', compact('transports'));
    }

    public function create()
    {
        return view('transports.create');
    }

    public function store(Request $request)
{
    try {
        // DEBUG 1: Ver qué datos llegan
        \Log::info('=== INTENTANDO GUARDAR TRANSPORTE ===');
        \Log::info('Datos recibidos:', $request->all());
        
        // DEBUG 2: Ver conexión actual
        \Log::info('Conexión actual:', [
            'default' => DB::getDefaultConnection(),
            'database_name' => DB::connection()->getDatabaseName(),
            'tenant_session' => session('tenant_id'),
            'tenant_database' => session('tenant_database')
        ]);
        
        $validated = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'term' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);
        
        // DEBUG 3: Ver validación
        \Log::info('Datos validados:', $validated);
        
        // Obtener tenant_id de la sesión o del usuario
        $tenantId = session('tenant_id') ?? auth()->user()?->tenant_id;
        
        if (!$tenantId) {
            \Log::error('No se encontró tenant_id');
            return back()->with('error', 'No se pudo identificar el tenant');
        }
        
        // DEBUG 4: Ver tenant_id
        \Log::info('Tenant ID:', ['tenant_id' => $tenantId]);
        
        // Agregar tenant_id a los datos
        $validated['tenant_id'] = $tenantId;
        
        // DEBUG 5: Ver datos finales
        \Log::info('Datos a guardar:', $validated);
        
        // Crear el registro
        $transport = Transport::create($validated);
        
        // DEBUG 6: Verificar que se guardó
        \Log::info('Transporte guardado:', [
            'id' => $transport->id,
            'code' => $transport->code,
            'tenant_id' => $transport->tenant_id
        ]);
        
        // Verificar en la base de datos
        $count = Transport::count();
        \Log::info('Total transportes en DB:', ['count' => $count]);
        
        return redirect()->route('transports.index')
            ->with('success', 'Transporte creado correctamente.');
            
    } catch (\Exception $e) {
        \Log::error('ERROR al guardar transporte:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return back()->with('error', 'Error: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $transport = Transport::findOrFail($id);
        return view('transports.edit', compact('transport'));
    }

    public function update(Request $request, $id)
    {
        $transport = Transport::findOrFail($id);
        
        $request->validate([
            'code' => 'required|unique:transports,code,' . $id,
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:255',
        ]);

        $transport->update($request->all());
        return redirect()->route('transports.index')->with('success', 'Transporte actualizado');
    }

    public function destroy($id)
    {
        $transport = Transport::findOrFail($id);
        $transport->delete();
        return redirect()->route('transports.index')->with('success', 'Transporte eliminado');
    }

    public function importForm()
    {
        return view('transports.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new TransportImport, $request->file('file'));
            return redirect()->route('transports.index')->with('success', 'Transportes importados exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new \App\Exports\TransportExport, 'transportes.xlsx');
    }
}