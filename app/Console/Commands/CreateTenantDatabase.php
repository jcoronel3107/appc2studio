<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class CreateTenantDatabase extends Command
{
    protected $signature = 'tenant:create {subdomain} {name} {email}';
    protected $description = 'Crear base de datos para un nuevo cliente';

    public function handle()
    {
        $subdomain = $this->argument('subdomain');
        $name = $this->argument('name');
        $email = $this->argument('email');
        
        // Ruta de la base de datos del cliente
        $dbPath = "database/tenants/{$subdomain}.sqlite";
        
        // Crear archivo SQLite
        if (!File::exists($dbPath)) {
            File::ensureDirectoryExists('database/tenants');
            File::put($dbPath, '');
            $this->info("✅ Base de datos creada: {$dbPath}");
        }
        
        // Crear tenant en la base de datos maestra
        $tenant = Tenant::create([
            'name' => $name,
            'subdomain' => $subdomain,
            'database_path' => $dbPath,
            'email' => $email,
            'phone' => null,
            'subscription_expires' => now()->addYear(),
            'plan' => 'free',
            'is_active' => true,
        ]);
        
        $this->info("✅ Tenant creado: {$name} ({$subdomain})");
        
        // Ejecutar migraciones en la base de datos del tenant
        // Configurar temporalmente la conexión
        config()->set('database.connections.tenant.database', storage_path($dbPath));
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--force' => true,
        ]);
        
        $this->info("✅ Migraciones ejecutadas en la base de datos del tenant");
        
        // Crear usuario admin por defecto
        $this->call('tenant:create-user', [
            'subdomain' => $subdomain,
            'email' => 'admin@' . $subdomain . '.com',
            'password' => 'password123',
            'name' => 'Administrador'
        ]);
        
        $this->info("✅ Usuario admin creado: admin@{$subdomain}.com / password123");
        
        return 0;
    }
}