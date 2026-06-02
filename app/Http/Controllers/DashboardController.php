<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Equipment;
use App\Models\Labor;
use App\Models\Transport;
use App\Models\AnalysisHeader;
use App\Models\AnalysisItem;

class DashboardController extends Controller
{
    public function index()
    {
        // Contar registros por catálogo
        $totalMateriales = Material::count();
        $totalEquipos = Equipment::count();
        $totalLabors = Labor::count();
        $totalTransportes = Transport::count();
        
        // Contar APUs
        $totalApus = AnalysisHeader::count();
        $totalItems = AnalysisItem::count();
        
        // Calcular costo total de APUs
        $costoTotalApus = AnalysisHeader::sum('total_cost');
        
        // Últimos APUs agregados
        $ultimosApus = AnalysisHeader::latest()->take(5)->get();
        
        // Materiales más caros (top 5)
        $materialesCaros = Material::orderBy('price', 'desc')->take(5)->get();
        
        return view('dashboard', compact(
            'totalMateriales',
            'totalEquipos',
            'totalLabors',
            'totalTransportes',
            'totalApus',
            'totalItems',
            'costoTotalApus',
            'ultimosApus',
            'materialesCaros'
        ));
    }
}