<?php $__env->startSection('navbar'); ?>
    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    User Information
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bage-header'); ?>
    About User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    <?php if($user->role->role_name == 'admin'): ?>
                        hi admin
                    <?php endif; ?>
                    <?php if($user->role->role_name == 'client'): ?>
                        hi client
                    <?php endif; ?>
                    <?php if($user->role->role_name == 'driver'): ?>
                        hi driver
                    <?php endif; ?>

                    <?php if($user->role->role_name == 'employee'): ?>
                        hi employee
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /storage/ssd1/003/20002003/resources/views/users/show.blade.php ENDPATH**/ ?>