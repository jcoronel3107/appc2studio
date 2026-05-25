echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>✏️ Editar Material</h1>
        <form method="POST" action="{{ route("materials.update", $material->id) }}">
            @csrf
            @method("PUT")
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" value="{{ $material->code }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" value="{{ $material->name }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <input type="text" name="unit" value="{{ $material->unit }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Precio:</label>
                <input type="number" step="0.01" name="price" value="{{ $material->price }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <input type="text" name="category" value="{{ $material->category }}" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" value="{{ $material->termino }}" placeholder="Ej: POR CONTRATO, LARGO PLAZO, etc." style="width:100%; padding: 8px;">
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none;">Actualizar</button>
            <a href="{{ route("materials.index") }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection' > resources\views\materials\edit.blade.php