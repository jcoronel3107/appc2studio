<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🖥️ Equipos</h1>
        
        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="<?php echo e(route('equipments.create')); ?>" style="background: #22c55e; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">➕ Nuevo Equipo</a>
            <a href="<?php echo e(route('equipments.import.form')); ?>" style="background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">📤 Importar</a>
            <a href="<?php echo e(route('equipments.export')); ?>" style="background: #a855f7; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">💾 Exportar</a>
        </div>
        
        <?php if(session('success')): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">
                ✅ <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 12px; margin: 10px 0; border-radius: 4px;">
                ❌ <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="<?php echo e(route('equipments.index')); ?>" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="<?php echo e(request('search')); ?>" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('equipments.index')); ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if(request('search')): ?>
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                Resultados para: <strong>"<?php echo e(request('search')); ?>"</strong> - <?php echo e($equipments->total()); ?> encontrados
            </div>
        <?php endif; ?>



        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Código</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Nombre</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Categoría</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Unidad</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Precio</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Término</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <strong><?php echo e($equipment->code); ?></strong>
                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?php echo e($equipment->name); ?>

                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?php echo e($equipment->category ?? '-'); ?>

                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?php echo e($equipment->unit); ?>

                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        $<?php echo e(number_format($equipment->price, 2)); ?>

                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <?php echo e($equipment->termino ?? '-'); ?>

                    </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <div style="display: flex; gap: 8px;">
                            <a href="<?php echo e(route('equipments.edit', $equipment->id)); ?>" style="color: #eab308; text-decoration: none;">✏️ Editar</a>
                            <form action="<?php echo e(route('equipments.destroy', $equipment->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este equipo?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; border: 1px solid #ddd;">
                        📭 No hay equipos registrados.
                        <a href="<?php echo e(route('equipments.create')); ?>" style="display: block; margin-top: 10px; color: #3b82f6;">➕ Crear el primer equipo</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Paginación -->
        <?php if($equipments->hasPages()): ?>
        <div style="margin-top: 30px; text-align: center;">
            <div style="display: inline-flex; gap: 5px; flex-wrap: wrap; justify-content: center;">
                
                <?php if($equipments->onFirstPage()): ?>
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">« Primera</span>
                <?php else: ?>
                    <a href="<?php echo e($equipments->url(1)); ?>" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">« Primera</a>
                <?php endif; ?>
                
                
                <?php if($equipments->onFirstPage()): ?>
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">‹ Anterior</span>
                <?php else: ?>
                    <a href="<?php echo e($equipments->previousPageUrl()); ?>" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">‹ Anterior</a>
                <?php endif; ?>
                
                
                <?php
                    $start = max(1, $equipments->currentPage() - 2);
                    $end = min($equipments->lastPage(), $equipments->currentPage() + 2);
                ?>
                
                <?php if($start > 1): ?>
                    <span style="padding: 8px 12px;">...</span>
                <?php endif; ?>
                
                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $equipments->currentPage()): ?>
                        <span style="padding: 8px 12px; background: #3b82f6; color: white; border-radius: 4px;"><?php echo e($i); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($equipments->url($i)); ?>" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;"><?php echo e($i); ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if($end < $equipments->lastPage()): ?>
                    <span style="padding: 8px 12px;">...</span>
                <?php endif; ?>
                
                
                <?php if($equipments->hasMorePages()): ?>
                    <a href="<?php echo e($equipments->nextPageUrl()); ?>" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Siguiente ›</a>
                <?php else: ?>
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Siguiente ›</span>
                <?php endif; ?>
                
                
                <?php if($equipments->hasMorePages()): ?>
                    <a href="<?php echo e($equipments->url($equipments->lastPage())); ?>" style="padding: 8px 12px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 4px;">Última »</a>
                <?php else: ?>
                    <span style="padding: 8px 12px; background: #e5e7eb; color: #9ca3af; border-radius: 4px;">Última »</span>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 15px; font-size: 14px; color: #666;">
                Mostrando <?php echo e($equipments->firstItem()); ?> - <?php echo e($equipments->lastItem()); ?> de <?php echo e($equipments->total()); ?> equipos
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/equipments/index.blade.php ENDPATH**/ ?>