echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px; max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0;">🏢 Clientes (Tenants)</h1>
            <a href="{{ route("admin.tenants.create") }}" style="background: #22c55e; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">➕ Nuevo Cliente</a>
        </div>
        
        @if(session("success"))
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">✅ {{ session("success") }}</div>
        @endif
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #1e40af; color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Empresa</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Subdominio</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Email</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Plan</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Estado</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $tenant->id }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $tenant->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $tenant->subdomain }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $tenant->email }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <span style="background: 
                            @if($tenant->plan == "free") #6c757d
                            @elseif($tenant->plan == "pro") #3b82f6
                            @else #8b5cf6
                            @endif;
                            color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            {{ strtoupper($tenant->plan) }}
                        </span>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <span style="background: {{ $tenant->is_active ? "#22c55e" : "#ef4444" }}; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            {{ $tenant->is_active ? "ACTIVO" : "INACTIVO" }}
                        </span>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <a href="{{ route("admin.tenants.edit", $tenant->id) }}" style="color: #eab308;">✏️ Editar</a>
                        <form action="{{ route("admin.tenants.destroy", $tenant->id) }}" method="POST" style="display:inline; margin-left: 10px;">
                            @csrf @method("DELETE")
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm("¿Eliminar este cliente?")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center;">📭 No hay clientes registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection' > resources\views\admin\tenants\index.blade.php