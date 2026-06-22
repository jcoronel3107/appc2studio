<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\AnalysisHeader;
use App\Models\BudgetMilestone;
use App\Exports\BudgetChapterExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BudgetCompleteExport;
use Illuminate\Http\Request;
use App\Exports\PresupuestoExport;
use App\Exports\BudgetHierarchicalExport;


class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::with('items')->latest()->paginate(10);
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        $apus = AnalysisHeader::orderBy('code')->get();
        return view('budgets.create', compact('apus'));
    }

   public function store(Request $request)
{
    // Crear el presupuesto base
    $budget = Budget::create($request->all());
    
    if ($request->has('milestones')) {
        foreach ($request->milestones as $milestoneIdx => $milestone) {
            // Verificar que los datos del hito existen
            $milestoneCode = $milestone['code'] ?? 'Hito-' . ($milestoneIdx + 1);
            $milestoneName = $milestone['name'] ?? 'Hito ' . ($milestoneIdx + 1);
            
            $budgetMilestone = BudgetMilestone::create([
                'budget_id' => $budget->id,
                'code' => $milestoneCode,
                'name' => $milestoneName,
                'order' => $milestoneIdx,
            ]);
            
            if (isset($milestone['categories']) && is_array($milestone['categories'])) {
                foreach ($milestone['categories'] as $categoryIdx => $category) {
                    $categoryCode = $category['code'] ?? ($milestoneCode . '.' . ($categoryIdx + 1));
                    $categoryName = $category['name'] ?? 'Categoría ' . ($categoryIdx + 1);
                    
                    if (isset($category['items']) && is_array($category['items'])) {
                        foreach ($category['items'] as $item) {
                            if (!empty($item['apu_id']) && !empty($item['quantity'])) {
                                BudgetItem::create([
                                    'budget_id' => $budget->id,
                                    'milestone_id' => $budgetMilestone->id,
                                    'milestone_code' => $milestoneCode,
                                    'milestone_name' => $milestoneName,
                                    'category_code' => $categoryCode,
                                    'apu_id' => $item['apu_id'],
                                    'apu_code' => $item['apu_code'] ?? '',
                                    'apu_name' => $item['apu_name'] ?? '',
                                    'apu_unit' => $item['apu_unit'] ?? '',
                                    'category' => $categoryName,
                                    'quantity' => $item['quantity'],
                                    'unit_price' => $item['unit_price'] ?? 0,
                                    'total' => $item['total'] ?? ($item['quantity'] * ($item['unit_price'] ?? 0)),
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
    
    $total = BudgetItem::where('budget_id', $budget->id)->sum('total');
    $budget->update(['monto' => $total - ($budget->monto_anticipo ?? 0)]);
    
    return redirect()->route('budgets.index')->with('success', 'Presupuesto creado exitosamente');
}

    public function show($id)
    {
        $budget = Budget::with('items')->findOrFail($id);
        return view('budgets.show', compact('budget'));
    }

    public function edit($id)
    {
        $budget = Budget::with('items')->findOrFail($id);
        $apus = AnalysisHeader::orderBy('code')->get();
        return view('budgets.edit', compact('budget', 'apus'));
    }

   public function update(Request $request, $id)
    {
    $budget = Budget::findOrFail($id);
    $budget->update($request->all());
    
    // Eliminar datos antiguos
    BudgetMilestone::where('budget_id', $budget->id)->delete();
    BudgetItem::where('budget_id', $budget->id)->delete();
    
    if ($request->has('milestones')) {
        foreach ($request->milestones as $milestoneIdx => $milestone) {
            $milestoneCode = $milestone['code'] ?? 'Hito-' . ($milestoneIdx + 1);
            $milestoneName = $milestone['name'] ?? 'Hito ' . ($milestoneIdx + 1);
            
            $budgetMilestone = BudgetMilestone::create([
                'budget_id' => $budget->id,
                'code' => $milestoneCode,
                'name' => $milestoneName,
                'order' => $milestoneIdx,
            ]);
            
            if (isset($milestone['categories']) && is_array($milestone['categories'])) {
                foreach ($milestone['categories'] as $categoryIdx => $category) {
                    $categoryCode = $category['code'] ?? ($milestoneCode . '.' . ($categoryIdx + 1));
                    $categoryName = $category['name'] ?? 'Categoría ' . ($categoryIdx + 1);
                    
                    if (isset($category['items']) && is_array($category['items'])) {
                        foreach ($category['items'] as $item) {
                            if (!empty($item['apu_id']) && !empty($item['quantity'])) {
                                BudgetItem::create([
                                    'budget_id' => $budget->id,
                                    'milestone_id' => $budgetMilestone->id,
                                    'milestone_code' => $milestoneCode,
                                    'milestone_name' => $milestoneName,
                                    'category_code' => $categoryCode,
                                    'apu_id' => $item['apu_id'],
                                    'apu_code' => $item['apu_code'] ?? '',
                                    'apu_name' => $item['apu_name'] ?? '',
                                    'apu_unit' => $item['apu_unit'] ?? '',
                                    'category' => $categoryName,
                                    'quantity' => $item['quantity'],
                                    'unit_price' => $item['unit_price'] ?? 0,
                                    'total' => $item['total'] ?? ($item['quantity'] * ($item['unit_price'] ?? 0)),
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
    
    $total = BudgetItem::where('budget_id', $budget->id)->sum('total');
    $budget->update(['monto' => $total - ($budget->monto_anticipo ?? 0)]);
    
    return redirect()->route('budgets.index')->with('success', 'Presupuesto actualizado');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Presupuesto eliminado');
    }

    public function showWithMilestones($id)
    {
       $budget = Budget::with('items')->findOrFail($id);
        return view('budgets.show_with_milestones', compact('budget'));
    }

    public function createWithMilestones()
{
    $apus = AnalysisHeader::orderBy('code')->get();
    return view('budgets.create_with_milestones', compact('apus'));
}

public function createChapter()
{
    $apus = AnalysisHeader::orderBy('code')->get();
    return view('budgets.create_chapter', compact('apus'));
}

public function storeChapter(Request $request)
{
    $budget = Budget::create($request->all());
    
    if ($request->has('chapters')) {
        foreach ($request->chapters as $chapterIdx => $chapter) {
            $chapterCode = $chapter['code'];
            $chapterName = $chapter['name'];
            
            if (isset($chapter['milestones'])) {
                foreach ($chapter['milestones'] as $milestoneIdx => $milestone) {
                    $milestoneCode = $milestone['code'];
                    $milestoneName = $milestone['name'];
                    
                    $budgetMilestone = BudgetMilestone::create([
                        'budget_id' => $budget->id,
                        'chapter_code' => $chapterCode,
                        'chapter_name' => $chapterName,
                        'code' => $milestoneCode,
                        'name' => $milestoneName,
                        'order' => $milestoneIdx,
                    ]);
                    
                    if (isset($milestone['categories'])) {
                        foreach ($milestone['categories'] as $categoryIdx => $category) {
                            $categoryCode = $category['code'];
                            $categoryName = $category['name'];
                            
                            if (isset($category['items'])) {
                                foreach ($category['items'] as $item) {
                                    if (!empty($item['apu_id']) && !empty($item['quantity'])) {
                                        BudgetItem::create([
                                            'budget_id' => $budget->id,
                                            'chapter_code' => $chapterCode,
                                            'chapter_name' => $chapterName,
                                            'milestone_id' => $budgetMilestone->id,
                                            'milestone_code' => $milestoneCode,
                                            'milestone_name' => $milestoneName,
                                            'category_code' => $categoryCode,
                                            'apu_id' => $item['apu_id'],
                                            'apu_code' => $item['apu_code'],
                                            'apu_name' => $item['apu_name'],
                                            'apu_unit' => $item['apu_unit'],
                                            'category' => $categoryName,
                                            'quantity' => $item['quantity'],
                                            'unit_price' => $item['unit_price'] ?? 0,
                                            'total' => $item['total'] ?? ($item['quantity'] * ($item['unit_price'] ?? 0)),
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    
    $total = BudgetItem::where('budget_id', $budget->id)->sum('total');
    $budget->update(['monto' => $total - ($budget->monto_anticipo ?? 0)]);
    
    return redirect()->route('budgets.index')->with('success', 'Presupuesto creado exitosamente');
}
public function showChapter($id)
{
    $budget = Budget::with('items')->findOrFail($id);
    return view('budgets.show_chapter', compact('budget'));
}

public function exportChapter($id)
{
    $budget = Budget::findOrFail($id);
    $filename = 'presupuesto_' . $budget->id . '_' . str_replace(' ', '_', $budget->obra) . '.xlsx';
    return Excel::download(new BudgetChapterExport($id), $filename);
}

public function exportPresupuesto($id)
{
    $budget = Budget::findOrFail($id);
    $filename = 'presupuesto_' . $budget->id . '_' . str_replace(' ', '_', $budget->obra) . '.xlsx';
    return Excel::download(new PresupuestoExport($id), $filename);
}

public function exportComplete($id)
{
    $budget = Budget::findOrFail($id);
    $filename = 'presupuesto_' . $budget->id . '_' . str_replace(' ', '_', $budget->obra) . '.xlsx';
    return Excel::download(new BudgetCompleteExport($id), $filename);
}

public function exportHierarchical($id)
{
    $budget = Budget::findOrFail($id);
    $filename = 'presupuesto_' . $budget->id . '_' . str_replace(' ', '_', $budget->obra) . '.xlsx';
    return Excel::download(new BudgetHierarchicalExport($id), $filename);
}
}