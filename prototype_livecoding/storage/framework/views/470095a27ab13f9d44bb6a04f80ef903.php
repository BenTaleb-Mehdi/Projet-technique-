

<?php $__env->startSection('content'); ?>

    <div class="w-full">
        <?php echo $__env->make('admin.partials.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.partials.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\GitHub\Projet technique\Projet-technique-\prototype_livecoding\resources\views/admin/index.blade.php ENDPATH**/ ?>