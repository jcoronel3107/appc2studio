@extends('layouts.app')

@section('content')
<style>
    .chapter-card { border: 3px solid #1e40af; border-radius: 12px; margin-bottom: 30px; padding: 20px; background: #eff6ff; }
    .milestone-card { border: 2px solid #3b82f6; border-radius: 10px; margin: 15px 0 15px 30px; padding: 15px; background: #f8fafc; }
    .category-card { border: 1px solid #94a3b8; border-radius: 8px; margin: 10px 0 10px 40px; padding: 12px; background: white; }
    .apu-row { margin-left: 60px; }
    .level-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-right: 10px; }
    .chapter-badge { background: #1e40af; color: white; }
    .milestone-badge { background: #3b82f6; color: white; }
    .category-badge { background: #94a3b8; color: white; }
</style>

<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📝 Nuevo Presupuesto por Capítulos</h1>
        
        <form method="POST" action="{{ route('budgets.store-chapter') }}" id="budgetForm">
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
                    <div><label>FECHA ENTREGA ANTICIPO:</label><input type="date" name="fecha_entrega_anticipo" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA INICIO OBRA:</label><input type="date" name="fecha_inicio_obra" style="width:100%; padding: 8px;"></div>
                    <div><label>PLAZO (DIAS):</label><input type="number" name="plazo_dias" style="width:100%; padding: 8px;"></div>
                    <div><label>AMPLIACION PLAZO:</label><input type="number" name="ampliacion_plazo" value="0" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA TERMINACION:</label><input type="date" name="fecha_terminacion_plazo" style="width:100%; padding: 8px;"></div>
                    <div><label>FECHA ELABORACIÓN:</label><input type="date" name="fecha_elaboracion" style="width:100%; padding: 8px;"></div>
                </div>
            </div>
            
            <!-- CAPÍTULOS -->
            <div style="margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h3>📚 Estructura del Presupuesto (Capítulo → Hito → Categoría → APU)</h3>
                    <button type="button" id="add-chapter" style="background: #1e40af; color: white; border: none; padding: 8px 16px; cursor: pointer;">➕ Agregar Capítulo</button>
                </div>
                
                <div id="chapters-container">
                    <!-- Capítulo inicial -->
                    <div class="chapter-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <span class="level-badge chapter-badge">CAPÍTULO</span>
                                <input type="text" name="chapters[0][code]" placeholder="Código (ej: 1)" value="1" style="width: 80px; padding: 8px; font-weight: bold;">
                                <input type="text" name="chapters[0][name]" placeholder="Nombre del Capítulo" value="Capítulo 1" style="flex: 1; padding: 8px; font-weight: bold;">
                            </div>
                            <button type="button" class="remove-chapter" style="background: #ef4444; color: white; border: none; padding: 5px 10px; cursor: pointer;">🗑️ Eliminar Capítulo</button>
                        </div>
                        
                        <div class="milestones-container" data-chapter="0">
                            <!-- Hito inicial -->
                            <div class="milestone-card">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <span class="level-badge milestone-badge">HITO</span>
                                        <input type="text" name="chapters[0][milestones][0][code]" placeholder="Código (ej: 1.1)" value="1.1" style="width: 80px; padding: 6px;">
                                        <input type="text" name="chapters[0][milestones][0][name]" placeholder="Nombre del Hito" value="Hito 1" style="width: 200px; padding: 6px;">
                                    </div>
                                    <button type="button" class="remove-milestone" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
                                </div>
                                
                                <div class="categories-container" data-milestone="0">
                                    <!-- Categoría inicial -->
                                    <div class="category-card">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <div style="display: flex; gap: 15px; align-items: center;">
                                                <span class="level-badge category-badge">CATEGORÍA</span>
                                                <input type="text" name="chapters[0][milestones][0][categories][0][code]" placeholder="Código (ej: 1.1.1)" value="1.1.1" style="width: 80px; padding: 5px;">
                                                <input type="text" name="chapters[0][milestones][0][categories][0][name]" placeholder="Nombre de Categoría" value="Categoría 1" style="width: 200px; padding: 5px;">
                                            </div>
                                            <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
                                        </div>
                                        
                                        <div class="apus-container">
                                            <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                                                <select name="chapters[0][milestones][0][categories][0][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                                                    <option value="">🔍 Seleccione un APU...</option>
                                                    @foreach($apus as $apu)
                                                        <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
                                                            {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="chapters[0][milestones][0][categories][0][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                                                <input type="text" name="chapters[0][milestones][0][categories][0][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                                                <input type="text" name="chapters[0][milestones][0][categories][0][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                                                <input type="number" name="chapters[0][milestones][0][categories][0][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                                                <input type="number" name="chapters[0][milestones][0][categories][0][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                                                <input type="number" name="chapters[0][milestones][0][categories][0][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                                                <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                                            </div>
                                        </div>
                                        <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
                                        <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px;">
                                            <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="add-category" style="background: #22c55e; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar Categoría</button>
                                <div class="milestone-subtotal" style="text-align: right; margin-top: 15px; padding: 8px; background: #bfdbfe; border-radius: 6px;">
                                    <strong>Subtotal Hito:</strong> $ <span class="milestone-subtotal-valor">0.00</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="add-milestone" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 30px; cursor: pointer;">➕ Agregar Hito</button>
                        <div class="chapter-subtotal" style="text-align: right; margin-top: 15px; padding: 10px; background: #dbeafe; border-radius: 8px;">
                            <strong>Subtotal Capítulo:</strong> $ <span class="chapter-subtotal-valor">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Totales Generales -->
            <div style="background: #d4edda; padding: 20px; border-radius: 8px; margin-top: 20px;">
                <div id="resumen-capitulos"></div>
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
                <a href="{{ route('budgets.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let chapterIndex = 1;
    let milestoneIndexes = {0: 1};
    let categoryIndexes = {};

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

    function recalcularTodosLosSubtotales() {
        let totalGeneral = 0;
        let resumenHtml = '';
        
        document.querySelectorAll(".chapter-card").forEach((chapter, chapterIdx) => {
            let chapterCode = chapter.querySelector("input[name*='[code]']").value || 'Capítulo';
            let chapterName = chapter.querySelector("input[name*='[name]']").value || '';
            let chapterTotal = 0;
            
            chapter.querySelectorAll(".milestone-card").forEach(milestone => {
                let milestoneTotal = 0;
                milestone.querySelectorAll(".category-card").forEach(category => {
                    let categoryTotal = 0;
                    category.querySelectorAll(".apu-row").forEach(row => {
                        let total = parseFloat(row.querySelector(".apu-total").value) || 0;
                        categoryTotal += total;
                    });
                    category.querySelector(".subtotal-valor").innerHTML = categoryTotal.toFixed(2);
                    milestoneTotal += categoryTotal;
                });
                milestone.querySelector(".milestone-subtotal-valor").innerHTML = milestoneTotal.toFixed(2);
                chapterTotal += milestoneTotal;
            });
            chapter.querySelector(".chapter-subtotal-valor").innerHTML = chapterTotal.toFixed(2);
            totalGeneral += chapterTotal;
            resumenHtml += `<p><strong>Capítulo ${chapterCode}:</strong> $${chapterTotal.toFixed(2)}</p>`;
        });
        
        const montoAnticipo = parseFloat(document.querySelector("input[name='monto_anticipo']").value) || 0;
        
        document.getElementById("resumen-capitulos").innerHTML = resumenHtml;
        document.getElementById("subtotal-apus").innerHTML = totalGeneral.toFixed(2);
        document.getElementById("monto-anticipo").innerHTML = montoAnticipo.toFixed(2);
        document.getElementById("total-presupuesto").innerHTML = (totalGeneral - montoAnticipo).toFixed(2);
        document.getElementById("monto").value = totalGeneral - montoAnticipo;
    }

    function configurarEventosFila(row, chapterIdx, milestoneIdx, categoryIdx) {
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
            recalcularTodosLosSubtotales();
        });
        
        quantity.oninput = function() {
            calcularTotalFila(row);
            recalcularTodosLosSubtotales();
        };
        
        row.querySelector(".remove-apu").onclick = function() {
            row.remove();
            recalcularTodosLosSubtotales();
        };
    }

    function agregarCategoria(milestoneCard, chapterIdx, milestoneIdx) {
        const categoriesContainer = milestoneCard.querySelector(".categories-container");
        const categoryIdx = categoryIndexes[`${chapterIdx}_${milestoneIdx}`] || 1;
        const apusOptions = document.getElementById('apus-data').innerHTML;
        
        const newCategory = document.createElement("div");
        newCategory.className = "category-card";
        newCategory.style = "border: 1px solid #94a3b8; border-radius: 8px; margin: 10px 0 10px 40px; padding: 12px; background: white;";
        newCategory.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge category-badge">CATEGORÍA</span>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][code]" placeholder="Código" value="${chapterIdx+1}.${milestoneIdx+1}.${categoryIdx}" style="width: 80px; padding: 5px;">
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][name]" placeholder="Nombre Categoría" value="Nueva Categoría" style="width: 200px; padding: 5px;">
                </div>
                <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <select name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        ${apusOptions}
                    </select>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
            <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px;">
                <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        
        categoriesContainer.appendChild(newCategory);
        initSelect2(newCategory);
        configurarEventosCategoria(newCategory, chapterIdx, milestoneIdx, categoryIdx);
        categoryIndexes[`${chapterIdx}_${milestoneIdx}`] = categoryIdx + 1;
        recalcularTodosLosSubtotales();
    }

    function configurarEventosCategoria(categoryCard, chapterIdx, milestoneIdx, categoryIdx) {
        categoryCard.querySelector(".remove-category").onclick = function() {
            categoryCard.remove();
            recalcularTodosLosSubtotales();
        };
        
        let apuIndex = 1;
        categoryCard.querySelector(".add-apu").onclick = function() {
            const apusContainer = categoryCard.querySelector(".apus-container");
            const apusOptions = document.getElementById('apus-data').innerHTML;
            const newRow = document.createElement("div");
            newRow.className = "apu-row";
            newRow.style = "margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;";
            newRow.innerHTML = `
                <select name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                    <option value="">🔍 Seleccione un APU...</option>
                    ${apusOptions}
                </select>
                <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][${categoryIdx}][items][${apuIndex}][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
            `;
            apusContainer.appendChild(newRow);
            initSelect2(newRow);
            configurarEventosFila(newRow, chapterIdx, milestoneIdx, categoryIdx);
            apuIndex++;
            recalcularTodosLosSubtotales();
        };
        
        categoryCard.querySelectorAll(".apu-row").forEach(row => {
            configurarEventosFila(row, chapterIdx, milestoneIdx, categoryIdx);
        });
    }

    function agregarHito(chapterCard, chapterIdx) {
        const milestonesContainer = chapterCard.querySelector(".milestones-container");
        const milestoneIdx = milestoneIndexes[chapterIdx] || 1;
        
        const newMilestone = document.createElement("div");
        newMilestone.className = "milestone-card";
        newMilestone.style = "border: 2px solid #3b82f6; border-radius: 10px; margin: 15px 0 15px 30px; padding: 15px; background: #f8fafc;";
        newMilestone.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge milestone-badge">HITO</span>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][code]" placeholder="Código" value="${chapterIdx+1}.${milestoneIdx}" style="width: 80px; padding: 6px;">
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][name]" placeholder="Nombre del Hito" value="Hito ${milestoneIdx}" style="width: 200px; padding: 6px;">
                </div>
                <button type="button" class="remove-milestone" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="categories-container"></div>
            <button type="button" class="add-category" style="background: #22c55e; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar Categoría</button>
            <div class="milestone-subtotal" style="text-align: right; margin-top: 15px; padding: 8px; background: #bfdbfe; border-radius: 6px;">
                <strong>Subtotal Hito:</strong> $ <span class="milestone-subtotal-valor">0.00</span>
            </div>
        `;
        
        milestonesContainer.appendChild(newMilestone);
        milestoneIndexes[chapterIdx] = milestoneIdx + 1;
        
        // Agregar categoría inicial
        const categoriesContainer = newMilestone.querySelector(".categories-container");
        const categoryIdx = 0;
        const apusOptions = document.getElementById('apus-data').innerHTML;
        const firstCategory = document.createElement("div");
        firstCategory.className = "category-card";
        firstCategory.style = "border: 1px solid #94a3b8; border-radius: 8px; margin: 10px 0 10px 40px; padding: 12px; background: white;";
        firstCategory.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge category-badge">CATEGORÍA</span>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][code]" placeholder="Código" value="${chapterIdx+1}.${milestoneIdx}.1" style="width: 80px; padding: 5px;">
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][name]" placeholder="Nombre Categoría" value="Categoría 1" style="width: 200px; padding: 5px;">
                </div>
                <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <select name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        ${apusOptions}
                    </select>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="chapters[${chapterIdx}][milestones][${milestoneIdx}][categories][0][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
            <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px;">
                <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        categoriesContainer.appendChild(firstCategory);
        initSelect2(firstCategory);
        configurarEventosCategoria(firstCategory, chapterIdx, milestoneIdx, 0);
        
        newMilestone.querySelector(".remove-milestone").onclick = function() {
            newMilestone.remove();
            recalcularTodosLosSubtotales();
        };
        
        newMilestone.querySelector(".add-category").onclick = function() {
            agregarCategoria(newMilestone, chapterIdx, milestoneIdx);
        };
        
        recalcularTodosLosSubtotales();
    }

    function agregarCapitulo() {
        const container = document.getElementById("chapters-container");
        const newChapter = document.createElement("div");
        newChapter.className = "chapter-card";
        newChapter.style = "border: 3px solid #1e40af; border-radius: 12px; margin-bottom: 30px; padding: 20px; background: #eff6ff;";
        newChapter.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge chapter-badge">CAPÍTULO</span>
                    <input type="text" name="chapters[${chapterIndex}][code]" placeholder="Código" value="${chapterIndex+1}" style="width: 80px; padding: 8px; font-weight: bold;">
                    <input type="text" name="chapters[${chapterIndex}][name]" placeholder="Nombre del Capítulo" value="Capítulo ${chapterIndex+1}" style="flex: 1; padding: 8px; font-weight: bold;">
                </div>
                <button type="button" class="remove-chapter" style="background: #ef4444; color: white; border: none; padding: 5px 10px; cursor: pointer;">🗑️ Eliminar Capítulo</button>
            </div>
            <div class="milestones-container"></div>
            <button type="button" class="add-milestone" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; margin-left: 30px; cursor: pointer;">➕ Agregar Hito</button>
            <div class="chapter-subtotal" style="text-align: right; margin-top: 15px; padding: 10px; background: #dbeafe; border-radius: 8px;">
                <strong>Subtotal Capítulo:</strong> $ <span class="chapter-subtotal-valor">0.00</span>
            </div>
        `;
        
        container.appendChild(newChapter);
        
        // Agregar hito inicial
        const milestonesContainer = newChapter.querySelector(".milestones-container");
        const milestoneIdx = 0;
        const apusOptions = document.getElementById('apus-data').innerHTML;
        const firstMilestone = document.createElement("div");
        firstMilestone.className = "milestone-card";
        firstMilestone.style = "border: 2px solid #3b82f6; border-radius: 10px; margin: 15px 0 15px 30px; padding: 15px; background: #f8fafc;";
        firstMilestone.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge milestone-badge">HITO</span>
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][code]" placeholder="Código" value="${chapterIndex+1}.1" style="width: 80px; padding: 6px;">
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][name]" placeholder="Nombre del Hito" value="Hito 1" style="width: 200px; padding: 6px;">
                </div>
                <button type="button" class="remove-milestone" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="categories-container"></div>
            <button type="button" class="add-category" style="background: #22c55e; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar Categoría</button>
            <div class="milestone-subtotal" style="text-align: right; margin-top: 15px; padding: 8px; background: #bfdbfe; border-radius: 6px;">
                <strong>Subtotal Hito:</strong> $ <span class="milestone-subtotal-valor">0.00</span>
            </div>
        `;
        milestonesContainer.appendChild(firstMilestone);
        
        // Agregar categoría inicial al hito
        const categoriesContainer = firstMilestone.querySelector(".categories-container");
        const firstCategory = document.createElement("div");
        firstCategory.className = "category-card";
        firstCategory.style = "border: 1px solid #94a3b8; border-radius: 8px; margin: 10px 0 10px 40px; padding: 12px; background: white;";
        firstCategory.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span class="level-badge category-badge">CATEGORÍA</span>
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][categories][0][code]" placeholder="Código" value="${chapterIndex+1}.1.1" style="width: 80px; padding: 5px;">
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][categories][0][name]" placeholder="Nombre Categoría" value="Categoría 1" style="width: 200px; padding: 5px;">
                </div>
                <button type="button" class="remove-category" style="background: #ef4444; color: white; border: none; padding: 3px 8px; cursor: pointer;">🗑️</button>
            </div>
            <div class="apus-container">
                <div class="apu-row" style="margin-bottom: 10px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <select name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][apu_id]" style="flex: 2; padding: 8px;" class="apu-select select2">
                        <option value="">🔍 Seleccione un APU...</option>
                        ${apusOptions}
                    </select>
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][apu_code]" placeholder="Código" style="flex: 1; padding: 8px;" class="apu-code" readonly>
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][apu_name]" placeholder="Nombre" style="flex: 2; padding: 8px;" class="apu-name" readonly>
                    <input type="text" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][apu_unit]" placeholder="Unidad" style="flex: 1; padding: 8px;" class="apu-unit" readonly>
                    <input type="number" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][quantity]" placeholder="Cantidad" step="0.01" style="flex: 1; padding: 8px;" class="apu-quantity" value="1">
                    <input type="number" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][unit_price]" placeholder="Precio" step="0.01" style="flex: 1; padding: 8px;" class="apu-price" readonly>
                    <input type="number" name="chapters[${chapterIndex}][milestones][0][categories][0][items][0][total]" placeholder="Total" step="0.01" style="flex: 1; padding: 8px; background:#e0e0e0;" class="apu-total" readonly>
                    <button type="button" class="remove-apu" style="background: #ef4444; color: white; border: none; padding: 8px 12px; cursor: pointer;">🗑️</button>
                </div>
            </div>
            <button type="button" class="add-apu" style="background: #3b82f6; color: white; border: none; padding: 5px 12px; margin-top: 10px; cursor: pointer;">➕ Agregar APU</button>
            <div class="category-subtotal" style="text-align: right; margin-top: 10px; padding: 5px; background: #e0e7ff; border-radius: 4px;">
                <strong>Subtotal Categoría:</strong> $ <span class="subtotal-valor">0.00</span>
            </div>
        `;
        categoriesContainer.appendChild(firstCategory);
        
        initSelect2(firstCategory);
        configurarEventosCategoria(firstCategory, chapterIndex, 0, 0);
        
        firstMilestone.querySelector(".remove-milestone").onclick = function() {
            firstMilestone.remove();
            recalcularTodosLosSubtotales();
        };
        firstMilestone.querySelector(".add-category").onclick = function() {
            agregarCategoria(firstMilestone, chapterIndex, 0);
        };
        
        newChapter.querySelector(".remove-chapter").onclick = function() {
            newChapter.remove();
            recalcularTodosLosSubtotales();
        };
        newChapter.querySelector(".add-milestone").onclick = function() {
            agregarHito(newChapter, chapterIndex);
        };
        
        milestoneIndexes[chapterIndex] = 1;
        chapterIndex++;
        recalcularTodosLosSubtotales();
    }

    // Configurar eventos iniciales
    document.querySelectorAll(".chapter-card").forEach((chapter, idx) => {
        chapter.querySelector(".remove-chapter").onclick = function() {
            chapter.remove();
            recalcularTodosLosSubtotales();
        };
        chapter.querySelector(".add-milestone").onclick = function() {
            agregarHito(chapter, idx);
        };
        chapter.querySelectorAll(".milestone-card").forEach((milestone, midx) => {
            milestone.querySelector(".remove-milestone").onclick = function() {
                milestone.remove();
                recalcularTodosLosSubtotales();
            };
            milestone.querySelector(".add-category").onclick = function() {
                agregarCategoria(milestone, idx, midx);
            };
            milestone.querySelectorAll(".category-card").forEach((category, cidx) => {
                configurarEventosCategoria(category, idx, midx, cidx);
            });
        });
    });

    document.getElementById("add-chapter").onclick = agregarCapitulo;
    
    document.querySelector("input[name='monto_anticipo']").oninput = function() {
        recalcularTodosLosSubtotales();
    };
    
    $(document).ready(function() {
        initSelect2(document);
        recalcularTodosLosSubtotales();
    });
</script>

<div id="apus-data" style="display: none;">
    @foreach($apus as $apu)
        <option value="{{ $apu->id }}" data-code="{{ $apu->code }}" data-name="{{ $apu->name }}" data-unit="{{ $apu->unit }}" data-price="{{ $apu->total_cost ?? 0 }}">
            {{ $apu->code }} - {{ $apu->name }} (${{ number_format($apu->total_cost ?? 0, 2) }}/{{ $apu->unit }})
        </option>
    @endforeach
</div>
@endsection