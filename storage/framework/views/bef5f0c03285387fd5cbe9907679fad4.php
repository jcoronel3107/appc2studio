<?php $__env->startSection('content'); ?>
<style>
    .chapter-card { border: 3px solid #1e40af; border-radius: 12px; margin-bottom: 30px; overflow: hidden; }
    .chapter-header { background: linear-gradient(135deg, #1e40af, #2563eb); color: white; padding: 15px 20px; }
    .milestone-card { border: 2px solid #3b82f6; border-radius: 10px; margin: 15px 20px 15px 40px; overflow: hidden; }
    .milestone-header { background: #3b82f6; color: white; padding: 10px 15px; }
    .category-card { border: 1px solid #94a3b8; border-radius: 8px; margin: 10px 20px 10px 60px; overflow: hidden; }
    .category-header { background: #e2e8f0; padding: 8px 15px; border-bottom: 1px solid #cbd5e1; }
    .level-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-right: 10px; }
    .chapter-badge { background: #1e40af; color: white; }
    .milestone-badge { background: #3b82f6; color: white; }
    .category-badge { background: #64748b; color: white; }
    .apu-table { width: 100%; border-collapse: collapse; }
    .apu-table th, .apu-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
    .apu-table th { background: #f8fafc; font-weight: bold; }
    .apu-table tr:hover { background: #f1f5f9; }
    .total-row { background: #dbeafe; font-weight: bold; }
    .grand-total { background: #d4edda; font-size: 18px; font-weight: bold; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
    .summary-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; color: #1e40af; }
    .summary-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
    .summary-item { background: white; border-radius: 8px; padding: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .summary-item-label { font-size: 12px; color: #64748b; margin-bottom: 5px; }
    .summary-item-value { font-size: 18px; font-weight: bold; color: #1e40af; }
    .summary-item-chapter { border-left: 4px solid #1e40af; }
    .summary-item-milestone { border-left: 4px solid #3b82f6; }
    .summary-item-category { border-left: 4px solid #64748b; }
</style>

<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px; max-width: 1400px; margin: 0 auto;">
        <!-- Header con botones -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0;">📄 Presupuesto #<?php echo e($budget->id); ?> - <?php echo e($budget->obra); ?></h1>
            <div>
                <a href="<?php echo e(route('budgets.edit', $budget->id)); ?>" style="background: #eab308; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; margin-right: 10px;">✏️ Editar</a>
                <a href="<?php echo e(route('budgets.index')); ?>" style="background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">← Volver</a>
                <a href="<?php echo e(route('budgets.export-chapter', $budget->id)); ?>" style="background: #10b981; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; margin-right: 10px;">📊 Exp a Excel</a>
                <a href="<?php echo e(route('budgets.export-presupuesto', $budget->id)); ?>" style="background: #8b5cf6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; margin-right: 10px;">📊 Exportar Presupuesto</a>
                <a href="<?php echo e(route('budgets.export-complete', $budget->id)); ?>" style="background: #8b5cf6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px; margin-right: 10px;">📥 Exportar</a>
            </div>
        </div>
        
        <!-- Datos de cabecera -->
        <div style="background: #f0f0f0; padding: 20px; margin-bottom: 25px; border-radius: 8px;">
            <h3 style="margin: 0 0 15px 0; color: #333;">📋 Datos Generales</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
                <div><strong>🏗️ OBRA:</strong> <?php echo e($budget->obra); ?></div>
                <div><strong>📄 No. CONTRATO:</strong> <?php echo e($budget->no_contrato ?? '-'); ?></div>
                <div><strong>👤 CONTRATISTA:</strong> <?php echo e($budget->contratista ?? '-'); ?></div>
                <div><strong>📅 FECHA CONTRATO:</strong> <?php echo e($budget->fecha_contrato ? \Carbon\Carbon::parse($budget->fecha_contrato)->format('d/m/Y') : '-'); ?></div>
                <div><strong>💰 MONTO ANTICIPO:</strong> $<?php echo e(number_format($budget->monto_anticipo ?? 0, 2)); ?></div>
                <div><strong>📅 FECHA ENTREGA ANTICIPO:</strong> <?php echo e($budget->fecha_entrega_anticipo ? \Carbon\Carbon::parse($budget->fecha_entrega_anticipo)->format('d/m/Y') : '-'); ?></div>
                <div><strong>🔍 FISCALIZADOR:</strong> <?php echo e($budget->fiscalizador ?? '-'); ?></div>
                <div><strong>📅 FECHA INICIO OBRA:</strong> <?php echo e($budget->fecha_inicio_obra ? \Carbon\Carbon::parse($budget->fecha_inicio_obra)->format('d/m/Y') : '-'); ?></div>
                <div><strong>👨‍💼 ADMINISTRADOR:</strong> <?php echo e($budget->administrador ?? '-'); ?></div>
                <div><strong>⏱️ PLAZO:</strong> <?php echo e($budget->plazo_dias ?? '-'); ?> días</div>
                <div><strong>➕ AMPLIACIÓN:</strong> <?php echo e($budget->ampliacion_plazo ?? 0); ?> días</div>
                <div><strong>📅 FECHA TERMINACIÓN:</strong> <?php echo e($budget->fecha_terminacion_plazo ? \Carbon\Carbon::parse($budget->fecha_terminacion_plazo)->format('d/m/Y') : '-'); ?></div>
                <div><strong>📅 FECHA ELABORACIÓN:</strong> <?php echo e($budget->fecha_elaboracion ? \Carbon\Carbon::parse($budget->fecha_elaboracion)->format('d/m/Y') : '-'); ?></div>
            </div>
        </div>
        
        <!-- RESUMEN DE TOTALES POR CAPÍTULO, HITO Y CATEGORÍA -->
        <div class="summary-box">
            <div class="summary-title">📊 RESÚMEN DE TOTALES POR CAPÍTULO</div>
            <div class="summary-grid">
                <?php
                    // Organizar datos por capítulo, hito y categoría
                    $capitulosResumen = [];
                    $hitosResumen = [];
                    $categoriasResumen = [];
                    $totalGeneral = 0;
                    
                    foreach($budget->items as $item) {
                        $chapterKey = $item->chapter_code ?? 'sin_capitulo';
                        if (!isset($capitulosResumen[$chapterKey])) {
                            $capitulosResumen[$chapterKey] = [
                                'code' => $item->chapter_code,
                                'name' => $item->chapter_name,
                                'total' => 0
                            ];
                        }
                        $capitulosResumen[$chapterKey]['total'] += $item->total;
                        $totalGeneral += $item->total;
                        
                        $milestoneKey = $item->milestone_id ?? 'sin_hito';
                        if (!isset($hitosResumen[$milestoneKey])) {
                            $hitosResumen[$milestoneKey] = [
                                'code' => $item->milestone_code,
                                'name' => $item->milestone_name,
                                'chapter' => $item->chapter_name,
                                'total' => 0
                            ];
                        }
                        $hitosResumen[$milestoneKey]['total'] += $item->total;
                        
                        $categoryKey = $item->category_code ?? $item->category;
                        if (!isset($categoriasResumen[$categoryKey])) {
                            $categoriasResumen[$categoryKey] = [
                                'code' => $item->category_code,
                                'name' => $item->category,
                                'milestone' => $item->milestone_name,
                                'chapter' => $item->chapter_name,
                                'total' => 0
                            ];
                        }
                        $categoriasResumen[$categoryKey]['total'] += $item->total;
                    }
                ?>
                
                <!-- Tarjetas de Capítulos -->
                <div class="summary-item summary-item-chapter">
                    <div class="summary-item-label">📚 TOTAL POR CAPÍTULOS</div>
                    <?php $__currentLoopData = $capitulosResumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                            <span><?php echo e($cap['code']); ?> <?php echo e($cap['name']); ?>:</span>
                            <span style="font-weight: bold;">$<?php echo e(number_format($cap['total'], 2)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Tarjetas de Hitos -->
                <div class="summary-item summary-item-milestone">
                    <div class="summary-item-label">🎯 TOTAL POR HITOS</div>
                    <?php $__currentLoopData = $hitosResumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                            <span><?php echo e($hit['code']); ?> <?php echo e($hit['name']); ?>:</span>
                            <span style="font-weight: bold;">$<?php echo e(number_format($hit['total'], 2)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <!-- Tarjetas de Categorías -->
                <div class="summary-item summary-item-category">
                    <div class="summary-item-label">📁 TOTAL POR CATEGORÍAS</div>
                    <?php $__currentLoopData = $categoriasResumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                            <span><?php echo e($cat['code']); ?> <?php echo e($cat['name']); ?>:</span>
                            <span style="font-weight: bold;">$<?php echo e(number_format($cat['total'], 2)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        
        <!-- Estructura del Presupuesto: Capítulo → Hito → Categoría → APU -->
        <h3 style="margin-bottom: 20px;">📋 DESGLOSE DETALLADO</h3>
        
        <?php
            // Organizar datos por capítulo y hito para el desglose
            $capitulos = [];
            foreach($budget->items as $item) {
                $chapterKey = $item->chapter_code ?? 'sin_capitulo';
                if (!isset($capitulos[$chapterKey])) {
                    $capitulos[$chapterKey] = [
                        'code' => $item->chapter_code,
                        'name' => $item->chapter_name,
                        'hitos' => []
                    ];
                }
                $milestoneKey = $item->milestone_id ?? 'sin_hito';
                if (!isset($capitulos[$chapterKey]['hitos'][$milestoneKey])) {
                    $capitulos[$chapterKey]['hitos'][$milestoneKey] = [
                        'code' => $item->milestone_code,
                        'name' => $item->milestone_name,
                        'categorias' => []
                    ];
                }
                $categoryKey = $item->category_code ?? $item->category;
                if (!isset($capitulos[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey])) {
                    $capitulos[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey] = [
                        'name' => $item->category,
                        'items' => []
                    ];
                }
                $capitulos[$chapterKey]['hitos'][$milestoneKey]['categorias'][$categoryKey]['items'][] = $item;
            }
        ?>
        
        <?php if(count($capitulos) > 0): ?>
            <?php $__currentLoopData = $capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chapterKey => $chapter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- CAPÍTULO -->
            <div class="chapter-card">
                <div class="chapter-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span class="level-badge chapter-badge">CAPÍTULO</span>
                            <span style="font-size: 20px; font-weight: bold;"><?php echo e($chapter['code']); ?></span>
                            <span style="font-size: 18px; margin-left: 15px;"><?php echo e($chapter['name']); ?></span>
                        </div>
                        <?php $subtotalCapitulo = 0; ?>
                    </div>
                </div>
                
                <div style="padding: 15px;">
                    <?php $__currentLoopData = $chapter['hitos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestoneKey => $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!-- HITO -->
                    <div class="milestone-card">
                        <div class="milestone-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span class="level-badge milestone-badge">HITO</span>
                                    <span style="font-weight: bold;"><?php echo e($milestone['code']); ?></span>
                                    <span style="margin-left: 15px;"><?php echo e($milestone['name']); ?></span>
                                </div>
                                <?php $subtotalHito = 0; ?>
                            </div>
                        </div>
                        
                        <div style="padding: 15px;">
                            <?php $__currentLoopData = $milestone['categorias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryKey => $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <!-- CATEGORÍA -->
                            <div class="category-card">
                                <div class="category-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <span class="level-badge category-badge">CATEGORÍA</span>
                                            <span style="font-weight: bold;"><?php echo e($categoryKey); ?></span>
                                            <span style="margin-left: 15px;"><?php echo e($categoria['name']); ?></span>
                                        </div>
                                        <?php $subtotalCategoria = 0; ?>
                                    </div>
                                </div>
                                
                                <!-- Tabla de APUs -->
                                <table class="apu-table">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre del APU</th>
                                            <th>Unidad</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-right">Precio Unitario</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $categoria['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $subtotalCategoria += $item->total;
                                            $subtotalHito += $item->total;
                                            $subtotalCapitulo += $item->total;
                                        ?>
                                        <tr>
                                            <td><?php echo e($item->apu_code); ?></td>
                                            <td><?php echo e($item->apu_name); ?></td>
                                            <td><?php echo e($item->apu_unit); ?></td>
                                            <td class="text-center"><?php echo e(number_format($item->quantity, 2)); ?></td>
                                            <td class="text-right">$<?php echo e(number_format($item->unit_price, 2)); ?></td>
                                            <td class="text-right">$<?php echo e(number_format($item->total, 2)); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="5" class="text-right"><strong>Subtotal <?php echo e($categoria['name']); ?>:</strong></td>
                                            <td class="text-right"><strong>$<?php echo e(number_format($subtotalCategoria, 2)); ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <!-- Subtotal del Hito -->
                            <div style="text-align: right; margin-top: 15px; padding: 10px; background: #bfdbfe; border-radius: 6px;">
                                <strong>SUBTOTAL HITO <?php echo e($milestone['code']); ?> - <?php echo e($milestone['name']); ?>:</strong>
                                <span style="font-size: 16px;">$<?php echo e(number_format($subtotalHito, 2)); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <!-- Subtotal del Capítulo -->
                    <div style="text-align: right; margin-top: 20px; padding: 12px; background: #dbeafe; border-radius: 8px;">
                        <strong>SUBTOTAL CAPÍTULO <?php echo e($chapter['code']); ?> - <?php echo e($chapter['name']); ?>:</strong>
                        <span style="font-size: 16px;">$<?php echo e(number_format($subtotalCapitulo, 2)); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <!-- TOTALES GENERALES -->
            <div class="grand-total" style="background: #d4edda; padding: 20px; border-radius: 8px; margin-top: 25px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span><strong>SUBTOTAL APUs:</strong></span>
                    <span><strong>$<?php echo e(number_format($totalGeneral, 2)); ?></strong></span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #dc2626;">
                    <span><strong>MONTO ANTICIPO:</strong></span>
                    <span><strong>-$<?php echo e(number_format($budget->monto_anticipo ?? 0, 2)); ?></strong></span>
                </div>
                <hr style="margin: 15px 0;">
                <div style="display: flex; justify-content: space-between; font-size: 20px;">
                    <span><strong>TOTAL PRESUPUESTO:</strong></span>
                    <span><strong>$<?php echo e(number_format($totalGeneral - ($budget->monto_anticipo ?? 0), 2)); ?></strong></span>
                </div>
            </div>
        <?php else: ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 40px; text-align: center;">
                <p style="margin: 0; color: #dc2626;">⚠️ No hay APUs agregados a este presupuesto.</p>
                <a href="<?php echo e(route('budgets.edit', $budget->id)); ?>" style="display: inline-block; margin-top: 15px; background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 6px;">➕ Agregar APUs</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Desarrollo\app2sintent\appc2studio\resources\views/budgets/show_chapter.blade.php ENDPATH**/ ?>