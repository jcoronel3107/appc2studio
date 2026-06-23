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
use App\Http\Controllers\TenantController;
use App\Http\Middleware\TenantMiddleware;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// ============================================================
// RUTAS DEL SISTEMA (SIN SUBDOMINIO - ADMIN)
// ============================================================

Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ========== ADMIN ==========
    Route::get('/admin/tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
    Route::get('/admin/tenants/create', [TenantController::class, 'create'])->name('admin.tenants.create');
    Route::post('/admin/tenants', [TenantController::class, 'store'])->name('admin.tenants.store');
    Route::get('/admin/tenants/{id}/edit', [TenantController::class, 'edit'])->name('admin.tenants.edit');
    Route::put('/admin/tenants/{id}', [TenantController::class, 'update'])->name('admin.tenants.update');
    Route::delete('/admin/tenants/{id}', [TenantController::class, 'destroy'])->name('admin.tenants.destroy');
    Route::get('/admin/tenants/{id}/switch', [TenantController::class, 'switch'])->name('admin.tenants.switch');
});

// ============================================================
// RUTAS PARA TENANTS (CON SUBDOMINIO)
// ============================================================

Route::domain('{subdomain}.' . env('APP_DOMAIN', 'localhost'))->group(function () {
    
    Route::middleware([TenantMiddleware::class])->group(function () {
        
        // Dashboard del tenant
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
        
        // ============================================================
        // PERFIL DE USUARIO (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('tenant.profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('tenant.profile.destroy');
        });
        
        // ============================================================
        // APUS (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::get('/importar', fn() => view('import'));
            Route::post('/importar-apu', [ApuImportController::class, 'import'])->name('tenant.apu.import');
            
            Route::get('/apus', [ApuController::class, 'index'])->name('tenant.apus.index');
            Route::get('/apu/create', [ApuController::class, 'create'])->name('tenant.apus.create');
            Route::post('/apu', [ApuController::class, 'store'])->name('tenant.apus.store');
            Route::get('/apu/{id}', [ApuController::class, 'show'])->name('tenant.apus.show');
            Route::get('/apu/{id}/edit', [ApuController::class, 'edit'])->name('tenant.apus.edit');
            Route::put('/apu/{id}', [ApuController::class, 'update'])->name('tenant.apus.update');
            Route::delete('/apu/{id}', [ApuController::class, 'destroy'])->name('tenant.apus.destroy');
            Route::get('/apu-summary', [ApuController::class, 'summary'])->name('tenant.apus.summary');
            
            Route::get('/exportar-apus', [ApuController::class, 'exportAll'])->name('tenant.export.apus');
            Route::get('/exportar-apu/{id}', [ApuController::class, 'exportSingle'])->name('tenant.export.apu');
            
            Route::get('/apu/clonar/{id}', [ApuController::class, 'clone'])->name('tenant.apus.clone');
            Route::post('/apu/clonar/{id}', [ApuController::class, 'cloneStore'])->name('tenant.apus.clone.store');
        });
        
        // ============================================================
        // MATERIALES (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::resource('materials', MaterialController::class)->names('tenant.materials');
            Route::get('/materials-import', [MaterialController::class, 'importForm'])->name('tenant.materials.import.form');
            Route::post('/materials-import', [MaterialController::class, 'import'])->name('tenant.materials.import');
            Route::get('/materials-export', [MaterialController::class, 'export'])->name('tenant.materials.export');
        });
        
        // ============================================================
        // EQUIPOS (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::resource('equipments', EquipmentController::class)->names('tenant.equipments');
            Route::get('/equipments-import', [EquipmentController::class, 'importForm'])->name('tenant.equipments.import.form');
            Route::post('/equipments-import', [EquipmentController::class, 'import'])->name('tenant.equipments.import');
            Route::get('/equipments-export', [EquipmentController::class, 'export'])->name('tenant.equipments.export');
        });
        
        // ============================================================
        // MANO DE OBRA (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::resource('labors', LaborController::class)->names('tenant.labors');
            Route::get('/labors-import', [LaborController::class, 'importForm'])->name('tenant.labors.import.form');
            Route::post('/labors-import', [LaborController::class, 'import'])->name('tenant.labors.import');
            Route::get('/labors-export', [LaborController::class, 'export'])->name('tenant.labors.export');
        });
        
        // ============================================================
        // TRANSPORTE (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::resource('transports', TransportController::class)->names('tenant.transports');
            Route::get('/transports-import', [TransportController::class, 'importForm'])->name('tenant.transports.import.form');
            Route::post('/transports-import', [TransportController::class, 'import'])->name('tenant.transports.import');
            Route::get('/transports-export', [TransportController::class, 'export'])->name('tenant.transports.export');
        });
        
        // ============================================================
        // PRESUPUESTOS (TENANT)
        // ============================================================
        
        Route::middleware(['auth'])->group(function () {
            Route::resource('budgets', BudgetController::class)->names('tenant.budgets');
            Route::get('/budgets/create-with-milestones', [BudgetController::class, 'createWithMilestones'])->name('tenant.budgets.create-with-milestones');
            Route::get('/budgets/show-with-milestones/{id}', [BudgetController::class, 'showWithMilestones'])->name('tenant.budgets.show-with-milestones');
            Route::get('/budgets/create-chapter', [BudgetController::class, 'createChapter'])->name('tenant.budgets.create-chapter');
            Route::post('/budgets/store-chapter', [BudgetController::class, 'storeChapter'])->name('tenant.budgets.store-chapter');
            Route::get('/budgets/show-chapter/{id}', [BudgetController::class, 'showChapter'])->name('tenant.budgets.show-chapter');
            Route::get('/budgets/export-chapter/{id}', [BudgetController::class, 'exportChapter'])->name('tenant.budgets.export-chapter');
            Route::get('/budgets/export-presupuesto/{id}', [BudgetController::class, 'exportPresupuesto'])->name('tenant.budgets.export-presupuesto');
            Route::get('/budgets/export-complete/{id}', [BudgetController::class, 'exportComplete'])->name('tenant.budgets.export-complete');
            Route::get('/budgets/export-hierarchical/{id}', [BudgetController::class, 'exportHierarchical'])->name('tenant.budgets.export-hierarchical');
        });
    });
});

// ============================================================
// RUTA DE FALLBACK
// ============================================================

Route::fallback(function () {
    return redirect()->route('login');
});