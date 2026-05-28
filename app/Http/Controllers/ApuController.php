<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHeader;
use App\Models\AnalysisItem;
use App\Models\Material;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApuFullExport;
use App\Exports\ApuSummaryExport;
use App\Models\Labor; // Agregar al inicio del controlador

class ApuController extends Controller
{
    public function index()
    {
        $apus = AnalysisHeader::with("items")->latest()->get();
        return view("apus.index", compact("apus"));
    }
    
    public function create()
    {
        $materiales = Material::orderBy("name")->get();
        $equipos = Equipment::orderBy("name")->get();
         $labors = Labor::orderBy('name')->get(); // Agregar esta línea
        return view("apus.create", compact("materiales", "equipos", "labors")); // Agregar "labors" al compact
    }
    
    public function store(Request $request)
{
    // Crear el APU
    $apu = AnalysisHeader::create([
        'code' => $request->code,
        'name' => $request->name,
        'unit' => $request->unit,
    ]);
    
    // Guardar equipos
    if ($request->has('equipos')) {
        foreach ($request->equipos as $equipo) {
            if (!empty($equipo['material_id']) && !empty($equipo['quantity'])) {
                AnalysisItem::create([
                    'analysis_header_id' => $apu->id,
                    'section' => 'equipment',
                    'description' => $equipo['description'] ?? '',
                    'quantity' => $equipo['quantity'],
                    'unit_price' => $equipo['price'],
                    'performance' => $equipo['performance'] ?? 1,
                    'total' => $equipo['total'],
                    'row_position' => 0,
                ]);
            }
        }
    }
    
    // Guardar mano de obra
    if ($request->has('labors')) {
        foreach ($request->labors as $labor) {
            if (!empty($labor['labor_id']) && !empty($labor['quantity'])) {
                AnalysisItem::create([
                    'analysis_header_id' => $apu->id,
                    'section' => 'labor',
                    'description' => $labor['description'] ?? '',
                    'quantity' => $labor['quantity'],
                    'unit_price' => $labor['price'],
                    'performance' => $labor['performance'] ?? 1,
                    'total' => $labor['total'],
                    'row_position' => 0,
                ]);
            }
        }
    }
    
    // Guardar materiales
    if ($request->has('materiales')) {
        foreach ($request->materiales as $material) {
            if (!empty($material['material_id']) && !empty($material['quantity'])) {
                AnalysisItem::create([
                    'analysis_header_id' => $apu->id,
                    'section' => 'material',
                    'description' => $material['description'] ?? '',
                    'quantity' => $material['quantity'],
                    'unit_price' => $material['price'],
                    'total' => $material['total'],
                    'row_position' => 0,
                ]);
            }
        }
    }
    
    // Actualizar totales
    $apu->update([
        'total_direct_cost' => $request->total_direct_cost,
        'indirect_cost' => $request->indirect_cost,
        'total_cost' => $request->total_cost,
    ]);
    
    return redirect()->route('apus.index')->with('success', 'APU creado exitosamente');
}

    
    public function show($id)
    {
        $apu = AnalysisHeader::with("items")->findOrFail($id);
        return view("apus.show", compact("apu"));
    }
    
    public function edit($id)
    {
        $apu = AnalysisHeader::with("items")->findOrFail($id);
        $materiales = Material::orderBy("name")->get();
        $equipos = Equipment::orderBy("name")->get();
        return view("apus.edit", compact("apu", "materiales", "equipos"));
    }
    
    public function update(Request $request, $id)
    {
        $apu = AnalysisHeader::findOrFail($id);
        
        foreach ($request->items as $itemId => $itemData) {
            $item = AnalysisItem::findOrFail($itemId);
            $total = $itemData["quantity"] * $itemData["unit_price"];
            
            $item->update([
                "description" => $itemData["description"],
                "quantity" => $itemData["quantity"],
                "unit_price" => $itemData["unit_price"],
                "performance" => $itemData["performance"] ?? null,
                "total" => $total,
            ]);
        }
        
        $apu->update([
            "code" => $request->code,
            "name" => $request->name,
            "unit" => $request->unit,
            "total_direct_cost" => $request->total_direct_cost,
            "indirect_cost" => $request->indirect_cost,
            "total_cost" => $request->total_cost,
        ]);
        
        return redirect()->route("apus.show", $apu->id)->with("success", "APU actualizado correctamente");
    }
    
    public function summary()
    {
        $apus = AnalysisHeader::latest()->get();
        return view("apus.summary", compact("apus"));
    }
    
    public function exportAll()
    {
        return Excel::download(new ApuSummaryExport, "apu-resumen.xlsx");
    }
    
    public function exportSingle($id)
    {
        $apu = AnalysisHeader::findOrFail($id);
        $filename = "apu-" . $apu->code . ".xlsx";
        return Excel::download(new ApuFullExport($id), $filename);
    }
    
    public function exportSummary()
    {
        return Excel::download(new ApuSummaryExport, "apu-resumen-completo.xlsx");
    }
    
    public function destroy($id)
    {
        $apu = AnalysisHeader::findOrFail($id);
        $apu->delete();
        return redirect()->route("apus.index")->with("success", "APU eliminado correctamente");
    }
}