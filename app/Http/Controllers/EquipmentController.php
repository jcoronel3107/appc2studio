<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Imports\EquipmentImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::latest()->paginate(20);
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:equipments',
        'name' => 'required',
        'unit' => 'required',
        'price' => 'required|numeric|min:0',
        'termino' => 'nullable|string|max:255',
    ]);

    Equipment::create($request->all());
    return redirect()->route('equipments.index')->with('success', 'Equipo creado exitosamente');
}

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('equipments.edit', compact('equipment'));
    }

   public function update(Request $request, $id)
{
    $equipment = Equipment::findOrFail($id);
    
    $request->validate([
        'code' => 'required|unique:equipments,code,' . $id,
        'name' => 'required',
        'unit' => 'required',
        'price' => 'required|numeric|min:0',
        'termino' => 'nullable|string|max:255',
    ]);

    $equipment->update($request->all());
    return redirect()->route('equipments.index')->with('success', 'Equipo actualizado');
}

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Equipo eliminado');
    }

    public function importForm()
    {
        return view('equipments.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new EquipmentImport, $request->file('file'));
            return redirect()->route('equipments.index')->with('success', 'Equipos importados exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new \App\Exports\EquipmentExport, 'equipos.xlsx');
    }
}