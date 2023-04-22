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
    تحديث بيانات المكتب
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bage-header'); ?>
        تحديث بيانات المكتب
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo e(route('offices.index')); ?>" class="btn btn-primary">الرجوع</a>
                </div>
                <form method="POST" action="<?php echo e(route('offices.update',$office->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div id="">
                            <div class="row">
                                <div class="form-floating mb-3">
                                    <input type="text" name="office_name" class="form-control" id="floatingInput"
                                        placeholder="name@example.com" value="<?php echo e($office->office_name); ?>">
                                    <label for="floatingInput">المكتب</label>
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-floating">
                                    <input type="office_phone" name="office_phone" class="form-control" id="floatingPassword"
                                        placeholder="Password" value="<?php echo e($office->office_phone); ?>">
                                    <label for="floatingPassword">رقم تليفون المكتب</label>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md col-lg text-center">
                                    <button class="btn btn-success">حفظ</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!--/Row-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /storage/ssd1/003/20002003/resources/views/offices/edit.blade.php ENDPATH**/ ?>