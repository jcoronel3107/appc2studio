<div style="display: flex; align-items: center; gap: 20px;">
    <a href="<?php echo e(route('dashboard')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
    🏠 Dashboard
    </a>
    S<span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('apus.index')); ?>" style="color: #4b5563; text-decoration: none;">📋 APUs</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('materials.index')); ?>" style="color: #4b5563; text-decoration: none;">📦 Materiales</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('equipments.index')); ?>" style="color: #4b5563; text-decoration: none;">🖥️ Equipos</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('labors.index')); ?>" style="color: #4b5563; text-decoration: none;">👷 Mano de Obra</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(url('/importar')); ?>" style="color: #4b5563; text-decoration: none;">📤 Importar APU</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('apus.summary')); ?>" style="color: #4b5563; text-decoration: none;">📊 Resumen</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('export.apus')); ?>" style="color: #4b5563; text-decoration: none;">💾 Exportar</a>
    <span style="color: #ccc;">|</span>
    <a href="<?php echo e(route('apus.create')); ?>" style="color: #4b5563; text-decoration: none;">➕ Nuevo APU</a>
    <span style="color: #ccc;">|</span>
    <!-- Menú de usuario -->
    <div style="position: relative;">
        <button onclick="toggleMenu()" style="background: none; border: none; cursor: pointer; color: #555;">
            👤 <?php echo e(Auth::user()->name ?? 'Usuario'); ?> ▼
        </button>
        <div id="user-menu" style="display: none; position: absolute; right: 0; top: 30px; background: white; border: 1px solid #ccc; border-radius: 5px; min-width: 120px;">
            <a href="<?php echo e(route('profile.edit')); ?>" style="display: block; padding: 8px 12px; color: #333; text-decoration: none;">⚙️ Perfil</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" style="display: block; width: 100%; text-align: left; padding: 8px 12px; color: #d33; background: none; border: none; cursor: pointer;">
                    🚪 Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>