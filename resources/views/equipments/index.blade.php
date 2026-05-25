echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🖥️ Equipos</h1>
        <a href="{{ route("equipments.create") }}">➕ Nuevo Equipo</a>
        <a href="{{ route("equipments.import.form") }}">📤 Importar</a>
        <a href="{{ route("equipments.export") }}">💾 Exportar</a>
        
        @if(session("success"))
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ {{ session("success") }}</div>
        @endif
        
        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipments as $equipment)
                <tr>
                    <td>{{ $equipment->code }}</td>
                    <td>{{ $equipment->name }}</td>
                    <td>{{ $equipment->category ?? "-" }}</td>
                    <td>{{ $equipment->unit }}</td>
                    <td>${{ number_format($equipment->price, 2) }}</td>
                    <td>{{ $equipment->termino ?? "-" }}</td>
                    <td>
                        <a href="{{ route("equipments.edit", $equipment->id) }}">✏️ Editar</a>
                        <form action="{{ route("equipments.destroy", $equipment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method("DELETE")
                            <button type="submit" onclick="return confirm(\"¿Eliminar este equipo?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px;">{{ $equipments->links() }}</div>
    </div>
</div>
@endsection' > resources\views\equipments\index.blade.php