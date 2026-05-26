<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Imports\MaterialImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->paginate(20);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

   public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:materials',
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:255',  // ← Agrega esta línea
        ]);
         \Log::info('Validación pasada, término: ' . $request->termino);
    
            $material = Material::create($request->all());
            
        \Log::info('Material creado ID: ' . $material->id . ', término: ' . $material->termino);

        Material::create($request->all());
        return redirect()->route('materials.index')->with('success', 'Material creado exitosamente');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
    $material = Material::findOrFail($id);
    
        $request->validate([
            'code' => 'required|unique:materials,code,' . $id,
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:3',  // ← Agrega esta línea
        ]);

        $material->update($request->all());
        return redirect()->route('materials.index')->with('success', 'Material actualizado');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material eliminado');
    }

    public function importForm()
    {
        return view('materials.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new MaterialImport, $request->file('file'));
            return redirect()->route('materials.index')->with('success', 'Materiales importados exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al importar: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new \App\Exports\MaterialsExport, 'materiales.xlsx');
    }
}