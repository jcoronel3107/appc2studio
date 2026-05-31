echo '

<?php $__env->startSection("content"); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>🖥️ Equipos</h1>
        <a href="<?php echo e(route("equipments.create")); ?>">➕ Nuevo Equipo</a>
        <a href="<?php echo e(route("equipments.import.form")); ?>">📤 Importar</a>
        <a href="<?php echo e(route("equipments.export")); ?>">💾 Exportar</a>
        
        <?php if(session("success")): ?>
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ <?php echo e(session("success")); ?></div>
        <?php endif; ?>
        
        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($equipment->code); ?></td>
                    <td><?php echo e($equipment->name); ?></td>
                    <td><?php echo e($equipment->category ?? "-"); ?></td>
                    <td><?php echo e($equipment->unit); ?></td>
                    <td>$<?php echo e(number_format($equipment->price, 2)); ?></td>
                    <td><?php echo e($equipment->termino ?? "-"); ?></td>
                    <td>
                        <a href="<?php echo e(route("equipments.edit", $equipment->id)); ?>">✏️ Editar</a>
                        <form action="<?php echo e(route("equipments.destroy", $equipment->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("DELETE"); ?>
                            <button type="submit" onclick="return confirm(\"¿Eliminar este equipo?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="margin-top: 20px;"><?php echo e($equipments->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>' > resources\views\equipments\index.blade.php
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/equipments/index.blade.php ENDPATH**/ ?>