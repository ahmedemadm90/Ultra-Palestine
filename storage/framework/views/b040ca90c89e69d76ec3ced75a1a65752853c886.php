<?php if($errors->any()): ?>
<div class="alert alert-danger m-2" id="errors">
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="mb-0 text-capitalize inline"><?php echo e($err); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php /**PATH /home/u447710865/domains/jaberandrabiacompanyforlogistics.com/resources/views/layouts/errors.blade.php ENDPATH**/ ?>