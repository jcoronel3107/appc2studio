@"
<!DOCTYPE html>
<html lang=\"<?php echo e(str_replace('_', '-', app()->getLocale())); ?>\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <meta name=\"csrf-token\" content=\"<?php echo e(csrf_token()); ?>\">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <link rel=\"preconnect\" href=\"https://fonts.bunny.net\">
    <link href=\"https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap\" rel=\"stylesheet\" />
    
    <style>.hidden { display: none; }</style>
</head>
<body class=\"font-sans antialiased\">
    <div class=\"min-h-screen bg-gray-100\">
        <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\desarrollo\appc2studio\appc2studio\resources\views/layouts/app.blade.php ENDPATH**/ ?>