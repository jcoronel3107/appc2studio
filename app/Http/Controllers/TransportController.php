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
        $request->validate([
            'code' => 'required|unique:transports',
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|numeric|min:0',
            'termino' => 'nullable|string|max:255',
        ]);

        Transport::create($request->all());
        return redirect()->route('transports.index')->with('success', 'Transporte creado exitosamente');
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