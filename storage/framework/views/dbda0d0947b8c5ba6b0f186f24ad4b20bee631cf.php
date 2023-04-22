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
    New Village
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bage-header'); ?>
    New Village
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo e(route('villages.index')); ?>" class="btn btn-primary">Back</a>
                </div>
                <form method="POST" action="<?php echo e(route('villages.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div id="">
                            <div class="row ">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Area: <span class="tx-danger">*</span></label>
                                    <select name="area_id" id="area"
                                        class="form-control select2-single text-capitalize" required>
                                        <option selected hidden disabled>Choose Area</option>
                                        <?php $__currentLoopData = App\Models\Area::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id); ?>"><?php echo e($area->area_name); ?></option>
                                            <hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Village Name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="village" name="village_name"
                                        placeholder="Enter Village Name" required="" type="text">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 m-auto">
                                    <label class="form-control-label">Delivery Cost: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="delivery_cost" name="delivery_cost"
                                        placeholder="Enter Deliver Cost" required="" type="number">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md col-lg text-center">
                                    <button class="btn btn-success">Submit</button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /storage/ssd1/003/20002003/resources/views/villages/create.blade.php ENDPATH**/ ?>