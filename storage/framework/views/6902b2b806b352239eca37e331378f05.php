

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📋 Listado de APUs</h1>
        <a href="<?php echo e(route('apus.create')); ?>">➕ Nuevo APU</a>
        <a href="<?php echo e(url('/importar')); ?>">📤 Importar APU</a>
        
        <?php if(session('success')): ?>
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        
        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Rubro</th>
                    <th>Unidad</th>
                    <th>Costo Total</th>
                    <th>Items</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($apu->code); ?></strong></td>
                    <td><?php echo e(Str::limit($apu->name, 50)); ?></td>
                    <td><?php echo e($apu->unit); ?></td>
                    <td>$ <?php echo e(number_format($apu->total_cost ?? 0, 2)); ?></td>
                    <td><?php echo e($apu->items->count()); ?></td>
                    <td><?php echo e($apu->created_at->format('d/m/Y H:i')); ?></td>
                    <td>
                        <a href="/apu/<?php echo e($apu->id); ?>" style="color: #3b82f6;">Ver</a>
                        <a href="/apu/<?php echo e($apu->id); ?>/edit" style="color: #eab308;">Editar</a>
                        <a href="/apu/clonar/<?php echo e($apu->id); ?>" style="color: #8b5cf6;">📋 Clonar</a>
                        <form action="/apu/<?php echo e($apu->id); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;" onclick="return confirm('¿Eliminar este APU?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/apus/index.blade.php ENDPATH**/ ?>