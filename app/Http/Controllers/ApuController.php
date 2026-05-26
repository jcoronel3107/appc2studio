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
        return view("apus.create", compact("materiales", "equipos"));
    }
    
    public function store(Request $request)
    {
        $apu = AnalysisHeader::create([
            "code" => $request->code,
            "name" => $request->name,
            "unit" => $request->unit,
        ]);
        
        if ($request->has("equipos")) {
            foreach ($request->equipos as $equipo) {
                if (!empty($equipo["material_id"]) && !empty($equipo["quantity"])) {
                    $material = Equipment::find($equipo["material_id"]);
                    if ($material) {
                        AnalysisItem::create([
                            "analysis_header_id" => $apu->id,
                            "section" => "equipment",
                            "description" => $material->name,
                            "quantity" => $equipo["quantity"],
                            "unit_price" => $material->price,
                            "performance" => $equipo["performance"] ?? null,
                            "total" => $equipo["quantity"] * $material->price,
                            "row_position" => 0,
                        ]);
                    }
                }
            }
        }
        
        if ($request->has("materiales")) {
            foreach ($request->materiales as $material) {
                if (!empty($material["material_id"]) && !empty($material["quantity"])) {
                    $materialItem = Material::find($material["material_id"]);
                    if ($materialItem) {
                        AnalysisItem::create([
                            "analysis_header_id" => $apu->id,
                            "section" => "material",
                            "description" => $materialItem->name,
                            "quantity" => $material["quantity"],
                            "unit_price" => $materialItem->price,
                            "total" => $material["quantity"] * $materialItem->price,
                            "row_position" => 0,
                        ]);
                    }
                }
            }
        }
        
        $totalDirecto = AnalysisItem::where("analysis_header_id", $apu->id)->sum("total");
        $indirectos = $totalDirecto * 0.20;
        $totalGeneral = $totalDirecto + $indirectos;
        
        $apu->update([
            "total_direct_cost" => $totalDirecto,
            "indirect_cost" => $indirectos,
            "total_cost" => $totalGeneral,
        ]);
        
        return redirect()->route("apus.index")->with("success", "APU creado exitosamente");
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