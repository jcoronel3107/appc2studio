<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\AnalysisHeader;
use Illuminate\Http\Request;

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
        $budget = Budget::create($request->all());
        
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['apu_id']) && !empty($item['quantity'])) {
                    BudgetItem::create([
                        'budget_id' => $budget->id,
                        'apu_id' => $item['apu_id'],
                        'apu_code' => $item['apu_code'],
                        'apu_name' => $item['apu_name'],
                        'apu_unit' => $item['apu_unit'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => $item['total'],
                    ]);
                }
            }
        }
        
        // Calcular monto total del presupuesto
        $total = BudgetItem::where('budget_id', $budget->id)->sum('total');
        $budget->update(['monto' => $total]);
        
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
        
        // Eliminar items existentes y recrear
        BudgetItem::where('budget_id', $budget->id)->delete();
        
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['apu_id']) && !empty($item['quantity'])) {
                    BudgetItem::create([
                        'budget_id' => $budget->id,
                        'apu_id' => $item['apu_id'],
                        'apu_code' => $item['apu_code'],
                        'apu_name' => $item['apu_name'],
                        'apu_unit' => $item['apu_unit'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => $item['total'],
                    ]);
                }
            }
        }
        
        $total = BudgetItem::where('budget_id', $budget->id)->sum('total');
        $budget->update(['monto' => $total]);
        
        return redirect()->route('budgets.index')->with('success', 'Presupuesto actualizado');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Presupuesto eliminado');
    }
}