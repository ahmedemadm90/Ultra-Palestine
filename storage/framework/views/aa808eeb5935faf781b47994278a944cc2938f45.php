<?php if($errors->any()): ?>
<div class="alert alert-danger m-2" id="errors">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="mb-0 text-capitalize inline"><?php echo e($err); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php /**PATH /storage/ssd1/003/20002003/resources/views/layouts/errors.blade.php ENDPATH**/ ?>