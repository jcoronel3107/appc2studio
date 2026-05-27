echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>➕ Nueva Mano de Obra</h1>
        <form method="POST" action="{{ route("labors.store") }}">
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
                <label>Categoría:</label>
                <select name="category" style="width:100%; padding: 8px;">
                    <option value="">Seleccione...</option>
                    <option value="Operario">ESTRUCTURA OCUPACIONAL E2 (PRIMERA Y SEGUNDA CATEGORÍA)</option>
                    <option value="Oficial">ESTRUCTURA OCUPACIONAL D2</option>
                    <option value="Ayudante">ESTRUCTURA OCUPACIONAL C2</option>
                    <option value="Capataz">ESTRUCTURA OCUPACIONAL C1</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL B3</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL B1</option>
                    <option value="Supervisor">LABORATORIO</option>
                    <option value="Supervisor">TOPOGRAFÍA</option>
                    <option value="Supervisor">DIBUJANTES</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL C2 (GRUPO A)</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) SECCION C: SIN TÍTULO</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL C1 (Estr,Oc,C1) CHOFERES SECCION C: SIN TÍTULO</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL E2</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL C1 (GRUPO I)</option>
                    <option value="Supervisor">ESTRUCTURA OCUPACIONAL C2 (GRUPO II)</option>
                    <option value="Supervisor">OPERADORES Y MECÁNICOS DE EQUIPO PESADO Y CAMINERO DE EXCAVACIÓN, </option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <select name="unit" required style="width:100%; padding: 8px;">
                    <option value="hora">Hora</option>
                    <option value="día">Día</option>
                    <option value="mes">Mes</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tarifa por Hora (US$):</label>
                <input type="number" step="0.01" name="hourly_rate" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tarifa por Día (US$):</label>
                <input type="number" step="0.01" name="daily_rate" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" placeholder="Ej: POR CONTRATO, LARGO PLAZO" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Descripción:</label>
                <textarea name="description" rows="3" style="width:100%; padding: 8px;"></textarea>
            </div>
            <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none;">Guardar</button>
            <a href="{{ route("labors.index") }}">Cancelar</a>
        </form>
    </div>
</div>
@endsection' > resources\views\labors\create.blade.php