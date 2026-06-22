<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    public function index()
    {
        try {
            $tenants = Tenant::all();
            return view('admin.tenants.index', compact('tenants'));
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine();
        }
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subdomain' => 'required|string|max:255|unique:tenants',
            'email' => 'required|email|unique:tenants',
            'phone' => 'nullable|string|max:20',
            'plan' => 'required|in:free,pro,enterprise',
        ]);

        try 
        {
            // Crear archivo SQLite con ruta correcta
            $dbPath = 'database/tenants/' . $request->subdomain . '.sqlite';
            $fullDbPath = base_path($dbPath);
            
            $dbDirectory = base_path('database/tenants');
            if (!File::exists($dbDirectory)) {
                File::makeDirectory($dbDirectory, 0755, true);
            }
            
            File::put($fullDbPath, '');

            // Crear tenant
            $tenant = Tenant::create([
                'name' => $request->name,
                'subdomain' => $request->subdomain,
                'database_path' => $dbPath,
                'email' => $request->email,
                'phone' => $request->phone,
                'plan' => $request->plan,
                'subscription_expires' => $request->subscription_expires ?? now()->addYear(),
                'is_active' => $request->has('is_active'),
            ]);

            // Configurar conexión
            Config::set('database.connections.tenant', [
                'driver' => 'sqlite',
                'database' => $fullDbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]);

            // Ejecutar migraciones
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true,
            ]);

            // Crear usuario admin
            Config::set('database.default', 'tenant');
            DB::purge('tenant');
            DB::connection('tenant');

            if (Schema::connection('tenant')->hasTable('users')) {
                $userClass = 'App\Models\User';
                $userClass::on('tenant')->create([
                    'name' => 'Administrador',
                    'email' => $request->email,
                    'password' => bcrypt('password123'),
                    'is_admin' => true,
                ]);
            }

            return redirect()->route('admin.tenants.index')
                ->with('success', '✅ Cliente creado exitosamente! Acceso: http://' . $request->subdomain . '.localhost:8000');

        } catch (\Exception $e) {
            return back()->with('error', '❌ Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'plan' => 'required|in:free,pro,enterprise',
        ]);

        $tenant->update($request->all());

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Cliente actualizado exitosamente!');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);

        // Eliminar archivo de base de datos
        $dbPath = database_path($tenant->database_path);
        if (File::exists($dbPath)) {
            File::delete($dbPath);
        }

        $tenant->delete();

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Cliente eliminado exitosamente!');
    }

    public function switch($id)
    {
        $tenant = Tenant::findOrFail($id);
        session(['tenant_id' => $tenant->id]);
        return redirect()->route('dashboard')
            ->with('success', 'Cambiado al tenant: ' . $tenant->name);
    }
}