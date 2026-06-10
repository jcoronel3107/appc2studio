<?php

namespace App\Http\Controllers;

use App\Models\AnalysisHeader;
use App\Models\AnalysisItem;
use App\Models\Material;
use App\Models\Equipment;
use App\Models\Labor;
use App\Models\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
class ApuController extends Controller
{
    public function index()
{
    $apus = AnalysisHeader::with('items')->latest()->paginate(10);
    return view('apus.index', compact('apus'));
}
    
   public function create()
{
    $materiales = Material::orderBy('name')->get();
    $equipos = Equipment::orderBy('name')->get();
    $labors = Labor::orderBy('name')->get();
    $transportes = Transport::orderBy('name')->get();
    
    return view('apus.create', compact('materiales', 'equipos', 'labors', 'transportes'));
}
    
    public function store(Request $request)
{
    // Crear el APU
    $apu = AnalysisHeader::create([
        'code' => $request->code,
        'name' => $request->name,
        'unit' => $request->unit,
        'indirect_percentage' => $request->indirect_percentage ?? 20, // Agrega esta línea
    ]);
    
    // Guardar archivo Word
    if ($request->hasFile('word_file')) {
        $path = $request->file('word_file')->store('apu_files', 'public');
        $apu->update(['word_file' => $path]);
    }
    
    // Guardar equipos
    if ($request->has('equipos')) {
        foreach ($request->equipos as $equipo) {
            if (!empty($equipo['material_id']) && !empty($equipo['quantity'])) {
                $material = Equipment::find($equipo['material_id']);
                if ($material) {
                    AnalysisItem::create([
                        'analysis_header_id' => $apu->id,
                        'section' => 'equipment',
                        'description' => $material->name,
                        'quantity' => $equipo['quantity'],
                        'unit_price' => $material->price,
                        'performance' => $equipo['performance'] ?? 1,
                        'total' => $equipo['quantity'] * $material->price * ($equipo['performance'] ?? 1),
                        'row_position' => 0,
                    ]);
                }
            }
        }
    }
    
    // Guardar mano de obra
    if ($request->has('labors')) {
        foreach ($request->labors as $labor) {
            if (!empty($labor['labor_id']) && !empty($labor['quantity'])) {
                $laborItem = Labor::find($labor['labor_id']);
                if ($laborItem) {
                    AnalysisItem::create([
                        'analysis_header_id' => $apu->id,
                        'section' => 'labor',
                        'description' => $laborItem->name,
                        'quantity' => $labor['quantity'],
                        'unit_price' => $laborItem->hourly_rate,
                        'performance' => $labor['performance'] ?? 1,
                        'total' => $labor['quantity'] * $laborItem->hourly_rate * ($labor['performance'] ?? 1),
                        'row_position' => 0,
                    ]);
                }
            }
        }
    }
    
    // Guardar materiales
    if ($request->has('materiales')) {
        foreach ($request->materiales as $material) {
            if (!empty($material['material_id']) && !empty($material['quantity'])) {
                $materialItem = Material::find($material['material_id']);
                if ($materialItem) {
                    AnalysisItem::create([
                        'analysis_header_id' => $apu->id,
                        'section' => 'material',
                        'description' => $materialItem->name,
                        'quantity' => $material['quantity'],
                        'unit_price' => $materialItem->price,
                        'total' => $material['quantity'] * $materialItem->price,
                        'row_position' => 0,
                    ]);
                }
            }
        }
    }
    
    // Guardar transporte
    if ($request->has('transportes')) {
        foreach ($request->transportes as $transporte) {
            if (!empty($transporte['material_id']) && !empty($transporte['quantity'])) {
                $transportItem = Equipment::find($transporte['material_id']);
                if ($transportItem) {
                    AnalysisItem::create([
                        'analysis_header_id' => $apu->id,
                        'section' => 'transport',
                        'description' => $transportItem->name,
                        'quantity' => $transporte['quantity'],
                        'unit_price' => $transportItem->price,
                        'performance' => $transporte['performance'] ?? 1,
                        'total' => $transporte['quantity'] * $transportItem->price * ($transporte['performance'] ?? 1),
                        'row_position' => 0,
                    ]);
                }
            }
        }
    }
    
    // Actualizar totales
    $apu->update([
        'total_direct_cost' => $request->total_direct_cost,
        'indirect_cost' => $request->indirect_cost,
        'total_cost' => $request->total_cost,
        'indirect_percentage' => $request->indirect_percentage ?? 20, // Agrega esta línea
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
    $apu = AnalysisHeader::with('items')->findOrFail($id);
    $materiales = Material::orderBy('name')->get();
    $equipos = Equipment::orderBy('name')->get();
    $labors = Labor::orderBy('name')->get();
    $transportes = Transport::orderBy('name')->get();
    
    return view('apus.edit', compact('apu', 'materiales', 'equipos', 'labors', 'transportes'));
}
    
   public function update(Request $request, $id)
{
    $apu = AnalysisHeader::findOrFail($id);
    
    // Actualizar cabecera
    $apu->update([
        'code' => $request->code,
        'name' => $request->name,
        'unit' => $request->unit,
        'total_direct_cost' => $request->total_direct_cost,
        'indirect_cost' => $request->indirect_cost,
        'total_cost' => $request->total_cost,
        'indirect_percentage' => $request->indirect_percentage ?? 20,
    ]);
    
    // Actualizar o crear equipos
    if ($request->has('equipos')) {
        foreach ($request->equipos as $key => $equipo) {
            if (!empty($equipo['material_id']) && !empty($equipo['quantity'])) {
                // Buscar si ya existe o crear uno nuevo
                $item = AnalysisItem::where('analysis_header_id', $apu->id)
                    ->where('section', 'equipment')
                    ->where('description', $equipo['description'] ?? '')
                    ->first();
                
                if (!$item) {
                    $item = new AnalysisItem();
                }
                
                $item->analysis_header_id = $apu->id;
                $item->section = 'equipment';
                $item->description = $equipo['description'] ?? '';
                $item->quantity = $equipo['quantity'];
                $item->unit_price = $equipo['price'] ?? 0;
                $item->performance = $equipo['performance'] ?? 1;
                $item->total = $equipo['total'] ?? ($equipo['quantity'] * ($equipo['price'] ?? 0) * ($equipo['performance'] ?? 1));
                $item->row_position = $key;
                $item->save();
            }
        }
    }
    
    // Actualizar o crear mano de obra
    if ($request->has('labors')) {
        foreach ($request->labors as $key => $labor) {
            if (!empty($labor['labor_id']) && !empty($labor['quantity'])) {
                $item = AnalysisItem::where('analysis_header_id', $apu->id)
                    ->where('section', 'labor')
                    ->where('description', $labor['description'] ?? '')
                    ->first();
                
                if (!$item) {
                    $item = new AnalysisItem();
                }
                
                $item->analysis_header_id = $apu->id;
                $item->section = 'labor';
                $item->description = $labor['description'] ?? '';
                $item->quantity = $labor['quantity'];
                $item->unit_price = $labor['price'] ?? 0;
                $item->performance = $labor['performance'] ?? 1;
                $item->total = $labor['total'] ?? ($labor['quantity'] * ($labor['price'] ?? 0) * ($labor['performance'] ?? 1));
                $item->row_position = $key;
                $item->save();
            }
        }
    }
    
    // Actualizar o crear materiales
    if ($request->has('materiales')) {
        foreach ($request->materiales as $key => $material) {
            if (!empty($material['material_id']) && !empty($material['quantity'])) {
                $item = AnalysisItem::where('analysis_header_id', $apu->id)
                    ->where('section', 'material')
                    ->where('description', $material['description'] ?? '')
                    ->first();
                
                if (!$item) {
                    $item = new AnalysisItem();
                }
                
                $item->analysis_header_id = $apu->id;
                $item->section = 'material';
                $item->description = $material['description'] ?? '';
                $item->quantity = $material['quantity'];
                $item->unit_price = $material['price'] ?? 0;
                $item->total = $material['total'] ?? ($material['quantity'] * ($material['price'] ?? 0));
                $item->row_position = $key;
                $item->save();
            }
        }
    }
    
    // Actualizar o crear transporte
    if ($request->has('transportes')) {
        foreach ($request->transportes as $key => $transporte) {
            if (!empty($transporte['material_id']) && !empty($transporte['quantity'])) {
                $item = AnalysisItem::where('analysis_header_id', $apu->id)
                    ->where('section', 'transport')
                    ->where('description', $transporte['description'] ?? '')
                    ->first();
                
                if (!$item) {
                    $item = new AnalysisItem();
                }
                
                $item->analysis_header_id = $apu->id;
                $item->section = 'transport';
                $item->description = $transporte['description'] ?? '';
                $item->quantity = $transporte['quantity'];
                $item->unit_price = $transporte['price'] ?? 0;
                $item->performance = $transporte['performance'] ?? 1;
                $item->total = $transporte['total'] ?? ($transporte['quantity'] * ($transporte['price'] ?? 0) * ($transporte['performance'] ?? 1));
                $item->row_position = $key;
                $item->save();
            }
        }
    }
    
    // Eliminar items que ya no existen (opcional)
    // Esto mantiene limpia la base de datos
    
    return redirect()->route('apus.show', $apu->id)->with('success', 'APU actualizado correctamente');
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


    // Métodos para clonar APUs
    public function clone($id)
{
    $apuOriginal = AnalysisHeader::with('items')->findOrFail($id);
    $materiales = Material::orderBy('name')->get();
    $equipos = Equipment::orderBy('name')->get();
    $labors = Labor::orderBy('name')->get();
    
    return view('apus.clone', compact('apuOriginal', 'materiales', 'equipos', 'labors'));
}

public function cloneStore(Request $request, $id)
{
    $apuOriginal = AnalysisHeader::findOrFail($id);
    
    if ($request->action == 'sobrescribir') {
        // Sobrescribir el APU existente
        $apu = $apuOriginal;
        
        // Eliminar items antiguos
        AnalysisItem::where('analysis_header_id', $apu->id)->delete();
        
    } else {
        // Crear nuevo APU
        $apu = AnalysisHeader::create([
            'code' => $request->code,
            'name' => $request->name,
            'unit' => $request->unit,
        ]);
    }
    
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
    
    $mensaje = $request->action == 'sobrescribir' 
        ? 'APU sobrescrito exitosamente' 
        : 'APU clonado exitosamente';
    
    return redirect()->route('apus.index')->with('success', $mensaje);
}


}