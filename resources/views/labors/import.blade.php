echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📤 Importar Mano de Obra</h1>
        
        @if(session("error"))
            <div style="background: #fee2e2; color: #991b1b; padding: 12px; margin-bottom: 20px;">❌ {{ session("error") }}</div>
        @endif
        
        <form method="POST" action="{{ route("labors.import") }}" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Archivo Excel:</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required>
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none;">Importar</button>
            <a href="{{ route("labors.index") }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection' > resources\views\labors\import.blade.php