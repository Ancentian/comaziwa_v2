<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Employee</a></li>
                <li class="breadcrumb-item active">Attendance</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-4">
        <div class="card punch-status">
            <div class="card-body">
                <h5 class="card-title"></h5>
                <div class="punch-info">
                    <div class="punch-hours">
                        <span id="timer"></span>
                    </div>
                </div>
                <div class="punch-btn-section">
                    <form id="attendance_form">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="tenant_id" value="<?php echo e($tenant_id); ?>" hidden>
                        <input type="text" name="employee_id" value="<?php echo e($employee_id); ?>" hidden>
                        <button type="submit" class="btn btn-primary punch-btn" id="punch_button">
                            Punch In
                        </button>
                    </form>                    
                </div>
                <div class="statistics" hidden>
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box">
                                <p>Break</p>
                                <h6>1.21 hrs</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card att-statistics">
            <div class="card-body">
                <h5 class="card-title">Statistics</h5>
                <div class="stats-list">
                    <div class="stats-info">
                        <p>Today <strong><?php echo e(number_format($attendance_summary['days'], 2)); ?><small>/8 hrs</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e(ceil($attendance_summary['days'] / 8 * 100)); ?>%" aria-valuenow="<?php echo e(ceil($attendance_summary['days'] / 8 * 100)); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Week <strong><?php echo e(number_format($attendance_summary['weeks'], 2)); ?> <small>/ 40 hrs</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e(ceil($attendance_summary['weeks'] / 40 * 100)); ?>%" aria-valuenow="<?php echo e(ceil($attendance_summary['weeks'] / 40 * 100)); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Month <strong><?php echo e(number_format($attendance_summary['months'], 2)); ?> <small>/ 160 hrs</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e(ceil($attendance_summary['months'] / 160 * 100)); ?>%" aria-valuenow="<?php echo e(ceil($attendance_summary['months'] / 160 * 100)); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card recent-activity">
            <div class="card-body">
                <h5 class="card-title">Today Activity</h5>
                <ul class="res-activity-list">
                    <?php $__currentLoopData = $attendance_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <p class="mb-0">
                            <?php

                                switch($one['type']) {
                                    case 'punch_in':
                                        echo "Punch In At";
                                        break;
                                    case 'punch_out':
                                        echo "Punch Out At";
                                        break;
                                }   

                            ?>
                        </p>
                        <p class="res-activity-time">
                            <i class="fa fa-clock-o"></i>
                            <?php echo e(date('H:i:s',strtotime($one['time']))); ?>

                        </p>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="employee_attendance_table">
                <thead>
                    <tr>
                        <th>Date </th>
                        <th>Punch In</th>
                        <th>Punch Out</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/attendance/index.blade.php ENDPATH**/ ?>