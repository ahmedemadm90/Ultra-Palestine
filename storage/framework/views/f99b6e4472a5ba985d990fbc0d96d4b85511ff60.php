
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
    الحركات المالية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('bage-header'); ?>
    الحركات المالية
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.sessions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">القائم بالعملية</th>
                                                <th class="border-bottom-0">نوع العملية</th>
                                                <th class="border-bottom-0">الي</th>
                                                <th class="border-bottom-0">قيمة العملية</th>
                                                <th class="border-bottom-0">قيمة الصندوق قبل العملية</th>
                                                <th class="border-bottom-0">قيمة الصندوق بعد العملية</th>
                                                <th class="border-bottom-0">الاعدادات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = App\Models\Transaction::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $move): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($move->from); ?></td>
                                                    <td>
                                                        <?php if($move->new_budget < $move->old_budget): ?>
                                                            <span class="badge bg-danger text-light">عملية دفع</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-success text-light">عملية تحصيل</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($move->to); ?></td>

                                                    <td><?php echo e($move->old_budget - $move->new_budget); ?></td>
                                                    <td><?php echo e($move->old_budget); ?></td>
                                                    <td><?php echo e($move->new_budget); ?></td>
                                                    <td><?php echo e($move->details); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u447710865/domains/jaberandrabiacompanyforlogistics.com/resources/views/transactions/index.blade.php ENDPATH**/ ?>