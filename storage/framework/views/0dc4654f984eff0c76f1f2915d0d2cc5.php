<?php
    if(session('is_admin') == 1)
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    }else{
        $tenant_id = auth()->user()->id;
    }
    $pending = \App\Models\Leave::where('status', 0)->where('tenant_id', $tenant_id)->count();
    $approved = \App\Models\Leave::where('status', 1)->where('tenant_id', $tenant_id)->count();
    $declined = \App\Models\Leave::where('status', 2)->where('tenant_id', $tenant_id)->count();
    $total = \App\Models\Leave::where('tenant_id', $tenant_id)->count();

?>


<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Employee</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<!-- Leave Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Total Requests</h6>
            <h4><?php echo e($total); ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Approved Leaves</h6>
            <h4><?php echo e($approved); ?><span></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Pending Requests</h6>
            <h4><?php echo e($pending); ?> <span></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Declined Requests</h6>
            <h4><?php echo e($declined); ?></h4>
        </div>
    </div>
</div>
<!-- /Leave Statistics -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="leaves_table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Total Leave Days</th>
                        <th>Days Taken</th>
                        <th>Remaining Leave Days.</th>
                        <th class="notexport">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/employees/leaves/index.blade.php ENDPATH**/ ?>