

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>✏️ Editar Transporte</h1>
        <form method="POST" action="<?php echo e(route('transports.update', $transport->id)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" value="<?php echo e($transport->code); ?>" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" value="<?php echo e($transport->name); ?>" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <input type="text" name="category" value="<?php echo e($transport->category); ?>" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <select name="unit" required style="width:100%; padding: 8px;">
                    <option value="hora" <?php echo e($transport->unit == 'hora' ? 'selected' : ''); ?>>Hora</option>
                    <option value="día" <?php echo e($transport->unit == 'día' ? 'selected' : ''); ?>>Día</option>
                    <option value="viaje" <?php echo e($transport->unit == 'viaje' ? 'selected' : ''); ?>>Viaje</option>
                    <option value="km" <?php echo e($transport->unit == 'km' ? 'selected' : ''); ?>>Kilómetro</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Precio:</label>
                <input type="number" step="0.01" name="price" value="<?php echo e($transport->price); ?>" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" value="<?php echo e($transport->termino); ?>" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Descripción:</label>
                <textarea name="description" rows="3" style="width:100%; padding: 8px;"><?php echo e($transport->description); ?></textarea>
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none;">Actualizar</button>
            <a href="<?php echo e(route('transports.index')); ?>">Cancelar</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/transports/edit.blade.php ENDPATH**/ ?>