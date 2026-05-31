echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📦 Materiales</h1>
        <a href="{{ route("materials.create") }}">➕ Nuevo Material</a>
        <a href="{{ route("materials.import.form") }}">📤 Importar</a>
        
        @if(session("success"))
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ {{ session("success") }}</div>
        @endif
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="{{ route('materials.index') }}" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="{{ request('search') }}" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                @if(request('search'))
                    <a href="{{ route('materials.index') }}" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                @endif
            </form>
        </div>
        @if(request('search'))
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            Resultados para: <strong>"{{ request('search') }}"</strong> - {{ $materials->total() }} encontrados
            </div>
        @endif



        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td>{{ $material->code }}</td>
                    <td>{{ $material->name }}</td>
                    <td>{{ $material->unit }}</td>
                    <td>${{ number_format($material->price, 2) }}</td>
                    <td>{{ $material->termino ?? "-" }}</td>
                    <td>
                        <a href="{{ route("materials.edit", $material->id) }}">✏️ Editar</a>
                        <form action="{{ route("materials.destroy", $material->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method("DELETE")
                            <button type="submit" onclick="return confirm(\"¿Eliminar este material?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-container" style="margin-top: 20px; text-align: center;">
            {{ $materials->links() }}
        </div>
    </div>
</div>
@endsection' > resources\views\materials\index.blade.php