

<?php $__env->startSection('content'); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>➕ Nuevo Transporte</h1>
        <form method="POST" action="<?php echo e(route('transports.store')); ?>">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom: 15px;">
                <label>Código:</label>
                <input type="text" name="code" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Nombre:</label>
                <input type="text" name="name" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Categoría:</label>
                <input type="text" name="category" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Unidad:</label>
                <select name="unit" required style="width:100%; padding: 8px;">
                    <option value="hora">Hora</option>
                    <option value="día">Día</option>
                    <option value="viaje">Viaje</option>
                    <option value="km">Kilómetro</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Precio:</label>
                <input type="number" step="0.01" name="price" required style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Término:</label>
                <input type="text" name="termino" style="width:100%; padding: 8px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Descripción:</label>
                <textarea name="description" rows="3" style="width:100%; padding: 8px;"></textarea>
            </div>
            <button type="submit" style="background: #22c55e; color: white; padding: 10px 20px; border: none;">Guardar</button>
            <a href="<?php echo e(route('transports.index')); ?>">Cancelar</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/transports/create.blade.php ENDPATH**/ ?>