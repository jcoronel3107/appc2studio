

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Presupuesto</h1>
        
        <form method="POST" action="<?php echo e(route('budgets.store')); ?>" id="budgetForm">
            <?php echo csrf_field(); ?>
            
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
            
            <!-- APUs -->
            <div style="margin-bottom: 30px;">
                <h3>📋 APUs del Presupuesto</h3>
                <div id="apus-container">
                    <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                        <select name="items[0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                            <option value="">🔍 Seleccione un APU...</option>
                            <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                                    <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <input type="text" name="items[0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                        <input type="text" name="items[0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                        <input type="text" name="items[0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                        <input type="number" name="items[0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                        <input type="number" name="items[0][unit_price]" placeholder="Precio Unit." step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                        <input type="number" name="items[0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                        <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" id="add-apu" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px;">➕ Agregar APU</button>
            </div>
            
            <!-- Totales -->
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; margin-top: 20px; text-align: right;">
                <p><strong>SUBTOTAL APUs:</strong> $ <span id="subtotal-apus">0.00</span></p>
                <p><strong>MONTO ANTICIPO:</strong> $ <span id="monto-anticipo">0.00</span></p>
                <hr>
                <p style="font-size: 20px;"><strong>TOTAL PRESUPUESTO:</strong> $ <span id="total-presupuesto">0.00</span></p>
            </div>
            
            <input type="hidden" name="monto" id="monto" value="0">
            
            <div style="margin-top: 20px;">
                <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer;">💾 Guardar Presupuesto</button>
                <a href="<?php echo e(route('budgets.index')); ?>">Cancelar</a>
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
    
    let apuIndex = 1;
    
    document.getElementById("add-apu").onclick = function() {
        const container = document.getElementById("apus-container");
        const newRow = document.createElement("div");
        newRow.className = "apu-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;";
        newRow.innerHTML = `
            <select name="items[${apuIndex}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                <option value="">🔍 Seleccione un APU...</option>
                <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                        <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        recalcularTotales();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/budgets/create.blade.php ENDPATH**/ ?>