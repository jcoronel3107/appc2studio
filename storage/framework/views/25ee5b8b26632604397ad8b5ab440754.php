echo '<!DOCTYPE html>
<html>
<head>
    <title>Resumen de APUs</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #28a745; color: white; }
        .btn { padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block; margin-right: 10px; }
        .total { font-weight: bold; background: #e8f4f8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Resumen de APUs</h1>
        <a href="/apus" class="btn">← Ver listado completo</a>
        <a href="/importar" class="btn" style="background:#28a745">➕ Importar nuevo</a>
        <a href="<?php echo e(route('export.apus')); ?>" class="btn" style="background:#17a2b8">📥 Exportar resumen</a>
        <table>
            <thead>
                <tr><th>Código</th><th>Rubro</th><th>Costo Total</th><th>Items</th><th>Fecha</th></tr>
            </thead>
            <tbody>
                <?php $totalGeneral = 0; ?>
                <?php $__currentLoopData = $apus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($apu->code); ?></strong></td>
                    <td><?php echo e(Str::limit($apu->name, 40)); ?></td>
                    <td>$ <?php echo e(number_format($apu->total_cost ?? 0, 2)); ?></td>
                    <td><?php echo e($apu->items->count()); ?></td>
                    <td><?php echo e($apu->created_at->format("d/m/Y")); ?></td>
                </tr>
                <?php $totalGeneral += ($apu->total_cost ?? 0); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr class="total">
                    <td colspan="2"><strong>TOTAL GENERAL</strong></td>
                    <td><strong>$ <?php echo e(number_format($totalGeneral, 2)); ?></strong></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>' > resources\views\apus\summary.blade.php<?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/apus/summary.blade.php ENDPATH**/ ?>