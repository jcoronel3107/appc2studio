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
        <div style="margin-top: 20px;">{{ $labors->links() }}</div>
    </div>
</div>
@endsection' > resources\views\labors\index.blade.php