<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Subscriptions</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn renew_subscription"><i class="fa fa-plus"></i> Renew Subscription</a>
        </div>
    </div>
</div>
<!-- /Page Header -->
<?php
    
?>

<div class="row">
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Current Package:</strong> <?php echo e($packages->name); ?></span><br>
            <span><strong>Monthly Price:</strong> <?php echo e(number_format($packages->price, 2, '.', ',')); ?></span><br>
            <span><strong>Annual Price:</strong> <?php echo e(number_format($packages->annual_price, 2, '.', ',')); ?></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Maxumum Staff:</strong> <?php echo e($packages->staff_no); ?></span><br>
            <span><strong>Current Staff:</strong> <?php echo e(\App\Models\Employee::where('tenant_id',auth()->user()->id)->count()); ?></span><br>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Expires on:</strong> <?php if($packages->is_system == 1): ?> <span class="badge bg-success">Free Forever</span> <?php else: ?> <?php echo e(date('d/m/Y H:i',strtotime(auth()->user()->expiry_date))); ?> <?php endif; ?> </span><br>
            <?php if($packages->is_system != 1): ?><span><strong>Days remaining: </strong> <?php echo e(ceil((strtotime(auth()->user()->expiry_date)-time()) / 86400 )); ?></span><?php endif; ?><br>
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="my_subscriptions_table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Period Paid For</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php

$package = \App\Models\Package::find(auth()->user()->package_id);
$pp = !empty($package) ?  $package->price : 0;

?>

<script src="https://js.paystack.co/v1/inline.js"></script>
<?php if(!auth()->user()->package_id && auth()->user()->type == 'client'  && empty($tenant_id)): ?>
<?php if($pp > 0): ?>
    <script>
        $(document).ready(function() {
            $('#welcome_modal').on('show.bs.modal', function(e) {
                $(this).data('bs.modal')._config.backdrop = 'static';
                $(this).data('bs.modal')._config.keyboard = false;
            });

            $('#welcome_modal').modal('show');
        });
    </script>
<?php endif; ?>

<?php endif; ?>

<?php if((strtotime(auth()->user()->expiry_date) - time()) <= 0 && auth()->user()->type == 'client'  && empty($tenant_id)): ?>
<?php if($pp > 0): ?>
<script>
    $(document).ready(function() {
        $('#renew_modal').on('show.bs.modal', function(e) {
            $(this).data('bs.modal')._config.backdrop = 'static';
            $(this).data('bs.modal')._config.keyboard = false;
        });

        $('#renew_modal').modal('show');
    });
</script>
<?php endif; ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/dashboard/subscriptions.blade.php ENDPATH**/ ?>