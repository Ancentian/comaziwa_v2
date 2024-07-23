<?php
    $today = date('l, j F Y');
    logger($today);
    $employee_id = optional(auth()->guard('employee')->user())->id;
    $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

    $leave_types = \App\Models\LeaveType::where('tenant_id',$tenant_id)->get();
    $pending = \App\Models\Leave::where('status', 0)->where('employee_id', $employee_id)->count();
    
?>


<?php $__env->startSection('content'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-box">
                <div class="welcome-img">
                    <img alt="" src="<?php echo e(asset('assets/img/profiles/avatar-02.jpg')); ?>">
                </div>
                <div class="welcome-det">
                    <h3>Welcome, <?php echo e(auth()->guard('employee')->user()->name); ?>!</h3>
                    <p><?php echo e($today); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-lg-12 col-md-12">
        <section class="dash-section">
            <h4 class="card-title">Leave Statistics</h4>
            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Total Days</span></h4>
                        <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['total']); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Days Taken</span></h4>
                        <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['taken']); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Days Remaining</span></h4>
                        <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['balance']); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Pending</h6>
                        <h4> <span><?php echo e($pending); ?></span></h4>
                    </div>
                </div>
                
            </div>


        </section>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="dash-sidebar">
            <section>
                <h5 class="dash-title">Project Statistics</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Total Tasks</h6>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Pending Tasks</h6>
                            <h4></h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Total Projects</h6>
                            <h4></h4>
                        </div>
                    </div>
                </div>
                
            </section>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/index.blade.php ENDPATH**/ ?>