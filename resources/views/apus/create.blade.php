@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Análisis de Precios Unitarios</h1>
        
        <form method="POST" action="{{ route('apus.store') }}" id="apuForm">
            @csrf
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>📋 Datos Generales</h3>
                <div style="margin-bottom: 10px;">
                    <label>Código:</label>
                    <input type="text" name="code" required placeholder="📝 Ej: APU001" style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Rubro:</label>
                    <input type="text" name="name" required placeholder="🏷️ Ej: Construcción de muro" style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Unidad:</label>
                    <input type="text" name="unit" required placeholder="📏 Ej: m2, m3, unidad" style="width:100%; padding: 8px;">
                </div>
            </div>
            
            <!-- EQUIPOS -->
            <div style="margin-bottom: 30px;">
                <h3>🖥️ EQUIPOS</h3>
                <div id="equipos-container">
                    <div class="equipo-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="equipos[0][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                            <option value="">🔍 Seleccione un equipo...</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}" data-price="{{ $equipo->price }}" data-unit="{{ $equipo->unit }}">
                                    {{ $equipo->code }} - {{ $equipo->name }} (${{ number_format($equipo->price, 2) }}/{{ $equipo->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="equipos[0][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="0">
                        <input type="text" name="equipos[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
                        <input type="number" name="equipos[0][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly>
                        <input type="number" name="equipos[0][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="1">
                        <input type="number" name="equipos[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly>
                        <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" id="add-equipo" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Equipo</button>
            </div>
<<<<<<< HEAD
            
            <!-- MANO DE OBRA -->
            <div style="margin-bottom: 30px;">
                <h3>👷 MANO DE OBRA</h3>
                <div id="labors-container">
                    <div class="labor-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="labors[0][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                            <option value="">🔍 Seleccione un trabajador...</option>
                            @foreach($labors as $labor)
                                <option value="{{ $labor->id }}" data-price="{{ $labor->hourly_rate }}" data-unit="{{ $labor->unit }}">
                                    {{ $labor->code }} - {{ $labor->name }} (${{ number_format($labor->hourly_rate, 2) }}/{{ $labor->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="labors[0][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="0">
                        <input type="text" name="labors[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
                        <input type="number" name="labors[0][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly>
                        <input type="number" name="labors[0][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="1">
                        <input type="number" name="labors[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly>
                        <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" id="add-labor" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Trabajador</button>
            </div>
            
=======
            <!-- MANO DE OBRA -->
            <div style="margin-bottom: 30px;">
                  <h3>👷 MANO DE OBRA</h3>
                  <div id="labors-container">
                  <div class="labor-row" style="margin-bottom: 10px; display: flex; gap: 10px;">
                    <select name="labors[0][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                       <option value="">Seleccione un trabajador...</option>
                       @foreach($labors as $labor)
                            <option value="{{ $labor->id }}" data-price="{{ $labor->hourly_rate }}" data-unit="{{ $labor->unit }}">
                                {{ $labor->code }} - {{ $labor->name }} (${{ number_format($labor->hourly_rate, 2) }}/{{ $labor->unit }})
                            </option>
                       @endforeach
                    </select>
                   <input type="number" name="labors[0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad">
                     <input type="text" name="labors[0][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
                    <input type="number" name="labors[0][performance]" placeholder="Rendimiento" step="0.01" style="flex: 1; padding: 8px;">
                   <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
            </div>
                 </div>
            <button type="button" id="add-labor" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar Trabajador</button>
</div>



>>>>>>> 44b1f367f9452c2e64304de23633481425512e65
            <!-- MATERIALES -->
            <div style="margin-bottom: 30px;">
                <h3>🧱 MATERIALES</h3>
                <div id="materiales-container">
                    <div class="material-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="materiales[0][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                            <option value="">🔍 Seleccione un material...</option>
                            @foreach($materiales as $material)
                                <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">
                                    {{ $material->code }} - {{ $material->name }} (${{ number_format($material->price, 2) }}/{{ $material->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="materiales[0][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="0">
                        <input type="text" name="materiales[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
                        <input type="number" name="materiales[0][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly>
                        <input type="number" name="materiales[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly>
                        <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
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
            
            <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-top: 20px;">💾 Guardar APU</button>
            <a href="{{ route('apus.index') }}">Cancelar</a>
        </form>
    </div>
</div>

<script>
    function calcularTotalEquipo(row) {
        const cantidad = parseFloat(row.querySelector(".equipo-cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".equipo-precio").value) || 0;
        const rendimiento = parseFloat(row.querySelector(".equipo-rendimiento").value) || 1;
        const total = cantidad * precio * rendimiento;
        row.querySelector(".equipo-total").value = total.toFixed(2);
        return total;
    }
    
    function calcularTotalLabor(row) {
        const cantidad = parseFloat(row.querySelector(".labor-cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".labor-precio").value) || 0;
        const rendimiento = parseFloat(row.querySelector(".labor-rendimiento").value) || 1;
        const total = cantidad * precio * rendimiento;
        row.querySelector(".labor-total").value = total.toFixed(2);
        return total;
    }
    
    function calcularTotalMaterial(row) {
        const cantidad = parseFloat(row.querySelector(".material-cantidad").value) || 0;
        const precio = parseFloat(row.querySelector(".material-precio").value) || 0;
        const total = cantidad * precio;
        row.querySelector(".material-total").value = total.toFixed(2);
        return total;
    }
    
    function recalcularTotalesGenerales() {
        let totalEquipos = 0;
        let totalLabors = 0;
        let totalMateriales = 0;
        
        document.querySelectorAll(".equipo-row").forEach(row => {
            totalEquipos += parseFloat(row.querySelector(".equipo-total").value) || 0;
        });
        
        document.querySelectorAll(".labor-row").forEach(row => {
            totalLabors += parseFloat(row.querySelector(".labor-total").value) || 0;
        });
        
        document.querySelectorAll(".material-row").forEach(row => {
            totalMateriales += parseFloat(row.querySelector(".material-total").value) || 0;
        });
        
        document.getElementById("subtotal-equipos").innerHTML = totalEquipos.toFixed(2);
        document.getElementById("subtotal-labors").innerHTML = totalLabors.toFixed(2);
        document.getElementById("subtotal-materiales").innerHTML = totalMateriales.toFixed(2);
        
        const totalDirecto = totalEquipos + totalLabors + totalMateriales;
        const indirectos = totalDirecto * 0.20;
        const totalGeneral = totalDirecto + indirectos;
        
        document.getElementById("total-directo").innerHTML = totalDirecto.toFixed(2);
        document.getElementById("indirectos").innerHTML = indirectos.toFixed(2);
        document.getElementById("total-general").innerHTML = totalGeneral.toFixed(2);
        
        document.getElementById("total_direct_cost").value = totalDirecto;
        document.getElementById("indirect_cost").value = indirectos;
        document.getElementById("total_cost").value = totalGeneral;
    }
    
    function configurarEventosEquipo(row) {
        const select = row.querySelector(".equipo-select");
        const cantidad = row.querySelector(".equipo-cantidad");
        const precio = row.querySelector(".equipo-precio");
        const rendimiento = row.querySelector(".equipo-rendimiento");
        const unidad = row.querySelector(".equipo-unidad");
        
        select.addEventListener("change", function() {
            const option = select.options[select.selectedIndex];
            unidad.value = option.getAttribute("data-unit") || "";
            precio.value = option.getAttribute("data-price") || 0;
            calcularTotalEquipo(row);
            recalcularTotalesGenerales();
        });
        
        cantidad.addEventListener("input", function() {
            calcularTotalEquipo(row);
            recalcularTotalesGenerales();
        });
        
        rendimiento.addEventListener("input", function() {
            calcularTotalEquipo(row);
            recalcularTotalesGenerales();
        });
        
        // Botón eliminar
        const removeBtn = row.querySelector(".remove-equipo");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
    }
    
    function configurarEventosLabor(row) {
        const select = row.querySelector(".labor-select");
        const cantidad = row.querySelector(".labor-cantidad");
        const precio = row.querySelector(".labor-precio");
        const rendimiento = row.querySelector(".labor-rendimiento");
        const unidad = row.querySelector(".labor-unidad");
        
        select.addEventListener("change", function() {
            const option = select.options[select.selectedIndex];
            unidad.value = option.getAttribute("data-unit") || "";
            precio.value = option.getAttribute("data-price") || 0;
            calcularTotalLabor(row);
            recalcularTotalesGenerales();
        });
        
        cantidad.addEventListener("input", function() {
            calcularTotalLabor(row);
            recalcularTotalesGenerales();
        });
        
        rendimiento.addEventListener("input", function() {
            calcularTotalLabor(row);
            recalcularTotalesGenerales();
        });
        
        // Botón eliminar
        const removeBtn = row.querySelector(".remove-labor");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
    }
    
    function configurarEventosMaterial(row) {
        const select = row.querySelector(".material-select");
        const cantidad = row.querySelector(".material-cantidad");
        const precio = row.querySelector(".material-precio");
        const unidad = row.querySelector(".material-unidad");
        
        select.addEventListener("change", function() {
            const option = select.options[select.selectedIndex];
            unidad.value = option.getAttribute("data-unit") || "";
            precio.value = option.getAttribute("data-price") || 0;
            calcularTotalMaterial(row);
            recalcularTotalesGenerales();
        });
        
        cantidad.addEventListener("input", function() {
            calcularTotalMaterial(row);
            recalcularTotalesGenerales();
        });
        
        // Botón eliminar
        const removeBtn = row.querySelector(".remove-material");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
    }
    
    // Configurar filas iniciales
    document.querySelectorAll(".equipo-row").forEach(row => configurarEventosEquipo(row));
    document.querySelectorAll(".labor-row").forEach(row => configurarEventosLabor(row));
    document.querySelectorAll(".material-row").forEach(row => configurarEventosMaterial(row));
    
    let equipoIndex = 1;
    let laborIndex = 1;
    let materialIndex = 1;
    
    // Agregar equipo
    document.getElementById("add-equipo").addEventListener("click", function() {
        const container = document.getElementById("equipos-container");
        const newRow = document.createElement("div");
        newRow.className = "equipo-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;";
        newRow.innerHTML = `
            <select name="equipos[${equipoIndex}][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                <option value="">🔍 Seleccione un equipo...</option>
                @foreach($equipos as $equipo)
                    <option value="{{ $equipo->id }}" data-price="{{ $equipo->price }}" data-unit="{{ $equipo->unit }}">
                         {{ $equipo->name }} (${{ number_format($equipo->price, 2) }}/{{ $equipo->unit }})
                      
                    </option>
                @endforeach
            </select>
            <input type="number" name="equipos[${equipoIndex}][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="0">
            <input type="text" name="equipos[${equipoIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
            <input type="number" name="equipos[${equipoIndex}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly>
            <input type="number" name="equipos[${equipoIndex}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="1">
            <input type="number" name="equipos[${equipoIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly>
            <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️ Eliminar</button>
        `;
        container.appendChild(newRow);
        configurarEventosEquipo(newRow);
        equipoIndex++;
    });
    
    // Agregar mano de obra
    document.getElementById("add-labor").addEventListener("click", function() {
        const container = document.getElementById("labors-container");
        const newRow = document.createElement("div");
        newRow.className = "labor-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;";
        newRow.innerHTML = `
            <select name="labors[${laborIndex}][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                <option value="">🔍 Seleccione un trabajador...</option>
                @foreach($labors as $labor)
                    <option value="{{ $labor->id }}" data-price="{{ $labor->hourly_rate }}" data-unit="{{ $labor->unit }}">
                        {{ $labor->code }} - {{ $labor->name }} (${{ number_format($labor->hourly_rate, 2) }}/{{ $labor->unit }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="labors[${laborIndex}][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="0">
            <input type="text" name="labors[${laborIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
            <input type="number" name="labors[${laborIndex}][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly>
            <input type="number" name="labors[${laborIndex}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="1">
            <input type="number" name="labors[${laborIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly>
            <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️ Eliminar</button>
        `;
        container.appendChild(newRow);
        configurarEventosLabor(newRow);
        laborIndex++;
    });
    
    // Agregar material
    document.getElementById("add-material").addEventListener("click", function() {
        const container = document.getElementById("materiales-container");
        const newRow = document.createElement("div");
        newRow.className = "material-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;";
        newRow.innerHTML = `
            <select name="materiales[${materialIndex}][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                <option value="">🔍 Seleccione un material...</option>
                @foreach($materiales as $material)
                    <option value="{{ $material->id }}" data-price="{{ $material->price }}" data-unit="{{ $material->unit }}">
                        {{ $material->code }} - {{ $material->name }} (${{ number_format($material->price, 2) }}/{{ $material->unit }})
                    </option>
                @endforeach
            </select>
            <input type="number" name="materiales[${materialIndex}][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="0">
            <input type="text" name="materiales[${materialIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
            <input type="number" name="materiales[${materialIndex}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly>
            <input type="number" name="materiales[${materialIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly>
            <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️ Eliminar</button>
        `;
        container.appendChild(newRow);
        configurarEventosMaterial(newRow);
        materialIndex++;
    });
    
<<<<<<< HEAD
    recalcularTotalesGenerales();
=======
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

    // Contador para mano de obra
let laborIndex = 1;

// Agregar mano de obra
document.getElementById("add-labor").addEventListener("click", function() {
    const container = document.getElementById("labors-container");
    const newRow = document.createElement("div");
    newRow.className = "labor-row";
    newRow.style = "margin-bottom: 10px; display: flex; gap: 10px;";
    newRow.innerHTML = `
        <select name="labors[${laborIndex}][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
            <option value="">Seleccione un trabajador...</option>
            @foreach($labors as $labor)
                <option value="{{ $labor->id }}" data-price="{{ $labor->hourly_rate }}" data-unit="{{ $labor->unit }}">
                    {{ $labor->code }} - {{ $labor->name }} (${{ number_format($labor->hourly_rate, 2) }}/{{ $labor->unit }})
                </option>
            @endforeach
        </select>
        <input type="number" name="labors[${laborIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad">
        <input type="text" name="labors[${laborIndex}][unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
        <input type="number" name="labors[${laborIndex}][performance]" placeholder="Rendimiento" step="0.01" style="flex: 1; padding: 8px;">
        <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
    `;
    container.appendChild(newRow);
    
    // Agregar evento al select para cargar unidad
    const select = newRow.querySelector(".labor-select");
    const unitInput = newRow.querySelector(".labor-unidad");
    select.addEventListener("change", function() {
        const selectedOption = select.options[select.selectedIndex];
        const unit = selectedOption.getAttribute("data-unit");
        unitInput.value = unit || "";
    });
    
    // Agregar evento al botón eliminar
    newRow.querySelector(".remove-labor").addEventListener("click", function() {
        newRow.remove();
    });
    
    laborIndex++;
});

// Eventos para filas iniciales de mano de obra
document.querySelectorAll(".labor-select").forEach(select => {
    const unitInput = select.closest(".labor-row").querySelector(".labor-unidad");
    select.addEventListener("change", function() {
        const selectedOption = select.options[select.selectedIndex];
        const unit = selectedOption.getAttribute("data-unit");
        unitInput.value = unit || "";
    });
});

document.querySelectorAll(".remove-labor").forEach(btn => {
    btn.addEventListener("click", function() {
        btn.closest(".labor-row").remove();
    });
});

>>>>>>> 44b1f367f9452c2e64304de23633481425512e65
</script>
@endsection