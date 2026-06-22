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
        $name = $this->argument('name');
        $email = $this->argument('email');

        try {
            // 1. Crear archivo SQLite
            $dbPath = base_path('database/tenants/' . $subdomain . '.sqlite');
            $dbDirectory = base_path('database/tenants');
            
            if (!File::exists($dbDirectory)) {
                File::makeDirectory($dbDirectory, 0755, true);
            }
            
            if (!File::exists($dbPath)) {
                File::put($dbPath, '');
                $this->info('✅ Base de datos creada: ' . $dbPath);
            } else {
                $this->info('✅ Base de datos ya existe: ' . $dbPath);
            }

            // 2. Crear tenant
            $tenant = Tenant::create([
                'name' => $name,
                'subdomain' => $subdomain,
                'database_path' => 'database/tenants/' . $subdomain . '.sqlite',
                'email' => $email,
                'plan' => 'free',
                'is_active' => true,
                'subscription_expires' => now()->addYear(),
            ]);

            $this->info('✅ Cliente creado: ' . $tenant->name);

            // 3. Configurar conexión
            Config::set('database.connections.tenant', [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);

            // 4. Ejecutar migraciones
            $this->info('⏳ Ejecutando migraciones...');
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true,
            ]);
            $this->info('✅ Migraciones ejecutadas');

            // 5. Crear usuario admin
            Config::set('database.default', 'tenant');
            DB::purge('tenant');
            DB::connection('tenant');

            if (Schema::connection('tenant')->hasTable('users')) {
                $userClass = 'App\Models\User';
                $userClass::on('tenant')->create([
                    'name' => 'Administrador',
                    'email' => $email,
                    'password' => bcrypt('password123'),
                    'is_admin' => true,
                ]);
                $this->info('✅ Usuario admin creado');
            }

            $this->info('🔑 Email: ' . $email);
            $this->info('🔑 Password: password123');
            $this->info('🔗 URL: http://' . $subdomain . '.localhost:8000');

            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->error('En archivo: ' . $e->getFile() . ' línea ' . $e->getLine());
            return 1;
        }
    }
}