

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🚚 Transporte</h1>
        
        <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="<?php echo e(route('transports.create')); ?>" style="background: #22c55e; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">➕ Nuevo Transporte</a>
            <a href="<?php echo e(route('transports.import.form')); ?>" style="background: #3b82f6; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">📤 Importar</a>
            <a href="<?php echo e(route('transports.export')); ?>" style="background: #a855f7; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px;">💾 Exportar</a>
        </div>
        
        <?php if(session('success')): ?>
            <div style="background: #d4edda; color: #155724; padding: 12px; margin: 10px 0; border-radius: 4px;">✅ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #3b82f6; color: white;">
                    <th style="padding: 12px; border: 1px solid #ddd;">Código</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Nombre</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Categoría</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Unidad</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Precio</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Término</th>
                    <th style="padding: 12px; border: 1px solid #ddd;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $transports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><strong><?php echo e($transport->code); ?></strong></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($transport->name); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($transport->category ?? '-'); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($transport->unit); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">$<?php echo e(number_format($transport->price, 2)); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo e($transport->termino ?? '-'); ?></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <a href="<?php echo e(route('transports.edit', $transport->id)); ?>" style="color: #eab308;">✏️ Editar</a>
                        <form action="<?php echo e(route('transports.destroy', $transport->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center;">📭 No hay registros de transporte</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($transports->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/transports/index.blade.php ENDPATH**/ ?>