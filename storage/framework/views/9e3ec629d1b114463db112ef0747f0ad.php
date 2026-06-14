

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Presupuesto con Hitos</h1>
        
        <form method="POST" action="<?php echo e(route('budgets.store')); ?>" id="budgetForm">
            <?php echo csrf_field(); ?>
            
            <!-- Datos de cabecera (igual que antes) -->
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
            
            <!-- HITOS Y CATEGORÍAS -->
            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3>📊 Estructura del Presupuesto</h3>
                    <button type="button" id="add-milestone" style="background: #8b5cf6; color: white; border: none; padding: 8px 16px; cursor: pointer;">➕ Agregar Hito</button>
                </div>
                
                <div id="milestones-container">
                    <!-- Hito inicial -->
                    <div class="milestone-card" style="border: 2px solid #3b82f6; border-radius: 10px; margin-bottom: 25px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; background: #eff6ff; padding: 10px; border-radius: 8px;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <input type="text" name="milestones[0][code]" placeholder="Código (ej: 1.0)" value="1.0" style="width: 100px; padding: 8px; font-weight: bold;">
                                <input type="text" name="milestones[0][name]" placeholder="Nombre del Hito" value="Hito 1" style="flex: 1; padding: 8px; font-weight: bold;">
                            </div>
                            <button type="button" class="remove-milestone" style="background: #ef4444; color: white; border: none; padding: 5px 10px; cursor: pointer;">🗑️ Eliminar Hito</button>
                        </div>
                        
                        <div class="categories-container" data-milestone="0">
                            <!-- Categoría inicial -->
                            <div class="category-card" style="border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; margin-left: 20px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <input type="text" name="milestones[0][categories][0][code]" placeholder="Código (ej: 1.1)" value="1.1" style="width: 100px; padding: 5px;">
                                        <input type="text" name="milestones[0][categories][0][name]" placeholder="Nombre de la Categoría" value="Categoría 1" style="flex: 1; padding: 5px;">
                                    </div>
                                    <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
                                </div>
                                
                                <div class="apus-container" data-category="0">
                                    <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-left: 20px;">
                                        <select name="milestones[0][categories][0][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                                            <option value="">🔍 Seleccione un APU...</option>
                                            <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                                                    <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <input type="text" name="milestones[0][categories][0][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                                        <input type="text" name="milestones[0][categories][0][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                                        <input type="text" name="milestones[0][categories][0][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                                        <input type="number" name="milestones[0][categories][0][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                                        <input type="number" name="milestones[0][categories][0][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                                        <input type="number" name="milestones[0][categories][0][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                                        <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                                    </div>
                                </div>
                                <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar APU</button>
                                <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px; margin-left: 20px;">
                                    <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="add-category" style="background: #22c55e; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar Categoría</button>
                        <div class="milestone-subtotal" style="text-align: right; margin-top: 15px; padding: 10px; background: #dbeafe; border-radius: 8px;">
                            <strong>Subtotal Hito:</strong> $ <span class="milestone-subtotal-valor">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Totales Generales -->
            <div style="background: #d4edda; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <div id="resumen-hitos"></div>
                <hr>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span><strong>SUBTOTAL APUs:</strong></span>
                    <span><strong>$ <span id="subtotal-apus">0.00</span></strong></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #dc2626;">
                    <span><strong>MONTO ANTICIPO:</strong></span>
                    <span><strong>-$ <span id="monto-anticipo">0.00</span></strong></span>
                </div>
                <hr>
                <div style="display: flex; justify-content: space-between; font-size: 20px;">
                    <span><strong>TOTAL PRESUPUESTO:</strong></span>
                    <span><strong>$ <span id="total-presupuesto">0.00</span></strong></span>
                </div>
            </div>
            
            <input type="hidden" name="monto" id="monto" value="0">
            
            <div style="margin-top: 20px;">
                <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none; cursor: pointer;">💾 Guardar Presupuesto</button>
                <a href="<?php echo e(route('budgets.index')); ?>">Cancelar</a>
            </div>

            <!-- Al final del formulario, antes de cerrar </form> -->
            <div id="apus-data" style="display: none;">
                <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                        <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let milestoneIndex = 1;
    let categoryIndexes = {0: 1};
    
    function initSelect2(container) {
        $(container).find('.select2').each(function() {
            if (!$(this).data('select2')) {
                $(this).select2({ width: '100%', placeholder: '🔍 Buscar APU...', allowClear: true });
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
    
    function calcularSubtotalCategoria(categoryCard) {
        let subtotal = 0;
        categoryCard.querySelectorAll(".apu-row").forEach(row => {
            subtotal += parseFloat(row.querySelector(".apu-total").value) || 0;
        });
        categoryCard.querySelector(".subtotal-valor").innerHTML = subtotal.toFixed(2);
        return subtotal;
    }
    
    function calcularSubtotalMilestone(milestoneCard) {
        let subtotal = 0;
        milestoneCard.querySelectorAll(".category-card").forEach(categoryCard => {
            subtotal += calcularSubtotalCategoria(categoryCard);
        });
        milestoneCard.querySelector(".milestone-subtotal-valor").innerHTML = subtotal.toFixed(2);
        return subtotal;
    }
    
    function recalcularTotalesGenerales() {
        let totalGeneral = 0;
        let resumenHtml = '';
        
        document.querySelectorAll(".milestone-card").forEach((milestone, idx) => {
            const milestoneCode = milestone.querySelector("input[name*='[code]']").value || 'Hito';
            const milestoneName = milestone.querySelector("input[name*='[name]']").value || '';
            const subtotal = calcularSubtotalMilestone(milestone);
            totalGeneral += subtotal;
            resumenHtml += `<p><strong>${milestoneCode} ${milestoneName}:</strong> $${subtotal.toFixed(2)}</p>`;
        });
        
        const montoAnticipo = parseFloat(document.querySelector("input[name='monto_anticipo']").value) || 0;
        
        document.getElementById("resumen-hitos").innerHTML = resumenHtml;
        document.getElementById("subtotal-apus").innerHTML = totalGeneral.toFixed(2);
        document.getElementById("monto-anticipo").innerHTML = montoAnticipo.toFixed(2);
        document.getElementById("total-presupuesto").innerHTML = (totalGeneral - montoAnticipo).toFixed(2);
        document.getElementById("monto").value = totalGeneral - montoAnticipo;
    }
    
    function configurarEventosFila(row, milestoneIdx, categoryIdx) {
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
        
        row.querySelector(".remove-apu").onclick = function() {
            row.remove();
            recalcularTotalesGenerales();
        };
    }
    
    function agregarCategoria(milestoneCard, milestoneIdx) {
        const categoriesContainer = milestoneCard.querySelector(".categories-container");
        const categoryIdx = categoryIndexes[milestoneIdx] || 1;
        
        const newCategory = document.createElement("div");
        newCategory.className = "category-card";
        newCategory.style = "border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; margin-left: 20px; padding: 15px;";
        newCategory.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][code]" placeholder="Código (ej: ${milestoneIdx}.${categoryIdx})" value="${milestoneIdx}.${categoryIdx}" style="width: 100px; padding: 5px;">
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][name]" placeholder="Nombre de la Categoría" value="Nueva Categoría" style="flex: 1; padding: 5px;">
                </div>
                <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container" data-category="${categoryIdx}">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-left: 20px;">
                    <select name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                                <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar APU</button>
            <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px; margin-left: 20px;">
                <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        
        categoriesContainer.appendChild(newCategory);
        initSelect2(newCategory);
        configurarEventosCategoria(newCategory, milestoneIdx, categoryIdx);
        categoryIndexes[milestoneIdx] = categoryIdx + 1;
        recalcularTotalesGenerales();
    }
    
    function configurarEventosCategoria(categoryCard, milestoneIdx, categoryIdx) {
        categoryCard.querySelector(".remove-category").onclick = function() {
            categoryCard.remove();
            recalcularTotalesGenerales();
        };
        
        let apuIndex = 1;
        categoryCard.querySelector(".add-apu").onclick = function() {
            const apusContainer = categoryCard.querySelector(".apus-container");
            const newRow = document.createElement("div");
            newRow.className = "apu-row";
            newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-left: 20px;";
            newRow.innerHTML = `
                <select name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                    <option value="">🔍 Seleccione un APU...</option>
                    <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($apu->id); ?>" data-code="<?php echo e($apu->code); ?>" data-name="<?php echo e($apu->name); ?>" data-unit="<?php echo e($apu->unit); ?>" data-price="<?php echo e($apu->total_cost ?? 0); ?>">
                            <?php echo e($apu->code); ?> - <?php echo e($apu->name); ?> ($<?php echo e(number_format($apu->total_cost ?? 0, 2)); ?>/<?php echo e($apu->unit); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
            `;
            apusContainer.appendChild(newRow);
            initSelect2(newRow);
            configurarEventosFila(newRow, milestoneIdx, categoryIdx);
            apuIndex++;
            recalcularTotalesGenerales();
        };
        
        categoryCard.querySelectorAll(".apu-row").forEach(row => {
            configurarEventosFila(row, milestoneIdx, categoryIdx);
        });
        
        const codeInput = categoryCard.querySelector("input[name*='[code]']");
        const nameInput = categoryCard.querySelector("input[name*='[name]']");
        if (codeInput) codeInput.oninput = function() { recalcularTotalesGenerales(); };
        if (nameInput) nameInput.oninput = function() { recalcularTotalesGenerales(); };
    }
    
    function agregarMilestone()
    {
        const container = document.getElementById("milestones-container");
        const newMilestone = document.createElement("div");
        newMilestone.className = "milestone-card";
        newMilestone.style = "border: 2px solid #3b82f6; border-radius: 10px; margin-bottom: 25px; padding: 15px;";
        
        // Obtener las opciones de APUs desde un elemento oculto global
        const apusOptions = document.getElementById('apus-data').innerHTML;
        
        newMilestone.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; background: #eff6ff; padding: 10px; border-radius: 8px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <input type="text" name="milestones[${milestoneIndex}][code]" placeholder="Código (ej: ${milestoneIndex}.0)" value="${milestoneIndex}.0" style="width: 100px; padding: 8px; font-weight: bold;">
                    <input type="text" name="milestones[${milestoneIndex}][name]" placeholder="Nombre del Hito" value="Hito ${milestoneIndex}" style="flex: 1; padding: 8px; font-weight: bold;">
                </div>
                <button type="button" class="remove-milestone" style="background: #ef4444; color: white; border: none; padding: 5px 10px; cursor: pointer;">🗑️ Eliminar Hito</button>
            </div>
            <div class="categories-container" data-milestone="${milestoneIndex}"></div>
            <button type="button" class="add-category" style="background: #22c55e; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar Categoría</button>
            <div class="milestone-subtotal" style="text-align: right; margin-top: 15px; padding: 10px; background: #dbeafe; border-radius: 8px;">
                <strong>Subtotal Hito:</strong> $ <span class="milestone-subtotal-valor">0.00</span>
            </div>
        `;
        
        container.appendChild(newMilestone);
        categoryIndexes[milestoneIndex] = 1;
        
        // Agregar primera categoría al nuevo hito usando una función que genere opciones correctamente
        agregarCategoriaAlHito(newMilestone, milestoneIndex);
        
        // Configurar eventos
        newMilestone.querySelector(".remove-milestone").onclick = function() {
            newMilestone.remove();
            recalcularTotalesGenerales();
        };
        
        newMilestone.querySelector(".add-category").onclick = function() {
            agregarCategoria(newMilestone, milestoneIndex);
        };
        
        milestoneIndex++;
        recalcularTotalesGenerales();
    }
    
    function agregarCategoria(milestoneCard, milestoneIdx) 
    {
            const categoriesContainer = milestoneCard.querySelector(".categories-container");
            const categoryIdx = categoryIndexes[milestoneIdx] || 1;
            
            // Obtener opciones de APUs desde un elemento oculto
            const apusOptions = document.getElementById('apus-data').innerHTML;
            
            const newCategory = document.createElement("div");
            newCategory.className = "category-card";
            newCategory.style = "border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; margin-left: 20px; padding: 15px;";
            newCategory.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][code]" placeholder="Código (ej: ${milestoneIdx}.${categoryIdx})" value="${milestoneIdx}.${categoryIdx}" style="width: 100px; padding: 5px;">
                        <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][name]" placeholder="Nombre de la Categoría" value="Nueva Categoría" style="flex: 1; padding: 5px;">
                    </div>
                    <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
                </div>
                <div class="apus-container" data-category="${categoryIdx}">
                    <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-left: 20px;">
                        <select name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                            <option value="">🔍 Seleccione un APU...</option>
                            ${apusOptions}
                        </select>
                        <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                        <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                        <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                        <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                        <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                        <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                        <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                    </div>
                </div>
                <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar APU</button>
                <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px; margin-left: 20px;">
                    <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
                </div>
            `;
            
            categoriesContainer.appendChild(newCategory);
            initSelect2(newCategory);
            configurarEventosCategoria(newCategory, milestoneIdx, categoryIdx);
            categoryIndexes[milestoneIdx] = categoryIdx + 1;
            recalcularTotalesGenerales();
    }


    function agregarCategoriaAlHito(milestoneCard, milestoneIdx) 
    {
        const categoriesContainer = milestoneCard.querySelector(".categories-container");
        const categoryIdx = 0;
        
        // Obtener opciones de APUs desde un elemento oculto
        const apusOptions = document.getElementById('apus-data').innerHTML;
        
        const newCategory = document.createElement("div");
        newCategory.className = "category-card";
        newCategory.style = "border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px; margin-left: 20px; padding: 15px;";
        newCategory.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][code]" placeholder="Código (ej: ${milestoneIdx}.1)" value="${milestoneIdx}.1" style="width: 100px; padding: 5px;">
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][name]" placeholder="Nombre de la Categoría" value="Categoría 1" style="flex: 1; padding: 5px;">
                </div>
                <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container" data-category="${categoryIdx}">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-left: 20px;">
                    <select name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        ${apusOptions}
                    </select>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="milestones[${milestoneIdx}][categories][${categoryIdx}][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 20px; cursor: pointer;">➕ Agregar APU</button>
            <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px; margin-left: 20px;">
                <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        
        categoriesContainer.appendChild(newCategory);
        initSelect2(newCategory);
        configurarEventosCategoria(newCategory, milestoneIdx, categoryIdx);
    }



    // Configurar eventos iniciales
    document.querySelectorAll(".milestone-card").forEach((milestone, idx) => {
        milestone.querySelector(".remove-milestone").onclick = function() {
            milestone.remove();
            recalcularTotalesGenerales();
        };
        milestone.querySelector(".add-category").onclick = function() {
            agregarCategoria(milestone, idx);
        };
        milestone.querySelectorAll(".category-card").forEach((category, catIdx) => {
            configurarEventosCategoria(category, idx, catIdx);
        });
    });
    
    document.getElementById("add-milestone").onclick = agregarMilestone;
    
    document.querySelector("input[name='monto_anticipo']").oninput = function() {
        recalcularTotalesGenerales();
    };
    
    $(document).ready(function() {
        initSelect2(document);
        recalcularTotalesGenerales();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio_\resources\views/budgets/create_with_milestones.blade.php ENDPATH**/ ?>