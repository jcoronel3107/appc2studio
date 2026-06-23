<?php
// fix_tenants.php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

echo "=== CORRIGIENDO TENANTS ===\n\n";

$tenants = Tenant::all();

foreach ($tenants as $tenant) {
    echo "Procesando: {$tenant->subdomain}\n";
    
    // Corregir la ruta en la base de datos
    $correctPath = "database/tenants/{$tenant->subdomain}.sqlite";
    
    if ($tenant->database_path !== $correctPath) {
        echo "  Antes: {$tenant->database_path}\n";
        $tenant->update(['database_path' => $correctPath]);
        echo "  Ahora: {$correctPath}\n";
    }
    
    // Crear el directorio y archivo físico
    $fullPath = database_path("tenants/{$tenant->subdomain}.sqlite");
    $directory = dirname($fullPath);
    
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
        echo "  📁 Directorio creado: {$directory}\n";
    }
    
    if (!File::exists($fullPath)) {
        File::put($fullPath, '');
        echo "  📄 Archivo creado: {$fullPath}\n";
    } else {
        echo "  ✅ Archivo existe: {$fullPath}\n";
    }
    
    echo "---\n\n";
}

echo "✅ ¡TODOS LOS TENANTS CORREGIDOS!\n";
echo "\nVerificación:\n";
foreach (Tenant::all() as $tenant) {
    $exists = File::exists(database_path($tenant->database_path));
    echo "  {$tenant->subdomain}: " . ($exists ? "✅" : "❌") . " - {$tenant->database_path}\n";
}