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
        
        // Buscar el tenant
        $tenant = Tenant::where('subdomain', $subdomain)->first();
        
        if (!$tenant) {
            abort(404, 'Empresa no encontrada');
        }
        
        // Verificar suscripción
        if ($tenant->subscription_expires && $tenant->subscription_expires < now()) {
            abort(403, 'Suscripción expirada');
        }
        
        if (!$tenant->is_active) {
            abort(403, 'Cuenta desactivada');
        }
        
        // Cambiar la conexión a la base de datos del cliente
        // Guardamos el tenant en la sesión para usarlo después
        session(['tenant_id' => $tenant->id]);
        session(['tenant_database' => $tenant->database_path]);
        
        // Configurar la conexión dinámica
        Config::set('database.connections.tenant', [
            'driver' => 'sqlite',
            'database' => storage_path($tenant->database_path),
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
        
        // Conectar a la base de datos del tenant
        DB::purge('tenant');
        DB::connection('tenant');
        
        return $next($request);
    }
}