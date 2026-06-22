echo '

<?php $__env->startSection("content"); ?>
<div style="padding: 20px;">
    <div style="background: white; border-radius: 8px; padding: 20px; max-width: 800px; margin: 0 auto;">
        <h1 style="margin: 0 0 20px 0;">✏️ Editar Cliente: <?php echo e($tenant->name); ?></h1>
        
        <form method="POST" action="<?php echo e(route("admin.tenants.update", $tenant->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field("PUT"); ?>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nombre de la Empresa:</label>
                <input type="text" name="name" value="<?php echo e(old("name", $tenant->name)); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <?php $__errorArgs = ["name"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: #ef4444; font-size: 12px;"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Subdominio:</label>
                <div style="display: flex; align-items: center;">
                    <input type="text" name="subdomain" value="<?php echo e(old("subdomain", $tenant->subdomain)); ?>" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;" readonly>
                    <span style="margin-left: 10px; color: #6c757d;">.localhost:8000</span>
                </div>
                <small style="color: #6c757d;">El subdominio no se puede modificar después de la creación.</small>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email del Administrador:</label>
                <input type="email" name="email" value="<?php echo e(old("email", $tenant->email)); ?>" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                <?php $__errorArgs = ["email"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: #ef4444; font-size: 12px;"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Teléfono:</label>
                <input type="text" name="phone" value="<?php echo e(old("phone", $tenant->phone)); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Plan:</label>
                <select name="plan" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="free" <?php echo e(old("plan", $tenant->plan) == "free" ? "selected" : ""); ?>>Gratis</option>
                    <option value="pro" <?php echo e(old("plan", $tenant->plan) == "pro" ? "selected" : ""); ?>>Pro - $49/mes</option>
                    <option value="enterprise" <?php echo e(old("plan", $tenant->plan) == "enterprise" ? "selected" : ""); ?>>Enterprise - $99/mes</option>
                </select>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old("is_active", $tenant->is_active) ? "checked" : ""); ?> style="margin-right: 8px;">
                    Activo
                </label>
            </div>
            
            <div style="display: flex; gap: 15px; margin-top: 20px;">
                <button type="submit" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; cursor: pointer; border-radius: 4px;">💾 Actualizar Cliente</button>
                <a href="<?php echo e(route("admin.tenants.index")); ?>" style="background: #6c757d; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>' > resources\views\admin\tenants\edit.blade.php
<?php echo $__env->make("layouts.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Desarrollo\app2sintent\appc2studio\resources\views/admin/tenants/edit.blade.php ENDPATH**/ ?>