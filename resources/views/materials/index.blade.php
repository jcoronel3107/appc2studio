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
        <div style="margin-top: 20px;">{{ $materials->links() }}</div>
    </div>
</div>
@endsection' > resources\views\materials\index.blade.php