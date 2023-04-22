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
    New User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bage-header'); ?>
    New User
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--Row -->
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-primary">Back</a>
                </div>
                <form method="POST" action="<?php echo e(route('users.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div id="">
                            <div class="row ">
                                <div class="col-md col-lg">
                                    <label class="form-control-label">First name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="firstname" name="fname" placeholder="Enter firstname"
                                        required="" type="text">
                                </div>
                                <div class="col-md col-lg mg-t-20 mg-md-t-0">
                                    <label class="form-control-label">Last name: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="lastname" name="lname" placeholder="Enter lastname"
                                        required="" type="text">
                                </div>
                                <div class="col-md col-lg mg-t-20 mg-md-t-0">
                                    <label class="form-control-label">Trade Mark name: <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" id="tm_name" name="tm_name"
                                        placeholder="Enter Trade Mark Name" required="" type="text">
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Email: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="email" name="email" placeholder="Enter Email"
                                        required="" type="email">
                                </div>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Phone: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="phone" name="phone" placeholder="Enter Phone"
                                        required="" type="number">
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Role: <span class="tx-danger">*</span></label>
                                    <select name="role_id" id="role"
                                        class="form-control select2-single text-capitalize" required>
                                        <option selected hidden disabled>Choose User Role</option>
                                        <?php $__currentLoopData = App\Models\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->role_name); ?></option>
                                            <hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md col-lg mg-t-20 mg-md-t-0">
                                    <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="password" name="password"
                                        placeholder="Enter Your Password" required="" type="password">
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Confirm Password: <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" id="confirm-password" name="confirm-password"
                                        placeholder="Confirm Password" required="" type="password">
                                </div>
                            </div>
                            <hr>
                            <div class="row ">
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Area: <span class="tx-danger">*</span></label>
                                    <select name="area_id" id="area"
                                        class="form-control select2-single text-capitalize" required>
                                        <option selected hidden disabled>Choose User Area</option>
                                        <?php $__currentLoopData = App\Models\Area::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($area->id); ?>"><?php echo e($area->area_name); ?></option>
                                            <hr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Village: <span class="tx-danger">*</span></label>
                                    <select name="village_id" id="village"
                                        class="form-control select2-single text-capitalize" required>
                                        <option selected hidden disabled>Choose User Village</option>
                                    </select>
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Street: <span class="tx-danger">*</span></label>
                                    <input class="form-control" id="street" name="street" placeholder="street"
                                        required="" type="text" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Returns Cost: <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" id="returns_cost" name="returns_cost"
                                        placeholder="Enter Returns Cost" required="" type="number">
                                </div>
                                <div class="col-md col-lg">
                                    <label class="form-control-label">Plus Delivery Cost: <span
                                            class="tx-danger">*</span></label>
                                    <input class="form-control" id="delivery_cost_discount" name="delivery_cost_discount"
                                        placeholder="Enter Delivery Cost Discount" type="number">
                                </div>
                                <div class="col-md col-lg">
                                    <div class="form-file">
                                        <label class="form-control-label">Image: </label>
                                        <input type="file" name="image" class="form-control"
                                            id="validatedInputGroupCustomFile">
                                        <label for="validatedInputGroupCustomFile"></label>
                                    </div>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /storage/ssd1/003/20002003/resources/views/users/create.blade.php ENDPATH**/ ?>