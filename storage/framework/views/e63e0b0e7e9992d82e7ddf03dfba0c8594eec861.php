<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Clients</h6>
                                <h2 class="mb-0 number-font"><?php echo e(App\Models\User::where('role_id', 2)->count()); ?></h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Open Invoices</h6>
                                <h2 class="mb-0 number-font"><?php echo e(App\Models\Invoice::count()); ?></h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="leadschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Drivers</h6>
                                <h2 class="mb-0 number-font"><?php echo e(App\Models\User::where('role_id', 3)->count()); ?></h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="profitchart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $__currentLoopData = App\Models\Office::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $office): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mt-2">
                                    <h6 class=""><?php echo e($office->office_name); ?></h6>
                                    <h2 class="mb-0 number-font"><?php echo e($office->budget); ?> <i class="fas fa-shekel-sign"></i></h2>
                                </div>
                                <div class="ms-auto">
                                    <div class="chart-wrapper mt-1">
                                        <canvas id="leadschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
        </div>
    </div>
</div>
<!-- ROW-1 END -->
<?php /**PATH /storage/ssd1/003/20002003/resources/views/layouts/cards.blade.php ENDPATH**/ ?>