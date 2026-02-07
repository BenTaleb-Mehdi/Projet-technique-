<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mini ecommerce</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

       <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js','resources/js/main.js']); ?>
</head>
<body>




<div class="flex items-center  p-20">
    <?php echo $__env->yieldContent('content'); ?>
</div>

</body>
</html>
<?php /**PATH C:\GitHub\Projet technique\Projet-technique-\prototype_livecoding\resources\views/layouts/admin.blade.php ENDPATH**/ ?>