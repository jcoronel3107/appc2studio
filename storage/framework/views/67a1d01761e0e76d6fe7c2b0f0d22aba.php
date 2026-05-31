

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <div style="margin-bottom: 20px;">
            <a href="<?php echo e(route('apus.index')); ?>" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">← Volver al listado</a>
        </div>
        
        <h1>📋 Clonar APU: <?php echo e($apuOriginal->code); ?> - <?php echo e($apuOriginal->name); ?></h1>
        
        <div style="background: #fef9c3; padding: 15px; margin-bottom: 20px; border-radius: 5px; border-left: 5px solid #eab308;">
            <p><strong>⚠️ Información:</strong> Estás clonando el APU "<?php echo e($apuOriginal->code); ?> - <?php echo e($apuOriginal->name); ?>"</p>
            <p>Puedes modificar los valores y luego decidir si guardar como <strong>NUEVO APU</strong> o <strong>SOBRESCRIBIR</strong> el existente.</p>
        </div>
        
        <form method="POST" action="<?php echo e(route('apus.clone.store', $apuOriginal->id)); ?>" id="apuForm">
            <?php echo csrf_field(); ?>
            
            <!-- Datos de cabecera -->
            <div style="background: #f0f0f0; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <h3>📋 Datos Generales</h3>
                <div style="margin-bottom: 10px;">
                    <label>Código:</label>
                    <input type="text" name="code" id="code" value="<?php echo e($apuOriginal->code); ?>" required placeholder="📝 Ej: APU001" style="width:100%; padding: 8px;">
                    <small style="color: #666;">Si guardas como nuevo, cambia el código</small>
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Rubro:</label>
                    <input type="text" name="name" id="name" value="<?php echo e($apuOriginal->name); ?>" required placeholder="🏷️ Ej: Construcción de muro" style="width:100%; padding: 8px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <label>Unidad:</label>
                    <input type="text" name="unit" id="unit" value="<?php echo e($apuOriginal->unit); ?>" required placeholder="📏 Ej: m2, m3, unidad" style="width:100%; padding: 8px;">
                </div>
            </div>
            
            <!-- EQUIPOS -->
            <div style="margin-bottom: 30px;">
                <h3>🖥️ EQUIPOS</h3>
                <div id="equipos-container">
                    <?php $equiposItems = $apuOriginal->items->where('section', 'equipment'); ?>
                    <?php if($equiposItems->count() > 0): ?>
                        <?php $__currentLoopData = $equiposItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="equipo-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="equipos[<?php echo e($index); ?>][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                                <option value="">🔍 Seleccione un equipo...</option>
                                <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($equipo->id); ?>" data-price="<?php echo e($equipo->price); ?>" data-unit="<?php echo e($equipo->unit); ?>" <?php echo e($item->description == $equipo->name ? 'selected' : ''); ?>>
                                        <?php echo e($equipo->code); ?> - <?php echo e($equipo->name); ?> ($<?php echo e(number_format($equipo->price, 2)); ?>/<?php echo e($equipo->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="equipos[<?php echo e($index); ?>][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="<?php echo e($item->quantity); ?>">
                            <input type="text" name="equipos[<?php echo e($index); ?>][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly value="<?php echo e($item->unit_price ? 'hora' : ''); ?>">
                            <input type="number" name="equipos[<?php echo e($index); ?>][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly value="<?php echo e($item->unit_price); ?>">
                            <input type="number" name="equipos[<?php echo e($index); ?>][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="<?php echo e($item->performance ?? 1); ?>">
                            <input type="number" name="equipos[<?php echo e($index); ?>][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly value="<?php echo e($item->total); ?>">
                            <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="equipo-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="equipos[0][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                                <option value="">🔍 Seleccione un equipo...</option>
                                <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($equipo->id); ?>" data-price="<?php echo e($equipo->price); ?>" data-unit="<?php echo e($equipo->unit); ?>">
                                        <?php echo e($equipo->code); ?> - <?php echo e($equipo->name); ?> ($<?php echo e(number_format($equipo->price, 2)); ?>/<?php echo e($equipo->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="equipos[0][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="0">
                            <input type="text" name="equipos[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
                            <input type="number" name="equipos[0][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly>
                            <input type="number" name="equipos[0][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="1">
                            <input type="number" name="equipos[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly>
                            <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-equipo" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px; cursor: pointer;">➕ Agregar Equipo</button>
            </div>
            
            <!-- MANO DE OBRA -->
            <div style="margin-bottom: 30px;">
                <h3>👷 MANO DE OBRA</h3>
                <div id="labors-container">
                    <?php $laborsItems = $apuOriginal->items->where('section', 'labor'); ?>
                    <?php if($laborsItems->count() > 0): ?>
                        <?php $__currentLoopData = $laborsItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="labor-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="labors[<?php echo e($index); ?>][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                                <option value="">🔍 Seleccione un trabajador...</option>
                                <?php $__currentLoopData = $labors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($labor->id); ?>" data-price="<?php echo e($labor->hourly_rate); ?>" data-unit="<?php echo e($labor->unit); ?>" <?php echo e($item->description == $labor->name ? 'selected' : ''); ?>>
                                        <?php echo e($labor->code); ?> - <?php echo e($labor->name); ?> ($<?php echo e(number_format($labor->hourly_rate, 2)); ?>/<?php echo e($labor->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="labors[<?php echo e($index); ?>][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="<?php echo e($item->quantity); ?>">
                            <input type="text" name="labors[<?php echo e($index); ?>][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
                            <input type="number" name="labors[<?php echo e($index); ?>][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly value="<?php echo e($item->unit_price); ?>">
                            <input type="number" name="labors[<?php echo e($index); ?>][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="<?php echo e($item->performance ?? 1); ?>">
                            <input type="number" name="labors[<?php echo e($index); ?>][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly value="<?php echo e($item->total); ?>">
                            <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="labor-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="labors[0][labor_id]" style="flex: 2; padding: 8px;" class="labor-select">
                                <option value="">🔍 Seleccione un trabajador...</option>
                                <?php $__currentLoopData = $labors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($labor->id); ?>" data-price="<?php echo e($labor->hourly_rate); ?>" data-unit="<?php echo e($labor->unit); ?>">
                                        <?php echo e($labor->code); ?> - <?php echo e($labor->name); ?> ($<?php echo e(number_format($labor->hourly_rate, 2)); ?>/<?php echo e($labor->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="labors[0][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="0">
                            <input type="text" name="labors[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
                            <input type="number" name="labors[0][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly>
                            <input type="number" name="labors[0][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="1">
                            <input type="number" name="labors[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly>
                            <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-labor" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px; cursor: pointer;">➕ Agregar Trabajador</button>
            </div>
            
            <!-- MATERIALES -->
            <div style="margin-bottom: 30px;">
                <h3>🧱 MATERIALES</h3>
                <div id="materiales-container">
                    <?php $materialesItems = $apuOriginal->items->where('section', 'material'); ?>
                    <?php if($materialesItems->count() > 0): ?>
                        <?php $__currentLoopData = $materialesItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="material-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="materiales[<?php echo e($index); ?>][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                                <option value="">🔍 Seleccione un material...</option>
                                <?php $__currentLoopData = $materiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($material->id); ?>" data-price="<?php echo e($material->price); ?>" data-unit="<?php echo e($material->unit); ?>" <?php echo e($item->description == $material->name ? 'selected' : ''); ?>>
                                        <?php echo e($material->code); ?> - <?php echo e($material->name); ?> ($<?php echo e(number_format($material->price, 2)); ?>/<?php echo e($material->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="materiales[<?php echo e($index); ?>][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="<?php echo e($item->quantity); ?>">
                            <input type="text" name="materiales[<?php echo e($index); ?>][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
                            <input type="number" name="materiales[<?php echo e($index); ?>][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly value="<?php echo e($item->unit_price); ?>">
                            <input type="number" name="materiales[<?php echo e($index); ?>][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly value="<?php echo e($item->total); ?>">
                            <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="material-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <select name="materiales[0][material_id]" style="flex: 2; padding: 8px;" class="material-select">
                                <option value="">🔍 Seleccione un material...</option>
                                <?php $__currentLoopData = $materiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($material->id); ?>" data-price="<?php echo e($material->price); ?>" data-unit="<?php echo e($material->unit); ?>">
                                        <?php echo e($material->code); ?> - <?php echo e($material->name); ?> ($<?php echo e(number_format($material->price, 2)); ?>/<?php echo e($material->unit); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="number" name="materiales[0][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="0">
                            <input type="text" name="materiales[0][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
                            <input type="number" name="materiales[0][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly>
                            <input type="number" name="materiales[0][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly>
                            <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" id="add-material" style="background: #3b82f6; color: white; border: none; padding: 8px 16px; margin-top: 10px; cursor: pointer;">➕ Agregar Material</button>
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
            
            <div style="display: flex; gap: 15px; margin-top: 20px; flex-wrap: wrap;">
                <button type="submit" name="action" value="nuevo" style="background: #22c55e; color: white; padding: 12px 25px; border: none; cursor: pointer; font-size: 16px; border-radius: 4px;">
                    💾 Guardar como NUEVO APU
                </button>
                <button type="submit" name="action" value="sobrescribir" style="background: #eab308; color: white; padding: 12px 25px; border: none; cursor: pointer; font-size: 16px; border-radius: 4px;">
                    🔄 Sobrescribir APU existente
                </button>
                <a href="<?php echo e(route('apus.index')); ?>" style="background: #6c757d; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px;">Cancelar</a>
            </div>
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
        
        const removeBtn = row.querySelector(".remove-equipo");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
        
        calcularTotalEquipo(row);
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
        
        const removeBtn = row.querySelector(".remove-labor");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
        
        calcularTotalLabor(row);
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
        
        const removeBtn = row.querySelector(".remove-material");
        if (removeBtn) {
            removeBtn.addEventListener("click", function() {
                row.remove();
                recalcularTotalesGenerales();
            });
        }
        
        calcularTotalMaterial(row);
    }
    
    // Configurar filas existentes
    document.querySelectorAll(".equipo-row").forEach(row => configurarEventosEquipo(row));
    document.querySelectorAll(".labor-row").forEach(row => configurarEventosLabor(row));
    document.querySelectorAll(".material-row").forEach(row => configurarEventosMaterial(row));
    
    // Contadores
    let equipoIndex = <?php echo e($equiposItems->count()); ?>;
    let laborIndex = <?php echo e($laborsItems->count()); ?>;
    let materialIndex = <?php echo e($materialesItems->count()); ?>;
    
    if (equipoIndex === 0) equipoIndex = 1;
    if (laborIndex === 0) laborIndex = 1;
    if (materialIndex === 0) materialIndex = 1;
    
    // Agregar equipo
    document.getElementById("add-equipo").addEventListener("click", function() {
        const container = document.getElementById("equipos-container");
        const newRow = document.createElement("div");
        newRow.className = "equipo-row";
        newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap;";
        newRow.innerHTML = `
            <select name="equipos[${equipoIndex}][material_id]" style="flex: 2; padding: 8px;" class="equipo-select">
                <option value="">🔍 Seleccione un equipo...</option>
                <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($equipo->id); ?>" data-price="<?php echo e($equipo->price); ?>" data-unit="<?php echo e($equipo->unit); ?>">
                        <?php echo e($equipo->code); ?> - <?php echo e($equipo->name); ?> ($<?php echo e(number_format($equipo->price, 2)); ?>/<?php echo e($equipo->unit); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="number" name="equipos[${equipoIndex}][quantity]" placeholder="📊 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="equipo-cantidad" value="0">
            <input type="text" name="equipos[${equipoIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="equipo-unidad" readonly>
            <input type="number" name="equipos[${equipoIndex}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="equipo-precio" readonly>
            <input type="number" name="equipos[${equipoIndex}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="equipo-rendimiento" value="1">
            <input type="number" name="equipos[${equipoIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="equipo-total" readonly>
            <button type="button" class="remove-equipo" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
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
                <?php $__currentLoopData = $labors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($labor->id); ?>" data-price="<?php echo e($labor->hourly_rate); ?>" data-unit="<?php echo e($labor->unit); ?>">
                        <?php echo e($labor->code); ?> - <?php echo e($labor->name); ?> ($<?php echo e(number_format($labor->hourly_rate, 2)); ?>/<?php echo e($labor->unit); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="number" name="labors[${laborIndex}][quantity]" placeholder="👥 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="labor-cantidad" value="0">
            <input type="text" name="labors[${laborIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="labor-unidad" readonly>
            <input type="number" name="labors[${laborIndex}][price]" placeholder="💰 Tarifa" step="0.01" style="flex: 1; padding: 8px;" class="labor-precio" readonly>
            <input type="number" name="labors[${laborIndex}][performance]" placeholder="⚙️ Rendimiento" step="0.01" style="flex: 1; padding: 8px;" class="labor-rendimiento" value="1">
            <input type="number" name="labors[${laborIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="labor-total" readonly>
            <button type="button" class="remove-labor" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
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
                <?php $__currentLoopData = $materiales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($material->id); ?>" data-price="<?php echo e($material->price); ?>" data-unit="<?php echo e($material->unit); ?>">
                        <?php echo e($material->code); ?> - <?php echo e($material->name); ?> ($<?php echo e(number_format($material->price, 2)); ?>/<?php echo e($material->unit); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <input type="number" name="materiales[${materialIndex}][quantity]" placeholder="📦 Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="material-cantidad" value="0">
            <input type="text" name="materiales[${materialIndex}][unit]" placeholder="📏 Unidad" style="flex: 1; padding: 8px;" class="material-unidad" readonly>
            <input type="number" name="materiales[${materialIndex}][price]" placeholder="💰 Precio" step="0.01" style="flex: 1; padding: 8px;" class="material-precio" readonly>
            <input type="number" name="materiales[${materialIndex}][total]" placeholder="💲 Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="material-total" readonly>
            <button type="button" class="remove-material" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
        `;
        container.appendChild(newRow);
        configurarEventosMaterial(newRow);
        materialIndex++;
    });
    
    // Recalcular totales iniciales
    setTimeout(function() {
        recalcularTotalesGenerales();
    }, 100);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/apus/clone.blade.php ENDPATH**/ ?>