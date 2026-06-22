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
        
        // Guardar el tenant en la sesión
        session(['tenant_id' => $tenant->id]);
        session(['tenant_name' => $tenant->name]);
        session(['tenant_database' => $tenant->database_path]);
        
        // Configurar la conexión dinámica
        $dbPath = storage_path($tenant->database_path);
        
        if (!file_exists($dbPath)) {
            abort(500, 'Base de datos del cliente no encontrada. Contacte al administrador.');
        }
        
        Config::set('database.connections.tenant', [
            'driver' => 'sqlite',
            'database' => $dbPath,
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        
        // Conectar a la base de datos del tenant
        DB::purge('tenant');
        DB::connection('tenant');
        
        // Compartir el tenant con todas las vistas
        view()->share('currentTenant', $tenant);
        
        return $next($request);
    }
}