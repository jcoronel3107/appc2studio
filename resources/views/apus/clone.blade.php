@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📋 Clonar APU: {{ $apuOriginal->code }} - {{ $apuOriginal->name }}</h1>
        
        <div style="background: #fef9c3; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 5px solid #eab308;">
            <p><strong>⚠️ Información:</strong> Estás clonando el APU "{{ $apuOriginal->code }} - {{ $apuOriginal->name }}"</p>
            <p>Puedes modificar los valores y luego decidir si guardar como <strong>NUEVO APU</strong> o <strong>SOBRESCRIBIR</strong> el existente.</p>
        </div>
        
        <form method="POST" action="{{ route('apus.clone.store', $apuOriginal->id) }}" id="apuForm">
            @csrf
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>📋 Datos Generales</h3>
                <div style="margin-bottom: 10px;">
                    <label>Código:</label>
                    <input type="text" name="code" id="code" value="{{ $apuOriginal->code }}" required placeholder="📝 Ej: APU001" style="width:100%; padding: 8px;">
                    <small style="color: #666;">Si guardas como nuevo, cambia el código</small>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Rubro:</label>
                    <input type="text" name="name" id="name" value="{{ $apuOriginal->name }}" required placeholder="🏷️ Ej: Construcción de muro" style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Unidad:</label>
                    <input type="text" name="unit" id="unit" value="{{ $apuOriginal->unit }}" required placeholder="📏 Ej: m2, m3, unidad" style="width:100%; padding: 8px;">
                </div>
            </div>
            
            <!-- EQUIPOS -->
            <div style="margin-bottom: 30px;">
                <h3>🖥️ EQUIPOS</h3>
                <div id="equipos-container">
                    @php $equiposItems = $apuOriginal->items->where('section', 'equipment'); @endphp
                    @foreach($equiposItems as $index => $item)
                    <div class="equipo-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="equipos[{{ $index }}][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                            <option value="">🔍 Seleccione un equipo...</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" data-price="{{ $equipo->price }}" data-unit="{{ $equipo->unit }}" {{ $item->description == $equipo->name ? 'selected' : '' }}>
                                    {{ $equipo->code }} - {{ $equipo->name }} (${{ number_format($equipo->price, 2) }}/{{ $equipo->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="equipos[{{ $index }}][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="{{ $item->quantity }}">
                        <input type="text" name="equipos[{{ $index }}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly value="{{ $item->unit_price ? 'hora' : '' }}">
                        <input type="number" name="equipos[{{ $index }}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly value="{{ $item->unit_price }}">
                        <input type="number" name="equipos[{{ $index }}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="{{ $item->performance ?? 1 }}">
                        <input type="number" name="equipos[{{ $index }}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly value="{{ $item->total }}">
                        <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-equipo" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Equipo</button>
            </div>
            
            <!-- MANO DE OBRA -->
            <div style="margin-bottom: 30px;">
                <h3>👷 MANO DE OBRA</h3>
                <div id="labors-container">
                    @php $laborsItems = $apuOriginal->items->where('section', 'labor'); @endphp
                    @foreach($laborsItems as $index => $item)
                    <div class="labor-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="labors[{{ $index }}][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                            <option value="">🔍 Seleccione un trabajador...</option>
                            @foreach($labors as $labor)
                                <option value="{{ $labor->id }}" data-price="{{ $labor->hourly_rate }}" data-unit="{{ $labor->unit }}" {{ $item->description == $labor->name ? 'selected' : '' }}>
                                    {{ $labor->code }} - {{ $labor->name }} (${{ number_format($labor->hourly_rate, 2) }}/{{ $labor->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="labors[{{ $index }}][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="{{ $item->quantity }}">
                        <input type="text" name="labors[{{ $index }}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
                        <input type="number" name="labors[{{ $index }}][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly value="{{ $item->unit_price }}">
                        <input type="number" name="labors[{{ $index }}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="{{ $item->performance ?? 1 }}">
                        <input type="number" name="labors[{{ $index }}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly value="{{ $item->total }}">
                        <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-labor" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Trabajador</button>
            </div>
            
            <!-- MATERIALES -->
            <div style="margin-bottom: 30px;">
                <h3>🧱 MATERIALES</h3>
                <div id="materiales-container">
                    @php $materialesItems = $apuOriginal->items->where('section', 'material'); @endphp
                    @foreach($materialesItems as $index => $item)
                    <div class="material-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="materiales[{{ $index }}][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                            <option value="">🔍 Seleccione un material...</option>
                            @foreach($materiales as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}" {{ $item->description == $material->name ? 'selected' : '' }}>
                                    {{ $material->code }} - {{ $material->name }} (${{ number_format($material->price, 2) }}/{{ $material->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="materiales[{{ $index }}][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="{{ $item->quantity }}">
                        <input type="text" name="materiales[{{ $index }}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
                        <input type="number" name="materiales[{{ $index }}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly value="{{ $item->unit_price }}">
                        <input type="number" name="materiales[{{ $index }}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly value="{{ $item->total }}">
                        <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-material" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Material</button>
            </div>
            
            <!-- TOTALES DEL APU -->
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: right;">
                <p><strong>SUBTOTAL EQUIPOS:</strong> $ <span id="subtotal-equipos">0.00</span></p>
                <p><strong>SUBTOTAL MANO DE OBRA:</strong> $ <span id="subtotal-labors">0.00</span></p>
                <p><strong>SUBTOTAL MATERIALES:</strong> $ <span id="subtotal-materiales">0.00</span></p>
                <hr style="margin: 10px 0;">
                <p><strong>TOTAL COSTO DIRECTO:</strong> $ <span id="total-directo">0.00</span></p>
                <p><strong>INDIRECTOS (20%):</strong> $ <span id="indirectos">0.00</span></p>
                <p style="font-size: 20px; font-weight: bold;"><strong>COSTO TOTAL DEL RUBRO:</strong> $ <span id="total-general">0.00</span></p>
            </div>
            
            <input type="hidden" name="total_direct_cost" id="total_direct_cost" value="0">
            <input type="hidden" name="indirect_cost" id="indirect_cost" value="0">
            <input type="hidden" name="total_cost" id="total_cost" value="0">
            
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="submit" name="action" value="nuevo" style="background: #22c55e; color: white; padding: 12px 25px; border: none; cursor: pointer; font-size: 16px;">
                    💾 Guardar como NUEVO APU
                </button>
                <button type="submit" name="action" value="sobrescribir" style="background: #eab308; color: white; padding: 12px 25px; border: none; cursor: pointer; font-size: 16px;">
                    🔄 Sobrescribir APU existente
                </button>
                <a href="{{ route('apus.index') }}" style="background: #6c757d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px;">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Aquí va todo el JavaScript de cálculos de create.blade.php
    // (Incluir las mismas funciones de cálculo)
    
    function calcularTotalEquipo(row) { /* ... */ }
    function calcularTotalLabor(row) { /* ... */ }
    function calcularTotalMaterial(row) { /* ... */ }
    function recalcularTotalesGenerales() { /* ... */ }
    function configurarEventosEquipo(row) { /* ... */ }
    function configurarEventosLabor(row) { /* ... */ }
    function configurarEventosMaterial(row) { /* ... */ }
    
    // Configurar filas existentes
    document.querySelectorAll(".equipo-row").forEach(row => configurarEventosEquipo(row));
    document.querySelectorAll(".labor-row").forEach(row => configurarEventosLabor(row));
    document.querySelectorAll(".material-row").forEach(row => configurarEventosMaterial(row));
    
    // Contadores y funciones de agregar (igual que en create)
    let equipoIndex = {{ $equiposItems->count() }};
    let laborIndex = {{ $laborsItems->count() }};
    let materialIndex = {{ $materialesItems->count() }};
    
    // Agregar equipo (similar al create)
    document.getElementById("add-equipo").addEventListener("click", function() { /* ... */ });
    document.getElementById("add-labor").addEventListener("click", function() { /* ... */ });
    document.getElementById("add-material").addEventListener("click", function() { /* ... */ });
    
    recalcularTotalesGenerales();
</script>
@endsection