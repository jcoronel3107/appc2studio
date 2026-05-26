echo '@extends("layouts.app")

@section("content")
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Análisis de Precios Unitarios</h1>
        
        <form method="POST" action="{{ route("apus.store") }}">
            @csrf
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>Datos Generales</h3>
                <div style="margin-bottom: 10px;">
                    <label>Código:</label>
                    <input type="text" name="code" required style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Rubro:</label>
                    <input type="text" name="name" required style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Unidad:</label>
                    <input type="text" name="unit" required style="width:100%; padding: 8px;">
                </div>
            </div>
            
            <!-- EQUIPOS -->
            <div style="margin-bottom: 30px;">
                <h3>🖥️ EQUIPOS</h3>
                <div id="equipos-container">
                    <div class="equipo-row" style="margin-bottom: 10px; display: flex; gap: 10px;">
                        <select name="equipos[0][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                            <option value="">Seleccione un equipo...</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" data-price="{{ $equipo->price }}" data-unit="{{ $equipo->unit }}">
                                    {{ $equipo->code }} - {{ $equipo->name }} (${{ number_format($equipo->price, 2) }}/{{ $equipo->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="equipos[0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad">
                        <input type="text" name="equipos[0][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
                        <input type="number" name="equipos[0][performance]" placeholder="Rendimiento" step="0.01" style="flex: 1; padding: 8px;">
                        <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" id="add-equipo" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Equipo</button>
            </div>
            
            <!-- MATERIALES -->
            <div style="margin-bottom: 30px;">
                <h3>🧱 MATERIALES</h3>
                <div id="materiales-container">
                    <div class="material-row" style="margin-bottom: 10px; display: flex; gap: 10px;">
                        <select name="materiales[0][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                            <option value="">Seleccione un material...</option>
                            @foreach($materiales as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">
                                    {{ $material->code }} - {{ $material->name }} (${{ number_format($material->price, 2) }}/{{ $material->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="materiales[0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad">
                        <input type="text" name="materiales[0][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
                        <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" id="add-material" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Material</button>
            </div>
            
            <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer;">💾 Guardar APU</button>
            <a href="{{ route("apus.index") }}">Cancelar</a>
        </form>
    </div>
</div>

<script>
    // Contadores para índices
    let equipoIndex = 1;
    let materialIndex = 1;
    
    // Agregar equipo
    document.getElementById("add-equipo").addEventListener("click", function() {
        const container = document.getElementById("equipos-container");
        const newRow = document.createElement("div");
        newRow.className = "equipo-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px;";
        newRow.innerHTML = `
            <select name="equipos[${equipoIndex}][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                <option value="">Seleccione un equipo...</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" data-price="{{ $equipo->price }}" data-unit="{{ $equipo->unit }}">
                        {{ $equipo->code }} - {{ $equipo->name }} (${{ number_format($equipo->price, 2) }}/{{ $equipo->unit }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="equipos[${equipoIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad">
            <input type="text" name="equipos[${equipoIndex}][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
            <input type="number" name="equipos[${equipoIndex}][performance]" placeholder="Rendimiento" step="0.01" style="flex: 1; padding: 8px;">
            <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
        `;
        container.appendChild(newRow);
        
        // Agregar evento al select para cargar unidad
        const select = newRow.querySelector(".equipo-select");
        const unitInput = newRow.querySelector(".equipo-unidad");
        select.addEventListener("change", function() {
            const selectedOption = select.options[select.selectedIndex];
            const unit = selectedOption.getAttribute("data-unit");
            unitInput.value = unit || "";
        });
        
        // Agregar evento al botón eliminar
        newRow.querySelector(".remove-equipo").addEventListener("click", function() {
            newRow.remove();
        });
        
        equipoIndex++;
    });
    
    // Agregar material
    document.getElementById("add-material").addEventListener("click", function() {
        const container = document.getElementById("materiales-container");
        const newRow = document.createElement("div");
        newRow.className = "material-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px;";
        newRow.innerHTML = `
            <select name="materiales[${materialIndex}][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                <option value="">Seleccione un material...</option>
                @foreach($materiales as $material)
                    <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">
                        {{ $material->code }} - {{ $material->name }} (${{ number_format($material->price, 2) }}/{{ $material->unit }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="materiales[${materialIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad">
            <input type="text" name="materiales[${materialIndex}][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
            <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
        `;
        container.appendChild(newRow);
        
        // Agregar evento al select para cargar unidad
        const select = newRow.querySelector(".material-select");
        const unitInput = newRow.querySelector(".material-unidad");
        select.addEventListener("change", function() {
            const selectedOption = select.options[select.selectedIndex];
            const unit = selectedOption.getAttribute("data-unit");
            unitInput.value = unit || "";
        });
        
        // Agregar evento al botón eliminar
        newRow.querySelector(".remove-material").addEventListener("click", function() {
            newRow.remove();
        });
        
        materialIndex++;
    });
    
    // Eventos para filas iniciales
    document.querySelectorAll(".equipo-select").forEach(select => {
        const unitInput = select.closest(".equipo-row").querySelector(".equipo-unidad");
        select.addEventListener("change", function() {
            const selectedOption = select.options[select.selectedIndex];
            const unit = selectedOption.getAttribute("data-unit");
            unitInput.value = unit || "";
        });
    });
    
    document.querySelectorAll(".material-select").forEach(select => {
        const unitInput = select.closest(".material-row").querySelector(".material-unidad");
        select.addEventListener("change", function() {
            const selectedOption = select.options[select.selectedIndex];
            const unit = selectedOption.getAttribute("data-unit");
            unitInput.value = unit || "";
        });
    });
    
    // Botones eliminar iniciales
    document.querySelectorAll(".remove-equipo").forEach(btn => {
        btn.addEventListener("click", function() {
            btn.closest(".equipo-row").remove();
        });
    });
    
    document.querySelectorAll(".remove-material").forEach(btn => {
        btn.addEventListener("click", function() {
            btn.closest(".material-row").remove();
        });
    });
</script>
@endsection' > resources\views\apus\create.blade.php