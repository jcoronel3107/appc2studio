<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

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

        try {
            $dbPath = 'database/tenants/' . $request->subdomain . '.sqlite';
            File::ensureDirectoryExists('database/tenants');
            File::put($dbPath, '');

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

            config()->set('database.connections.tenant.database', storage_path($dbPath));
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true,
            ]);

            return redirect()->route('admin.tenants.index')
                ->with('success', 'Tenant ' . $tenant->name . ' creado exitosamente!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
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
            ->with('success', 'Tenant ' . $tenant->name . ' actualizado exitosamente!');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);

        if (File::exists($tenant->database_path)) {
            File::delete($tenant->database_path);
        }

        $tenant->delete();

        return redirect()->route('admin.tenants.index')
            ->with('success', 'Tenant eliminado exitosamente!');
    }

    public function switch($id)
    {
        $tenant = Tenant::findOrFail($id);
        session(['tenant_id' => $tenant->id]);
        return redirect()->route('dashboard')
            ->with('success', 'Cambiado al tenant: ' . $tenant->name);
    }
}