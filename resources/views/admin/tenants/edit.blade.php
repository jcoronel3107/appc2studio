echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px; max-width: 800px; margin: 0 auto;">
        <h1 style="margin: 0 0 20px 0;">✏️ Editar Cliente: {{ $tenant->name }}</h1>
        
        <form method="POST" action="{{ route("admin.tenants.update", $tenant->id) }}">
            @csrf
            @method("PUT")
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre de la Empresa:</label>
                <input type="text" name="name" value="{{ old("name", $tenant->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error("name")
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Subdominio:</label>
                <div style="display: flex; align-items: center;">
                    <input type="text" name="subdomain" value="{{ old("subdomain", $tenant->subdomain) }}" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" readonly>
                    <span style="margin-left: 10px; color: #6c757d;">.localhost:8000</span>
                </div>
                <small style="color: #6c757d;">El subdominio no se puede modificar después de la creación.</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email del Administrador:</label>
                <input type="email" name="email" value="{{ old("email", $tenant->email) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                @error("email")
                    <span style="color: #ef4444; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Teléfono:</label>
                <input type="text" name="phone" value="{{ old("phone", $tenant->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Plan:</label>
                <select name="plan" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="free" {{ old("plan", $tenant->plan) == "free" ? "selected" : "" }}>Gratis</option>
                    <option value="pro" {{ old("plan", $tenant->plan) == "pro" ? "selected" : "" }}>Pro - $49/mes</option>
                    <option value="enterprise" {{ old("plan", $tenant->plan) == "enterprise" ? "selected" : "" }}>Enterprise - $99/mes</option>
                </select>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <input type="checkbox" name="is_active" value="1" {{ old("is_active", $tenant->is_active) ? "checked" : "" }} style="margin-right: 8px;">
                    Activo
                </label>
            </div>
            
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; cursor: pointer; border-radius: 4px;">💾 Actualizar Cliente</button>
                <a href="{{ route("admin.tenants.index") }}" style="background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection' > resources\views\admin\tenants\edit.blade.php