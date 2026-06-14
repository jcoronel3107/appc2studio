<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>📋 Presupuestos</h1>
            <div>
                <a href="<?php echo e(route('budgets.create')); ?>" style="background: #22c55e; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;">➕ Nuevo Presupuesto</a>
                <a href="<?php echo e(route('budgets.create-with-milestones')); ?>" style="background: #8b5cf6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-left: 10px;">🚀 Con Hitos</a>
                <a href="<?php echo e(route('budgets.create-chapter')); ?>" style="background: #1e40af; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-left: 10px;">📚 Por Capítulos</a>
            </div>
        </div>
        
        <?php if(session('success')): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">✅ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Obra</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Contratista</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Monto</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Fecha</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budgetItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($budgetItem->id); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($budgetItem->obra); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($budgetItem->contratista ?? '-'); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">$<?php echo e(number_format($budgetItem->monto ?? 0, 2)); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($budgetItem->created_at->format('d/m/Y')); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <a href="<?php echo e(route('budgets.show', $budgetItem->id)); ?>" style="color: #3b82f6;">👁️ Ver</a>
                        <a href="<?php echo e(route('budgets.show-with-milestones', $budgetItem->id)); ?>" style="color: #8b5cf6; margin-left: 10px;">📊 Hitos</a>
                        <a href="<?php echo e(route('budgets.show-chapter', $budgetItem->id)); ?>" style="color: #1e40af; margin-left: 10px;">📚 Capítulos</a>
                        <a href="<?php echo e(route('budgets.edit', $budgetItem->id)); ?>" style="color: #eab308; margin-left: 10px;">✏️ Editar</a>
                        <form action="<?php echo e(route('budgets.destroy', $budgetItem->id)); ?>" method="POST" style="display:inline; margin-left: 10px;">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este presupuesto?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center;">📭 No hay presupuestos registrados</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($budgets->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio_\resources\views/budgets/index.blade.php ENDPATH**/ ?>