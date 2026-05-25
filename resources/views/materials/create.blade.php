echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>➕ Nuevo Material</h1>
        <form method="POST" action="{{ route("materials.store") }}">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <input type="text" name="unit" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Precio:</label>
                <input type="number" step="0.01" name="price" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <input type="text" name="category" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" placeholder="Ej: POR CONTRATO, LARGO PLAZO, etc." style="width:100%; padding: 8px;">
            </div>
            <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none;">Guardar</button>
            <a href="{{ route("materials.index") }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection' > resources\views\materials\create.blade.php