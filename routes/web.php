<?php
use App\Http\Controllers\ApuImportController;
use App\Http\Controllers\ApuController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-controller', [ApuImportController::class, 'test']);

Route::get('/importar', fn() => view('import'));
Route::post('/importar-apu', [ApuImportController::class, 'import'])->name('apu.import');

Route::get('/logs', function () {
    $log = file_get_contents(storage_path('logs/laravel.log'));
    return "<pre>" . nl2br(e(substr($log, -5000))) . "</pre>";
});
Route::get('/test-upload', function () {
    return view('test-upload');
});

Route::post('/test-upload', function (Illuminate\Http\Request $request) {
    if (!$request->hasFile('file')) {
        return back()->with('error', 'No se recibió archivo');
    }
    
    $file = $request->file('file');
    return back()->with('success', 'Archivo recibido: ' . $file->getClientOriginalName() . 
        ' | Tamaño: ' . $file->getSize() . ' bytes | Tipo: ' . $file->getMimeType());
})->name('test.upload');

use Illuminate\Http\Request;

Route::get('/debug-upload', function () {
    return '
    <!DOCTYPE html>
    <html>
    <head><title>Debug Upload</title></head>
    <body>
        <h1>Debug - Probar subida de archivos</h1>
        <form method="POST" action="/debug-upload" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <input type="file" name="file" required>
            <button type="submit">Subir</button>
        </form>
    </body>
    </html>
    ';
});

Route::post('/debug-upload', function (Request $request) {
    $result = [
        'has_file' => $request->hasFile('file'),
        'files_keys' => array_keys($_FILES),
        'files_content' => $_FILES,
        'post_data' => $_POST,
        'server_content_type' => $_SERVER['CONTENT_TYPE'] ?? 'no',
    ];
    
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $result['file_name'] = $file->getClientOriginalName();
        $result['file_size'] = $file->getSize();
        $result['file_mime'] = $file->getMimeType();
        $result['error_code'] = $file->getError();
    }
    
    return "<pre>" . print_r($result, true) . "</pre>";
});

// Rutas para ver APUs
Route::get('/apus', [ApuController::class, 'index'])->name('apus.index');
Route::get('/apu/{id}', [ApuController::class, 'show'])->name('apus.show');
Route::get('/apu-summary', [ApuController::class, 'summary'])->name('apus.summary');

// Rutas de exportación
Route::get('/exportar-apus', [ApuController::class, 'exportAll'])->name('export.apus');
Route::get('/exportar-apu/{id}', [ApuController::class, 'exportSingle'])->name('export.apu');

Route::get('/apu/{id}/edit', [ApuController::class, 'edit'])->name('apus.edit');
Route::put('/apu/{id}', [ApuController::class, 'update'])->name('apus.update');