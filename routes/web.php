<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuImportController;
use App\Http\Controllers\ApuController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LaborController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BudgetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () 
{
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== APUS ==========
    // Importar APU
    Route::get('/importar', fn() => view('import'));
    Route::post('/importar-apu', [ApuImportController::class, 'import'])->name('apu.import');
    
    // Ver y gestionar APUs
    Route::get('/apus', [ApuController::class, 'index'])->name('apus.index');
    Route::get('/apu/create', [ApuController::class, 'create'])->name('apus.create');
    Route::post('/apu', [ApuController::class, 'store'])->name('apus.store');
    Route::get('/apu/{id}', [ApuController::class, 'show'])->name('apus.show');
    Route::get('/apu/{id}/edit', [ApuController::class, 'edit'])->name('apus.edit');
    Route::put('/apu/{id}', [ApuController::class, 'update'])->name('apus.update');
    Route::delete('/apu/{id}', [ApuController::class, 'destroy'])->name('apus.destroy');
    Route::get('/apu-summary', [ApuController::class, 'summary'])->name('apus.summary');
    
    // Exportar APUs
    Route::get('/exportar-apus', [ApuController::class, 'exportAll'])->name('export.apus');
    Route::get('/exportar-apu/{id}', [ApuController::class, 'exportSingle'])->name('export.apu');
    Route::get('/budgets/export-presupuesto/{id}', [BudgetController::class, 'exportPresupuesto'])->name('budgets.export-presupuesto');
    // Rutas para clonar APUs
    Route::get('/apu/clonar/{id}', [ApuController::class, 'clone'])->name('apus.clone');
Route::post('/apu/clonar/{id}', [ApuController::class, 'cloneStore'])->name('apus.clone.store');

    // Rutas de Transporte
Route::resource('transports', TransportController::class);
Route::get('/transports-import', [TransportController::class, 'importForm'])->name('transports.import.form');
Route::post('/transports-import', [TransportController::class, 'import'])->name('transports.import');
Route::get('/transports-export', [TransportController::class, 'export'])->name('transports.export');                              

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/budgets/create-with-milestones', [BudgetController::class, 'createWithMilestones'])->name('budgets.create-with-milestones');
Route::get('/budgets/show-with-milestones/{id}', [BudgetController::class, 'showWithMilestones'])->name('budgets.show-with-milestones');

Route::get('/budgets/create-chapter', [BudgetController::class, 'createChapter'])->name('budgets.create-chapter');
Route::post('/budgets/store-chapter', [BudgetController::class, 'storeChapter'])->name('budgets.store-chapter');
Route::get('/budgets/show-chapter/{id}', [BudgetController::class, 'showChapter'])->name('budgets.show-chapter');

Route::get('/budgets/export-chapter/{id}', [BudgetController::class, 'exportChapter'])->name('budgets.export-chapter');
// Rutas de Presupuestos
Route::resource('budgets', BudgetController::class);


    // Rutas para materiales y equipos


    // ========== MATERIALES ==========
    Route::resource('materials', MaterialController::class);
    Route::get('/materials-import', [MaterialController::class, 'importForm'])->name('materials.import.form');
    Route::post('/materials-import', [MaterialController::class, 'import'])->name('materials.import');
    Route::get('/materials-export', [MaterialController::class, 'export'])->name('materials.export');
    
    // ========== EQUIPOS ==========
    Route::resource('equipments', EquipmentController::class);
    Route::get('/equipments-import', [EquipmentController::class, 'importForm'])->name('equipments.import.form');
    Route::post('/equipments-import', [EquipmentController::class, 'import'])->name('equipments.import');
    Route::get('/equipments-export', [EquipmentController::class, 'export'])->name('equipments.export');
});

// Rutas de Mano de Obra
Route::resource('labors', LaborController::class);
Route::get('/labors-import', [LaborController::class, 'importForm'])->name('labors.import.form');
Route::post('/labors-import', [LaborController::class, 'import'])->name('labors.import');
Route::get('/labors-export', [LaborController::class, 'export'])->name('labors.export');
Route::get('/budgets/export-complete/{id}', [BudgetController::class, 'exportComplete'])->name('budgets.export-complete');

// Rutas de autenticación (las proporciona Breeze)
require __DIR__.'/auth.php';