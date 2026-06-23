<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {subdomain} {name} {email}';
    protected $description = 'Crear un nuevo cliente con su base de datos';

    public function handle()
{
    $subdomain = $this->argument('subdomain');
    
    // Crear la base de datos del tenant
    $dbPath = database_path("tenants/{$subdomain}.sqlite");
    
    // Crear el archivo si no existe
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0644);
    }
    
    // Crear el tenant en la base master
    $tenant = Tenant::create([
        'name' => $this->argument('name'),
        'subdomain' => $subdomain,
        'email' => $this->argument('email'),
        'database_path' => "database/tenants/{$subdomain}.sqlite", // ✅ Ruta relativa
        'plan' => $this->argument('plan') ?? 'free',
        'is_active' => true,
        'subscription_expires' => now()->addYear(),
    ]);
    
    // ... resto del código
}
}