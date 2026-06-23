<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Tenant;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener subdominio
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];
        
        // Si es localhost o la URL principal, continuar sin tenant
        if ($subdomain === 'www' || $subdomain === 'localhost' || $subdomain === 'app' || $subdomain === '127.0.0.1') {
            return $next($request);
        }
        
        // Buscar el tenant
        $tenant = Tenant::where('subdomain', $subdomain)->first();
        
        if (!$tenant) {
            abort(404, 'Empresa no encontrada');
        }
        
        // Verificar suscripción
        if ($tenant->subscription_expires && $tenant->subscription_expires < now()) {
            abort(403, 'Suscripción expirada. Contacte al administrador.');
        }
        
        if (!$tenant->is_active) {
            abort(403, 'Cuenta desactivada. Contacte al administrador.');
        }
        
        // Verificar que el usuario autenticado tiene acceso a este tenant
        if (auth()->check()) {
            $user = auth()->user();
            
            // Si no es admin y no pertenece al tenant
            if (!$user->is_admin && $user->tenant_id != $tenant->id) {
                // Intentar asociar al usuario con el tenant (si es su primer acceso)
                if ($user->tenant_id === null) {
                    $user->update(['tenant_id' => $tenant->id]);
                } else {
                    abort(403, 'No tienes acceso a esta empresa');
                }
            }
        }
        
        // ✅ CORREGIDO: La ruta correcta es "tenants/{subdominio}.sqlite" (sin "database/" al inicio)
        // porque database_path() ya incluye la carpeta "database/"
        $correctPath = "tenants/{$subdomain}.sqlite";
        
        // Actualizar la ruta en la base de datos si es incorrecta
        if ($tenant->database_path !== $correctPath) {
            $tenant->update(['database_path' => $correctPath]);
            \Log::info('Ruta de tenant actualizada:', [
                'subdomain' => $subdomain,
                'nueva_ruta' => $correctPath
            ]);
        }
        
        // Construir la ruta completa usando database_path()
        $dbPath = database_path($correctPath);
        
        // Verificar que el directorio existe, si no, crearlo
        $directory = dirname($dbPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
            \Log::info('Directorio de tenants creado:', ['path' => $directory]);
        }
        
        // Verificar que el archivo existe, si no, crearlo
        if (!file_exists($dbPath)) {
            touch($dbPath);
            chmod($dbPath, 0644);
            \Log::info('Base de datos del tenant creada:', [
                'subdomain' => $subdomain,
                'path' => $dbPath
            ]);
        }
        
        // Guardar el tenant en la sesión
        session(['tenant_id' => $tenant->id]);
        session(['tenant_name' => $tenant->name]);
        session(['tenant_database' => $dbPath]);
        
        // Configurar la conexión dinámica
        Config::set('database.connections.tenant', [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        
        // Conectar a la base de datos del tenant
        DB::purge('tenant');
        DB::connection('tenant');
        
        // Log para verificar la conexión
        \Log::info('Tenant conectado:', [
            'subdomain' => $subdomain,
            'database' => $dbPath,
            'exists' => file_exists($dbPath),
            'connection_name' => DB::connection('tenant')->getDatabaseName()
        ]);
        
        // Compartir el tenant con todas las vistas
        view()->share('currentTenant', $tenant);
        
        return $next($request);
    }
}