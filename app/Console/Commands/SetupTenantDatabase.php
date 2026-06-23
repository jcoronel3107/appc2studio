<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class SetupTenantDatabase extends Command
{
    protected $signature = 'tenant:setup-db {subdomain?}';
    protected $description = 'Configura la base de datos para uno o todos los tenants';

    public function handle()
    {
        $subdomain = $this->argument('subdomain');
        
        if ($subdomain) {
            $tenants = Tenant::where('subdomain', $subdomain)->get();
        } else {
            $tenants = Tenant::all();
        }
        
        if ($tenants->isEmpty()) {
            $this->error('No se encontraron tenants');
            return 1;
        }
        
        foreach ($tenants as $tenant) {
            $this->info("\n📦 Configurando tenant: {$tenant->subdomain}");
            $this->setupTenantDatabase($tenant);
        }
        
        $this->info("\n✅ ¡Todos los tenants configurados correctamente!");
        return 0;
    }
    
    private function setupTenantDatabase($tenant)
    {
        // ✅ CORREGIR: Usar database_path directamente
    $dbPath = database_path("tenants/{$tenant->subdomain}.sqlite");
    $correctPath = "database/tenants/{$tenant->subdomain}.sqlite";
    
    // Actualizar la ruta en la base de datos
    if ($tenant->database_path !== $correctPath) {
        $tenant->update(['database_path' => $correctPath]);
        $this->info("  📝 Ruta actualizada: {$correctPath}");
    }
    
    // Crear el directorio y archivo
    $directory = dirname($dbPath);
    
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true);
        $this->info("  📁 Directorio creado: {$directory}");
    }
    
    if (!File::exists($dbPath)) {
        File::put($dbPath, '');
        chmod($dbPath, 0644);
        $this->info("  📄 Archivo creado: {$dbPath}");
    } else {
        $this->info("  ✅ Archivo existe: {$dbPath}");
    }



        // 1. Asegurar que la ruta sea correcta
        $correctPath = "database/tenants/{$tenant->subdomain}.sqlite";
        if ($tenant->database_path !== $correctPath) {
            $tenant->update(['database_path' => $correctPath]);
            $this->info("  📝 Ruta actualizada: {$correctPath}");
        }
        
        // 2. Crear el directorio y archivo
        $dbPath = database_path($correctPath);
        $directory = dirname($dbPath);
        
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
            $this->info("  📁 Directorio creado: {$directory}");
        }
        
        if (!File::exists($dbPath)) {
            File::put($dbPath, '');
            chmod($dbPath, 0644);
            $this->info("  📄 Archivo creado: {$dbPath}");
        } else {
            $this->info("  ✅ Archivo existe: {$dbPath}");
        }
        
        // 3. Configurar la conexión para este tenant
        $this->setTenantConnection($dbPath);
        
        // 4. Ejecutar migraciones
        $this->info("  🔄 Ejecutando migraciones...");
        $this->call('migrate', [
            '--database' => 'tenant',
            '--force' => true,
            '--path' => 'database/migrations/tenant'
        ]);
        
        // 5. Si no hay migraciones específicas, crear tablas directamente
        if (!Schema::connection('tenant')->hasTable('transports')) {
            $this->info("  📋 Creando tablas directamente...");
            $this->createTenantTables();
        }
        
        $this->info("  ✅ Tenant '{$tenant->subdomain}' configurado");
    }
    
    private function setTenantConnection($dbPath)
    {
        config(['database.connections.tenant' => [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]]);
        
        DB::purge('tenant');
        DB::connection('tenant');
    }
    
    private function createTenantTables()
    {
        // Crear todas las tablas necesarias
        $tables = [
            'transports' => function($table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('name', 255);
                $table->string('category', 100)->nullable();
                $table->string('unit', 50)->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->string('term', 50)->nullable();
                $table->text('description')->nullable();
                $table->foreignId('tenant_id')->nullable();
                $table->timestamps();
            },
            'equipments' => function($table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('name', 255);
                $table->string('category', 100)->nullable();
                $table->string('unit', 50)->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->string('term', 50)->nullable();
                $table->text('description')->nullable();
                $table->foreignId('tenant_id')->nullable();
                $table->timestamps();
            },
            'labors' => function($table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('name', 255);
                $table->string('category', 100)->nullable();
                $table->string('unit', 50)->nullable();
                $table->decimal('tarifa_hora', 15, 2)->nullable();
                $table->decimal('tarifa_dia', 15, 2)->nullable();
                $table->string('term', 50)->nullable();
                $table->text('description')->nullable();
                $table->foreignId('tenant_id')->nullable();
                $table->timestamps();
            },
            'materials' => function($table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('name', 255);
                $table->string('category', 100)->nullable();
                $table->string('unit', 50)->nullable();
                $table->decimal('price', 15, 2)->nullable();
                $table->string('term', 50)->nullable();
                $table->text('description')->nullable();
                $table->foreignId('tenant_id')->nullable();
                $table->timestamps();
            },
        ];
        
        foreach ($tables as $tableName => $callback) {
            if (!Schema::connection('tenant')->hasTable($tableName)) {
                Schema::connection('tenant')->create($tableName, $callback);
                $this->info("    ✅ Tabla {$tableName} creada");
            }
        }
    }
}