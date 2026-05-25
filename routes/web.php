<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApuImportController;
use App\Http\Controllers\ApuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Importar APU
    Route::get('/importar', fn() => view('import'));
    Route::post('/importar-apu', [ApuImportController::class, 'import'])->name('apu.import');
    
    // Ver APUs
    Route::get('/apus', [ApuController::class, 'index'])->name('apus.index');
    Route::get('/apu/{id}', [ApuController::class, 'show'])->name('apus.show');
    Route::get('/apu-summary', [ApuController::class, 'summary'])->name('apus.summary');
    Route::get('/apu/{id}/edit', [ApuController::class, 'edit'])->name('apus.edit');
    Route::put('/apu/{id}', [ApuController::class, 'update'])->name('apus.update');
    
    // Exportar
    Route::get('/exportar-apus', [ApuController::class, 'exportAll'])->name('export.apus');
    Route::get('/exportar-apu/{id}', [ApuController::class, 'exportSingle'])->name('export.apu');
});

// Rutas de prueba
Route::get('/test-upload', function () {
    return view('test-upload');
})->middleware(['auth']);

// Rutas de autenticación (las proporciona Breeze)
require __DIR__.'/auth.php';