<nav style="background: white; border-bottom: 1px solid #e5e7eb; padding: 0 20px;">
    <div style="max-width: 1280px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; height: 64px;">
        <!-- Logo -->
        <div style="display: flex; align-items: center;">
            <a href="<?php echo e(route('dashboard')); ?>" style="font-weight: bold; font-size: 20px; color: #1f2937; text-decoration: none;">
                📊 APU System
            </a>
        </div>
        
        <!-- Menú principal -->
        <div style="display: flex; align-items: center; gap: 24px;">
            <?php if(auth()->guard()->check()): ?>
                <!-- Menú para ADMIN (sin subdominio) -->
                <?php if(Auth::user()->is_admin): ?>
                    <a href="<?php echo e(route('apus.index')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📋 APUs
                    </a>
                    <a href="<?php echo e(url('/importar')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📤 Importar
                    </a>
                    <a href="<?php echo e(route('apus.summary')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📊 Resumen
                    </a>
                    <a href="<?php echo e(route('export.apus')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        💾 Exportar
                    </a>
                    
                    <!-- Separador -->
                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                    
                    <!-- PRESUPUESTOS para ADMIN -->
                    <a href="<?php echo e(route('budgets.index')); ?>" style="color: #8b5cf6; text-decoration: none; padding: 8px 0;">
                        📋 Presupuestos
                    </a>
                    <a href="<?php echo e(route('budgets.create-chapter')); ?>" style="color: #22c55e; text-decoration: none; padding: 8px 0;">
                        📝 Nuevo Presupuesto
                    </a>
                    
                    <!-- Separador -->
                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                    
                    <!-- Clientes (solo admin) -->
                    <a href="<?php echo e(route('admin.tenants.index')); ?>" style="color: #8b5cf6; text-decoration: none; padding: 8px 0;">
                        🏢 Clientes
                    </a>
                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                <?php else: ?>
                    <!-- Menú para TENANT (con subdominio) -->
                    <a href="<?php echo e(route('tenant.apus.index')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📋 APUs
                    </a>
                    <a href="<?php echo e(route('tenant.importar')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📤 Importar
                    </a>
                    <a href="<?php echo e(route('tenant.apus.summary')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        📊 Resumen
                    </a>
                    <a href="<?php echo e(route('tenant.export.apus')); ?>" style="color: #4b5563; text-decoration: none; padding: 8px 0;">
                        💾 Exportar
                    </a>
                    
                    <!-- Separador -->
                    <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                    
                    <!-- PRESUPUESTOS para TENANT -->
                    <a href="<?php echo e(route('tenant.budgets.index')); ?>" style="color: #8b5cf6; text-decoration: none; padding: 8px 0;">
                        📋 Presupuestos
                    </a>
                    <a href="<?php echo e(route('tenant.budgets.create-chapter')); ?>" style="color: #22c55e; text-decoration: none; padding: 8px 0;">
                        📝 Nuevo Presupuesto
                    </a>
                <?php endif; ?>
                
                <!-- Separador -->
                <div style="width: 1px; height: 30px; background: #e5e7eb;"></div>
                
                <!-- Menú de usuario -->
                <div style="position: relative;">
                    <button onclick="toggleMenu()" style="display: flex; align-items: center; gap: 8px; background: none; border: none; cursor: pointer; color: #374151; padding: 8px; font-size: 16px;">
                        <span>👤 <?php echo e(Auth::user()->name ?? 'Usuario'); ?></span>
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="user-menu" style="display: none; position: absolute; right: 0; top: 40px; min-width: 160px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; padding: 8px 0;">
                        <a href="<?php echo e(url('/profile')); ?>" style="display: block; padding: 10px 16px; color: #374151; text-decoration: none; border-bottom: 1px solid #e5e7eb;">
                            ⚙️ Perfil
                        </a>
                        <form method="POST" action="<?php echo e(url('/logout')); ?>" style="margin: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 16px; color: #ef4444; background: none; border: none; cursor: pointer;">
                                🚪 Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" style="color: #3b82f6; text-decoration: none;">Iniciar Sesión</a>
                <a href="<?php echo e(route('register')); ?>" style="color: #22c55e; text-decoration: none;">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        var menu = document.getElementById('user-menu');
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }
    
    // Cerrar el menú al hacer clic fuera
    document.addEventListener('click', function(event) {
        var menu = document.getElementById('user-menu');
        var button = event.target.closest('button');
        if (!button || !button.textContent.includes('<?php echo e(Auth::user()->name ?? "Usuario"); ?>')) {
            if (menu) {
                menu.style.display = 'none';
            }
        }
    });
</script><?php /**PATH D:\Desarrollo\app2sintent\appc2studio\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>