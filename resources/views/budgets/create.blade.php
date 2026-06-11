@extends('layouts.app')

@section('content')
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Presupuesto</h1>
        
        <form method="POST" action="{{ route('budgets.store') }}" id="budgetForm">
            @csrf
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>📋 Datos Generales</h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                    <div><label>OBRA:</label><input type="text" name="obra" required style="width:100%; padding: 8px;"></div>
                    <div><label>CONTRATISTA:</label><input type="text" name="contratista" style="width:100%; padding: 8px;"></div>
                    <div><label>MONTO DE ANTICIPO:</label><input type="number" step="0.01" name="monto_anticipo" style="width:100%; padding: 8px;"></div>
                    <div><label>FISCALIZADOR:</label><input type="text" name="fiscalizador" style="width:100%; padding: 8px;"></div>
                    <div><label>ADMINISTRADOR:</label><input type="text" name="administrador" style="width:100%; padding: 8px;"></div>
                    <div><label>No. CONTRATO:</label><input type="text" name="no_contrato" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DEL CONTRATO:</label><input type="date" name="fecha_contrato" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DE ENTREGA DE ANTICIPO:</label><input type="date" name="fecha_entrega_anticipo" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA DE INICIO DE OBRA:</label><input type="date" name="fecha_inicio_obra" style="width:100%; padding: 8px;"></div>
                    <div><label>PLAZO (DIAS):</label><input type="number" name="plazo_dias" style="width:100%; padding: 8px;"></div>
                    <div><label>AMPLIACION DE PLAZO (DIAS):</label><input type="number" name="ampliacion_plazo" value="0" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA TERMINACION DE PLAZO:</label><input type="date" name="fecha_terminacion_plazo" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA ELABORACIÓN PROYECTO:</label><input type="date" name="fecha_elaboracion" style="width:100%; padding: 8px;"></div>
                </div>
            </div>
            
            <!-- Categorías y APUs -->
            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3>📋 APUs por Categoría</h3>
                    <button type="button" id="add-categoria" style="background: #8b5cf6; color: white; border: none; padding: 8px 16px; cursor: pointer;">➕ Agregar Categoría</button>
                </div>
                
                <div id="categorias-container">
                    <!-- Categoría por defecto -->
                    <div class="categoria-card" style="border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <input type="text" name="categorias[0][nombre]" placeholder="Nombre de la categoría" value="General" style="flex: 1; padding: 8px; font-size: 16px; font-weight: bold;">
                            <button type="button" class="remove-categoria" style="background: #ef4444; color: white; border: none; padding: 5px 10px; margin-left: 10px; cursor: pointer;">🗑️</button>
                        </div>
                        <div class="apus-container" data-categoria-index="0">
                            <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                                <select name="categorias[0][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                                    <option value="">🔍 Seleccione un APU...</option>
                                    @foreach($apus as $apu)
                                        <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
                                            {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                                        </option>
                                    @endforeach
                                </select>
                                <input type="text" name="categorias[0][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                                <input type="text" name="categorias[0][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                                <input type="text" name="categorias[0][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                                <input type="number" name="categorias[0][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                                <input type="number" name="categorias[0][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                                <input type="number" name="categorias[0][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                                <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                            </div>
                        </div>
                        <button type="button" class="add-apu" data-categoria-index="0" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
                        <div class="categoria-subtotal" style="text-align: right; margin-top: 10px; padding: 8px; background: #e0e7ff; border-radius: 4px;">
                            <strong>Subtotal {{ 0 }}:</strong> $ <span class="subtotal-valor">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Totales Generales -->
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: right;">
                <div id="subtotales-categorias"></div>
                <hr>
                <p><strong>SUBTOTAL APUs:</strong> $ <span id="subtotal-apus">0.00</span></p>
                <p><strong>MONTO ANTICIPO:</strong> $ <span id="monto-anticipo">0.00</span></p>
                <hr>
                <p style="font-size: 20px;"><strong>TOTAL PRESUPUESTO:</strong> $ <span id="total-presupuesto">0.00</span></p>
            </div>
            
            <input type="hidden" name="monto" id="monto" value="0">
            
            <div style="margin-top: 20px;">
                <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer;">💾 Guardar Presupuesto</button>
                <a href="{{ route('budgets.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let categoriaIndex = 1;
    
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
    
    function calcularSubtotalCategoria(categoriaCard) {
        let subtotal = 0;
        categoriaCard.querySelectorAll(".apu-row").forEach(row => {
            subtotal += parseFloat(row.querySelector(".apu-total").value) || 0;
        });
        const subtotalSpan = categoriaCard.querySelector(".subtotal-valor");
        if (subtotalSpan) subtotalSpan.innerHTML = subtotal.toFixed(2);
        return subtotal;
    }
    
    function recalcularTotalesGenerales() {
        let totalGeneral = 0;
        let subtotalesHtml = '';
        
        document.querySelectorAll(".categoria-card").forEach((card, idx) => {
            const nombreCat = card.querySelector("input[name*='[nombre]']").value || 'Categoría';
            const subtotal = calcularSubtotalCategoria(card);
            totalGeneral += subtotal;
            subtotalesHtml += `<p><strong>${nombreCat}:</strong> $ ${subtotal.toFixed(2)}</p>`;
        });
        
        const montoAnticipo = parseFloat(document.querySelector("input[name='monto_anticipo']").value) || 0;
        
        document.getElementById("subtotales-categorias").innerHTML = subtotalesHtml;
        document.getElementById("subtotal-apus").innerHTML = totalGeneral.toFixed(2);
        document.getElementById("monto-anticipo").innerHTML = montoAnticipo.toFixed(2);
        document.getElementById("total-presupuesto").innerHTML = (totalGeneral - montoAnticipo).toFixed(2);
        document.getElementById("monto").value = totalGeneral - montoAnticipo;
    }
    
    function configurarEventosFila(row, categoriaIndex) {
        const select = row.querySelector(".apu-select");
        const code = row.querySelector(".apu-code");
        const name = row.querySelector(".apu-name");
        const unit = row.querySelector(".apu-unit");
        const price = row.querySelector(".apu-price");
        const quantity = row.querySelector(".apu-quantity");
        
        $(select).off('change').on('change', function() {
            const option = select.options[select.selectedIndex];
            code.value = option.getAttribute("data-code") || "";
            name.value = option.getAttribute("data-name") || "";
            unit.value = option.getAttribute("data-unit") || "";
            price.value = option.getAttribute("data-price") || 0;
            calcularTotalFila(row);
            recalcularTotalesGenerales();
        });
        
        quantity.oninput = function() {
            calcularTotalFila(row);
            recalcularTotalesGenerales();
        };
        
        const removeBtn = row.querySelector(".remove-apu");
        if (removeBtn) {
            removeBtn.onclick = function() { 
                row.remove(); 
                recalcularTotalesGenerales(); 
            };
        }
    }
    
    function agregarCategoria() {
        const container = document.getElementById("categorias-container");
        const newCard = document.createElement("div");
        newCard.className = "categoria-card";
        newCard.style = "border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; padding: 15px;";
        newCard.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <input type="text" name="categorias[${categoriaIndex}][nombre]" placeholder="Nombre de la categoría" value="Nueva Categoría" style="flex: 1; padding: 8px; font-size: 16px; font-weight: bold;">
                <button type="button" class="remove-categoria" style="background: #ef4444; color: white; border: none; padding: 5px 10px; margin-left: 10px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container" data-categoria-index="${categoriaIndex}">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <select name="categorias[${categoriaIndex}][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        @foreach($apus as $apu)
                            <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
                                {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="categorias[${categoriaIndex}][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="categorias[${categoriaIndex}][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="categorias[${categoriaIndex}][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="categorias[${categoriaIndex}][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="categorias[${categoriaIndex}][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="categorias[${categoriaIndex}][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" data-categoria-index="${categoriaIndex}" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
            <div class="categoria-subtotal" style="text-align: right; margin-top: 10px; padding: 8px; background: #e0e7ff; border-radius: 4px;">
                <strong>Subtotal:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        container.appendChild(newCard);
        
        initSelect2(newCard);
        configurarEventosCategoria(newCard, categoriaIndex);
        categoriaIndex++;
        recalcularTotalesGenerales();
    }
    
    function configurarEventosCategoria(card, idx) {
        const removeCatBtn = card.querySelector(".remove-categoria");
        if (removeCatBtn) {
            removeCatBtn.onclick = function() { 
                card.remove(); 
                recalcularTotalesGenerales(); 
            };
        }
        
        const addApuBtn = card.querySelector(".add-apu");
        const apusContainer = card.querySelector(".apus-container");
        let itemIndex = apusContainer.querySelectorAll(".apu-row").length;
        
        addApuBtn.onclick = function() {
            const newRow = document.createElement("div");
            newRow.className = "apu-row";
            newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;";
            newRow.innerHTML = `
                <select name="categorias[${idx}][items][${itemIndex}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                    <option value="">🔍 Seleccione un APU...</option>
                    @foreach($apus as $apu)
                        <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
                            {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                        </option>
                    @endforeach
                </select>
                <input type="text" name="categorias[${idx}][items][${itemIndex}][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                <input type="text" name="categorias[${idx}][items][${itemIndex}][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                <input type="text" name="categorias[${idx}][items][${itemIndex}][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                <input type="number" name="categorias[${idx}][items][${itemIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                <input type="number" name="categorias[${idx}][items][${itemIndex}][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                <input type="number" name="categorias[${idx}][items][${itemIndex}][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
            `;
            apusContainer.appendChild(newRow);
            initSelect2(newRow);
            configurarEventosFila(newRow, idx);
            itemIndex++;
            recalcularTotalesGenerales();
        };
        
        card.querySelectorAll(".apu-row").forEach(row => {
            configurarEventosFila(row, idx);
        });
        
        const nombreInput = card.querySelector("input[name*='[nombre]']");
        if (nombreInput) {
            nombreInput.oninput = function() { recalcularTotalesGenerales(); };
        }
    }
    
    // Configurar eventos para la categoría inicial
    document.querySelectorAll(".categoria-card").forEach((card, idx) => {
        configurarEventosCategoria(card, idx);
    });
    
    document.getElementById("add-categoria").onclick = function() {
        agregarCategoria();
    };
    
    document.querySelector("input[name='monto_anticipo']").oninput = function() {
        recalcularTotalesGenerales();
    };
    
    // Calcular fecha de terminación automáticamente
    document.querySelector("input[name='fecha_inicio_obra']").onchange = function() {
        const plazo = parseInt(document.querySelector("input[name='plazo_dias']").value) || 0;
        const inicio = new Date(this.value);
        if (plazo && inicio) {
            const terminacion = new Date(inicio);
            terminacion.setDate(inicio.getDate() + plazo);
            document.querySelector("input[name='fecha_terminacion_plazo']").value = terminacion.toISOString().split('T')[0];
        }
    };
    
    document.querySelector("input[name='plazo_dias']").onchange = function() {
        const fechaInicio = document.querySelector("input[name='fecha_inicio_obra']").value;
        if (fechaInicio) {
            const plazo = parseInt(this.value) || 0;
            const inicio = new Date(fechaInicio);
            const terminacion = new Date(inicio);
            terminacion.setDate(inicio.getDate() + plazo);
            document.querySelector("input[name='fecha_terminacion_plazo']").value = terminacion.toISOString().split('T')[0];
        }
    };
    
    $(document).ready(function() {
        initSelect2(document);
        recalcularTotalesGenerales();
    });
</script>
@endsection