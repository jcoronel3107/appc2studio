echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>👷 Mano de Obra</h1>
        <a href="{{ route("labors.create") }}">➕ Nuevo Registro</a>
        <a href="{{ route("labors.import.form") }}">📤 Importar</a>
        <a href="{{ route("labors.export") }}">💾 Exportar</a>
        
        @if(session("success"))
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ {{ session("success") }}</div>
        @endif
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="{{ route('labors.index') }}" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="{{ request('search') }}" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                @if(request('search'))
                    <a href="{{ route('labors.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                @endif
            </form>
        </div>

        @if(request('search'))
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                Resultados para: <strong>"{{ request('search') }}"</strong> - {{ $labors->total() }} encontrados
            </div>
        @endif



        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Tarifa/Hora</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($labors as $labor)
                <tr>
                    <td>{{ $labor->code }}</td>
                    <td>{{ $labor->name }}</td>
                    <td>{{ $labor->category ?? "-" }}</td>
                    <td>{{ $labor->unit }}</td>
                    <td>${{ number_format($labor->hourly_rate, 2) }}</td>
                    <td>{{ $labor->termino ?? "-" }}</td>
                    <td>
                        <a href="{{ route("labors.edit", $labor->id) }}">✏️ Editar</a>
                        <form action="{{ route("labors.destroy", $labor->id) }}" method="POST" style="display:inline;">
                            @csrf @method("DELETE")
                            <button type="submit" onclick="return confirm(\"¿Eliminar?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container" style="margin-top: 20px; text-align: center;">
            {{ $labors->links() }}
        </div>
    </div>
</div>
@endsection' > resources\views\labors\index.blade.php