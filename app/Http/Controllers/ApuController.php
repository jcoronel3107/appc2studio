<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApuExport;
use App\Models\AnalysisHeader;
use App\Models\AnalysisItem;
use Illuminate\Http\Request;
use App\Exports\ApuFullExport;
use App\Exports\ApuSummaryExport;


class ApuController extends Controller
{
    public function index()
    {
        $apus = AnalysisHeader::with('items')->latest()->get();
        return view('apus.index', compact('apus'));
    }
    
    public function show($id)
    {
        $apu = AnalysisHeader::with('items')->findOrFail($id);
        return view('apus.show', compact('apu'));
    }
    
    public function summary()
    {
        $apus = AnalysisHeader::latest()->get();
        return view('apus.summary', compact('apus'));
    }
  

// Agrega estos métodos dentro de la clase ApuController

    public function exportAll()
    {
        return Excel::download(new ApuExport, 'apu-resumen.xlsx');
    }

    public function exportSingle($id)
{
    $apu = AnalysisHeader::findOrFail($id);
    $filename = 'apu-' . $apu->code . '.xlsx';
    return Excel::download(new ApuFullExport($id), $filename);
}
    // Agrega estos métodos dentro de la clase ApuController

public function edit($id)
{
    $apu = AnalysisHeader::with('items')->findOrFail($id);
    return view('apus.edit', compact('apu'));
}

public function update(Request $request, $id)
{
    $apu = AnalysisHeader::findOrFail($id);
    
    // Actualizar items
    foreach ($request->items as $itemId => $itemData) {
        $item = AnalysisItem::findOrFail($itemId);
        
        $total = $itemData['quantity'] * $itemData['unit_price'];
        
        $item->update([
            'description' => $itemData['description'],
            'quantity' => $itemData['quantity'],
            'unit_price' => $itemData['unit_price'],
            'performance' => $itemData['performance'] ?? null,
            'total' => $total,
        ]);
    }
    
    // Actualizar cabecera con los totales que vienen del formulario
    $apu->update([
        'code' => $request->code,
        'name' => $request->name,
        'unit' => $request->unit,
        'total_direct_cost' => $request->total_direct_cost,
        'indirect_cost' => $request->indirect_cost,
        'total_cost' => $request->total_cost,
    ]);
    
    return redirect()->route('apus.show', $apu->id)->with('success', 'APU actualizado correctamente');
}

public function exportSummary()
{
    return Excel::download(new ApuSummaryExport, 'apu-resumen-completo.xlsx');
}
}