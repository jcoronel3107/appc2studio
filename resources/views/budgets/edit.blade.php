@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>✏️ Editar Presupuesto</h1>
        
        <form method="POST" action="{{ route('budgets.update', $budget->id) }}" id="budgetForm">
            @csrf
            @method('PUT')
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>📋 Datos Generales</h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div><label>OBRA:</label><input type="text" name="obra" value="{{ $budget->obra }}" required style="width:100%; padding: 8px;"></div>
                    <div><label>CONTRATISTA:</label><input type="text" name="contratista" value="{{ $budget->contratista }}" style="width:100%; padding: 8px;"></div>
                    <div><label>MONTO DE ANTICIPO:</label><input type="number" step="0.01" name="monto_anticipo" value="{{ $budget->monto_anticipo }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FISCALIZADOR:</label><input type="text" name="fiscalizador" value="{{ $budget->fiscalizador }}" style="width:100%; padding: 8px;"></div>
                    <div><label>ADMINISTRADOR:</label><input type="text" name="administrador" value="{{ $budget->administrador }}" style="width:100%; padding: 8px;"></div>
                    <div><label>No. CONTRATO:</label><input type="text" name="no_contrato" value="{{ $budget->no_contrato }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DEL CONTRATO:</label><input type="date" name="fecha_contrato" value="{{ $budget->fecha_contrato }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DE ENTREGA DE ANTICIPO:</label><input type="date" name="fecha_entrega_anticipo" value="{{ $budget->fecha_entrega_anticipo }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DE INICIO DE OBRA:</label><input type="date" name="fecha_inicio_obra" value="{{ $budget->fecha_inicio_obra }}" style="width:100%; padding: 8px;"></div>
                    <div><label>PLAZO (DIAS):</label><input type="number" name="plazo_dias" value="{{ $budget->plazo_dias }}" style="width:100%; padding: 8px;"></div>
                    <div><label>AMPLIACION DE PLAZO (DIAS):</label><input type="number" name="ampliacion_plazo" value="{{ $budget->ampliacion_plazo ?? 0 }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA TERMINACION DE PLAZO:</label><input type="date" name="fecha_terminacion_plazo" value="{{ $budget->fecha_terminacion_plazo }}" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA ELABORACIÓN PROYECTO:</label><input type="date" name="fecha_elaboracion" value="{{ $budget->fecha_elaboracion }}" style="width:100%; padding: 8px;"></div>
                </div>
            </div>
            
            <!-- APUs -->
            <div style="margin-bottom: 30px;">
                <h3>📋 APUs del Presupuesto</h3>
                <div id="apus-container">
                    @foreach($budget->items as $index => $item)
                    <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <select name="items[{{ $index }}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                            <option value="">🔍 Seleccione un APU...</option>
                            @foreach($apus as $apu)
                                <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}" {{ $item->apu_id == $apu->id ? 'selected' : '' }}>
                                    {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="items[{{ $index }}][apu_code]" value="{{ $item->apu_code }}" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                        <input type="text" name="items[{{ $index }}][apu_name]" value="{{ $item->apu_name }}" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                        <input type="text" name="items[{{ $index }}][apu_unit]" value="{{ $item->apu_unit }}" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                        <input type="number" name="items[{{ $index }}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="{{ $item->quantity }}">
                        <input type="number" name="items[{{ $index }}][unit_price]" placeholder="Precio Unit." step="0.01" style="flex: 1; padding: 8px;" class="apu-price" value="{{ $item->unit_price }}" readonly>
                        <input type="number" name="items[{{ $index }}][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" value="{{ $item->total }}" readonly>
                        <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" id="add-apu" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar APU</button>
            </div>
            
            <!-- Totales -->
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: right;">
                <p><strong>SUBTOTAL APUs:</strong> $ <span id="subtotal-apus">0.00</span></p>
                <p><strong>MONTO ANTICIPO:</strong> $ <span id="monto-anticipo">{{ number_format($budget->monto_anticipo ?? 0, 2) }}</span></p>
                <hr>
                <p style="font-size: 20px;"><strong>TOTAL PRESUPUESTO:</strong> $ <span id="total-presupuesto">{{ number_format($budget->monto ?? 0, 2) }}</span></p>
            </div>
            
            <input type="hidden" name="monto" id="monto" value="{{ $budget->monto ?? 0 }}">
            
            <div style="margin-top: 20px;">
                <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer;">💾 Guardar Cambios</button>
                <a href="{{ route('budgets.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function initSelect2(container) {
        $(container).find('.select2').each(function() {
            if (!$(this).data('select2')) {
                $(this).select2({
                    width: '100%',
                    placeholder: '🔍 Buscar APU...',
                    allowClear: true
                });
            }
        });
    }
    
    function calcularTotalFila(row) {
        const cantidad = parseFloat(row.querySelector(".apu-quantity").value) || 0;
        const precio = parseFloat(row.querySelector(".apu-price").value) || 0;
        const total = cantidad * precio;
        row.querySelector(".apu-total").value = total.toFixed(2);
        return total;
    }
    
    function recalcularTotales() {
        let subtotal = 0;
        document.querySelectorAll(".apu-row").forEach(row => {
            subtotal += parseFloat(row.querySelector(".apu-total").value) || 0;
        });
        
        const montoAnticipo = parseFloat(document.querySelector("input[name='monto_anticipo']").value) || 0;
        
        document.getElementById("subtotal-apus").innerHTML = subtotal.toFixed(2);
        document.getElementById("monto-anticipo").innerHTML = montoAnticipo.toFixed(2);
        document.getElementById("total-presupuesto").innerHTML = (subtotal - montoAnticipo).toFixed(2);
        document.getElementById("monto").value = subtotal - montoAnticipo;
    }
    
    function configurarEventosFila(row) {
        const select = row.querySelector(".apu-select");
        const code = row.querySelector(".apu-code");
        const name = row.querySelector(".apu-name");
        const unit = row.querySelector(".apu-unit");
        const price = row.querySelector(".apu-price");
        const quantity = row.querySelector(".apu-quantity");
        const total = row.querySelector(".apu-total");
        
        $(select).on('change', function() {
            const option = select.options[select.selectedIndex];
            code.value = option.getAttribute("data-code") || "";
            name.value = option.getAttribute("data-name") || "";
            unit.value = option.getAttribute("data-unit") || "";
            price.value = option.getAttribute("data-price") || 0;
            calcularTotalFila(row);
            recalcularTotales();
        });
        
        quantity.oninput = function() {
            calcularTotalFila(row);
            recalcularTotales();
        };
        
        const removeBtn = row.querySelector(".remove-apu");
        if (removeBtn) {
            removeBtn.onclick = function() { row.remove(); recalcularTotales(); };
        }
    }
    
    document.querySelectorAll(".apu-row").forEach(row => configurarEventosFila(row));
    
    let apuIndex = {{ $budget->items->count() }};
    if (apuIndex === 0) apuIndex = 1;
    
    document.getElementById("add-apu").onclick = function() {
        const container = document.getElementById("apus-container");
        const newRow = document.createElement("div");
        newRow.className = "apu-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;";
        newRow.innerHTML = `
            <select name="items[${apuIndex}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                <option value="">🔍 Seleccione un APU...</option>
                @foreach($apus as $apu)
                    <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
                        {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                    </option>
                @endforeach
            </select>
            <input type="text" name="items[${apuIndex}][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
            <input type="text" name="items[${apuIndex}][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
            <input type="text" name="items[${apuIndex}][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
            <input type="number" name="items[${apuIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
            <input type="number" name="items[${apuIndex}][unit_price]" placeholder="Precio Unit." step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
            <input type="number" name="items[${apuIndex}][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
            <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
        `;
        container.appendChild(newRow);
        initSelect2(newRow);
        configurarEventosFila(newRow);
        apuIndex++;
    };
    
    // Recalcular cuando cambie el monto de anticipo
    document.querySelector("input[name='monto_anticipo']").oninput = function() {
        recalcularTotales();
    };
    
    // Calcular fecha de terminación automáticamente
    document.querySelector("input[name='fecha_inicio_obra']").onchange = function() {
        const plazo = parseInt(document.querySelector("input[name='plazo_dias']").value) || 0;
        const inicio = new Date(this.value);
        if (plazo && inicio) {
            const terminacion = new Date(inicio);
            terminacion.setDate(inicio.getDate() + plazo);
            const terminacionStr = terminacion.toISOString().split('T')[0];
            document.querySelector("input[name='fecha_terminacion_plazo']").value = terminacionStr;
        }
    };
    
    document.querySelector("input[name='plazo_dias']").onchange = function() {
        const fechaInicio = document.querySelector("input[name='fecha_inicio_obra']").value;
        if (fechaInicio) {
            const plazo = parseInt(this.value) || 0;
            const inicio = new Date(fechaInicio);
            const terminacion = new Date(inicio);
            terminacion.setDate(inicio.getDate() + plazo);
            const terminacionStr = terminacion.toISOString().split('T')[0];
            document.querySelector("input[name='fecha_terminacion_plazo']").value = terminacionStr;
        }
    };
    
    $(document).ready(function() {
        initSelect2(document);
        recalcularTotales();
    });
</script>
@endsection