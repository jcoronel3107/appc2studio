<?php $__env->startSection('content'); ?>
<div style="padding: 30px;">
    <div style="max-width: 1200px; margin: 0 auto; background: white; border-radius: 8px; padding: 20px;">
        <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 16px;">📊 Dashboard de APUs</h2>
        <p style="margin-bottom: 24px;">Bienvenido, <?php echo e(Auth::user()->name ?? 'Usuario'); ?>!</p>
        
        <?php
            $totalApus = App\Models\AnalysisHeader::count();
            $totalCost = App\Models\AnalysisHeader::sum('total_cost');
            $totalItems = App\Models\AnalysisItem::count();
            $ultimoApu = App\Models\AnalysisHeader::latest()->first();
        ?>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
            <div style="background: #e0f2fe; padding: 16px; border-radius: 8px; text-align: center;">
                <h3 style="font-weight: bold;">Total APUs</h3>
                <p style="font-size: 30px; font-weight: bold; color: #0284c7;"><?php echo e($totalApus); ?></p>
            </div>
            <div style="background: #dcfce7; padding: 16px; border-radius: 8px; text-align: center;">
                <h3 style="font-weight: bold;">Costo Total</h3>
                <p style="font-size: 30px; font-weight: bold; color: #16a34a;">$<?php echo e(number_format($totalCost, 2)); ?></p>
            </div>
            <div style="background: #fef9c3; padding: 16px; border-radius: 8px; text-align: center;">
                <h3 style="font-weight: bold;">Total Items</h3>
                <p style="font-size: 30px; font-weight: bold; color: #ca8a04;"><?php echo e($totalItems); ?></p>
            </div>
        </div>
        
        <?php if($ultimoApu): ?>
        <div style="background: #f3f4f6; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
            <h3 style="font-weight: bold; margin-bottom: 8px;">📄 Último APU Importado</h3>
            <p><strong>Código:</strong> <?php echo e($ultimoApu->code); ?></p>
            <p><strong>Rubro:</strong> <?php echo e(Str::limit($ultimoApu->name, 80)); ?></p>
            <p><strong>Costo Total:</strong> $<?php echo e(number_format($ultimoApu->total_cost ?? 0, 2)); ?></p>
            <a href="/apu/<?php echo e($ultimoApu->id); ?>" style="display: inline-block; margin-top: 8px; background: #3b82f6; color: white; padding: 4px 12px; border-radius: 4px; text-decoration: none;">Ver detalles →</a>
        </div>
        <?php endif; ?>
        
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="/apus" style="background: #3b82f6; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Ver APUs</a>
            <a href="/importar" style="background: #22c55e; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Importar APU</a>
            <a href="/apu-summary" style="background: #eab308; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Resumen de Totales</a>
            <a href="/exportar-apus" style="background: #a855f7; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Exportar Resumen</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/dashboard.blade.php ENDPATH**/ ?>