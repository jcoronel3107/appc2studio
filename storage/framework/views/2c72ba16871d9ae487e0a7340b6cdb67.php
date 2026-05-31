echo '

<?php $__env->startSection("content"); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px;">
        <h1>👷 Mano de Obra</h1>
        <a href="<?php echo e(route("labors.create")); ?>">➕ Nuevo Registro</a>
        <a href="<?php echo e(route("labors.import.form")); ?>">📤 Importar</a>
        <a href="<?php echo e(route("labors.export")); ?>">💾 Exportar</a>
        
        <?php if(session("success")): ?>
            <div style="background: #d4edda; padding: 10px; margin: 10px 0;">✅ <?php echo e(session("success")); ?></div>
        <?php endif; ?>
        <!-- Buscador -->
        <div style="margin: 20px 0; display: flex; gap: 10px;">
            <form method="GET" action="<?php echo e(route('labors.index')); ?>" style="flex: 1; display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="🔍 Buscar por nombre..." value="<?php echo e(request('search')); ?>" style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                <?php if(request('search')): ?>
                    <a href="<?php echo e(route('labors.index')); ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>

        <?php if(request('search')): ?>
            <div style="background: #e0f2fe; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
                Resultados para: <strong>"<?php echo e(request('search')); ?>"</strong> - <?php echo e($labors->total()); ?> encontrados
            </div>
        <?php endif; ?>



        <table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Unidad</th>
                    <th>Tarifa/Hora</th>
                    <th>Término</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $labors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($labor->code); ?></td>
                    <td><?php echo e($labor->name); ?></td>
                    <td><?php echo e($labor->category ?? "-"); ?></td>
                    <td><?php echo e($labor->unit); ?></td>
                    <td>$<?php echo e(number_format($labor->hourly_rate, 2)); ?></td>
                    <td><?php echo e($labor->termino ?? "-"); ?></td>
                    <td>
                        <a href="<?php echo e(route("labors.edit", $labor->id)); ?>">✏️ Editar</a>
                        <form action="<?php echo e(route("labors.destroy", $labor->id)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field("DELETE"); ?>
                            <button type="submit" onclick="return confirm(\"¿Eliminar?\")">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="pagination-container" style="margin-top: 20px; text-align: center;">
            <?php echo e($labors->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>' > resources\views\labors\index.blade.php
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/labors/index.blade.php ENDPATH**/ ?>