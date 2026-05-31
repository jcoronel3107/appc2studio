echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>✏️ Editar Mano de Obra</h1>
        <form method="POST" action="{{ route("labors.update", $labor->id) }}">
            @csrf @method("PUT")
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" value="{{ $labor->code }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" value="{{ $labor->name }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <select name="category" style="width:100%; padding: 8px;">
                    <option value="">Seleccione...</option>
                    <option value="ESTRUCTURA OCUPACIONAL E2 (PRIMERA Y SEGUNDA CATEGORÍA)">ESTRUCTURA OCUPACIONAL E2 (PRIMERA Y SEGUNDA CATEGORÍA)</option>
                    <option value="ESTRUCTURA OCUPACIONAL D2">ESTRUCTURA OCUPACIONAL D2</option>
                    <option value="ESTRUCTURA OCUPACIONAL C2">ESTRUCTURA OCUPACIONAL C2</option>
                    <option value="ESTRUCTURA OCUPACIONAL C1">ESTRUCTURA OCUPACIONAL C1</option>
                    <option value="ESTRUCTURA OCUPACIONAL B3">ESTRUCTURA OCUPACIONAL B3</option>
                    <option value="ESTRUCTURA OCUPACIONAL B1">ESTRUCTURA OCUPACIONAL B1</option>
                    <option value="LABORATORIO">LABORATORIO</option>
                    <option value="TOPOGRAFÍA">TOPOGRAFÍA</option>
                    <option value="DIBUJANTES">DIBUJANTES</option>
                    <option value="ESTRUCTURA OCUPACIONAL C2 (GRUPO A)">ESTRUCTURA OCUPACIONAL C2 (GRUPO A)</option>
                    <option value="ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) SECCION C: SIN TÍTULO">ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) SECCION C: SIN TÍTULO</option>
                    <option value="ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) CHOFERES SECCION C: SIN TÍTULO">ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) CHOFERES SECCION C: SIN TÍTULO</option>
                    <option value="ESTRUCTURA OCUPACIONAL E2">ESTRUCTURA OCUPACIONAL E2</option>
                    <option value="ESTRUCTURA OCUPACIONAL C1 (GRUPO I)">ESTRUCTURA OCUPACIONAL C1 (GRUPO I)</option>
                    <option value="ESTRUCTURA OCUPACIONAL C2 (GRUPO II)">ESTRUCTURA OCUPACIONAL C2 (GRUPO II)</option>
                    <option value="OPERADORES Y MECÁNICOS DE EQUIPO PESADO Y CAMINERO DE EXCAVACIÓN, ">OPERADORES Y MECÁNICOS DE EQUIPO PESADO Y CAMINERO DE EXCAVACIÓN, </option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <select name="unit" required style="width:100%; padding: 8px;">
                    <option value="hora" {{ $labor->unit == "hora" ? "selected" : "" }}>Hora</option>
                    <option value="día" {{ $labor->unit == "día" ? "selected" : "" }}>Día</option>
                    <option value="mes" {{ $labor->unit == "mes" ? "selected" : "" }}>Mes</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tarifa por Hora (US$):</label>
                <input type="number" step="0.01" name="hourly_rate" value="{{ $labor->hourly_rate }}" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tarifa por Día (US$):</label>
                <input type="number" step="0.01" name="daily_rate" value="{{ $labor->daily_rate }}" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" value="{{ $labor->termino }}" placeholder="Ej: POR CONTRATO, LARGO PLAZO" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Descripción:</label>
                <textarea name="description" rows="3" style="width:100%; padding: 8px;">{{ $labor->description }}</textarea>
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none;">Actualizar</button>
            <a href="{{ route("labors.index") }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection' > resources\views\labors\edit.blade.php