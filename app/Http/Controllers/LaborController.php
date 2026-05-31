<?php

namespace App\Http\Controllers;

use App\Models\Labor;
use App\Imports\LaborImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaborController extends Controller
{
     public function index(Request $request)
    {
        $query = Labor::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        
        $labors = $query->latest()->paginate(20);
        
        return view('labors.index', compact('labors'));
    }

    public function create()
    {
        return view('labors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:labors',
            'name' => 'required',
            'unit' => 'required',
            'hourly_rate' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:255',
        ]);

        Labor::create($request->all());
        return redirect()->route('labors.index')->with('success', 'Registro creado exitosamente');
    }

    public function edit($id)
    {
        $labor = Labor::findOrFail($id);
        return view('labors.edit', compact('labor'));
    }

    public function update(Request $request, $id)
    {
        $labor = Labor::findOrFail($id);
        
        $request->validate([
            'code' => 'required|unique:labors,code,' . $id,
            'name' => 'required',
            'unit' => 'required',
            'hourly_rate' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:255',
        ]);

        $labor->update($request->all());
        return redirect()->route('labors.index')->with('success', 'Registro actualizado');
    }

    public function destroy($id)
    {
        $labor = Labor::findOrFail($id);
        $labor->delete();
        return redirect()->route('labors.index')->with('success', 'Registro eliminado');
    }

    public function importForm()
    {
        return view('labors.import');
    }

    public function import(Request $request)
    {
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    try {
        Excel::import(new LaborImport, $request->file('file'));
        return redirect()->route('labors.index')->with('success', 'Mano de obra importada exitosamente');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al importar: ' . $e->getMessage());
    }
    }

    public function export()
    {
        return Excel::download(new \App\Exports\LaborExport, 'mano-obra.xlsx');
    }
}