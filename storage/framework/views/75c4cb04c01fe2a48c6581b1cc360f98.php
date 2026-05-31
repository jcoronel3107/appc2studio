echo '

<?php $__env->startSection("content"); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>📦 Materiales</h1>
        <a href="<?php echo e(route("materials.create")); ?>">➕ Nuevo Material</a>
        <a href="<?php echo e(route("materials.import.form")); ?>">📤 Importar</a>
        
        <?php if(session("success")): ?>
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ <?php echo e(session("success")); ?></div>
        <?php endif; ?>
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="<?php echo e(route('materials.index')); ?>" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="<?php echo e(request('search')); ?>" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('materials.index')); ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>
        <?php if(request('search')): ?>
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            Resultados para: <strong>"<?php echo e(request('search')); ?>"</strong> - <?php echo e($materials->total()); ?> encontrados
            </div>
        <?php endif; ?>



        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($material->code); ?></td>
                    <td><?php echo e($material->name); ?></td>
                    <td><?php echo e($material->unit); ?></td>
                    <td>$<?php echo e(number_format($material->price, 2)); ?></td>
                    <td><?php echo e($material->termino ?? "-"); ?></td>
                    <td>
                        <a href="<?php echo e(route("materials.edit", $material->id)); ?>">✏️ Editar</a>
                        <form action="<?php echo e(route("materials.destroy", $material->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("DELETE"); ?>
                            <button type="submit" onclick="return confirm(\"¿Eliminar este material?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="pagination-container" style="margin-top: 20px; text-align: center;">
            <?php echo e($materials->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>' > resources\views\materials\index.blade.php
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/materials/index.blade.php ENDPATH**/ ?>