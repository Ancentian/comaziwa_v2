<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Welcome <?php echo e(auth()->user()->name); ?>!</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<?php
    use Carbon\Carbon;

    $employees = App\Models\Employee::count();
    $expired = App\Models\User::whereDate('expiry_date','<',date('Y-m-d'))->count();
    $active = App\Models\User::whereDate('expiry_date','>=',date('Y-m-d'))->count();
    $clients = App\Models\User::where('type','client')->count();

    $currentWeek = Carbon::now()->week;
    $weeks = App\Models\Subscription::whereRaw('YEARWEEK(created_at) = YEARWEEK(CURRENT_DATE())')
    ->sum('amount_paid');
    $todays = App\Models\Subscription::whereDate('created_at',date('Y-m-d'))->sum('amount_paid');
    $months = App\Models\Subscription::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->sum('amount_paid');
    $annual = App\Models\Subscription::whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->sum('amount_paid');
?>

<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Today's Income</h6>
            <h4><span>GHS <?php echo e(number_format($todays, 2, '.', ',')); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Week's Income</h6>
            <h4><span>GHS <?php echo e(number_format($weeks, 2, '.', ',')); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Month's Income</h6>
            <h4> <span>GHS <?php echo e(number_format($months, 2, '.', ',')); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Annual Income</h6>
            <h4><span>GHS <?php echo e(number_format($annual, 2, '.', ',')); ?></span></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Total Clients</h6>
            <h4><span><?php echo e(round(number_format($clients, 2, '.', ','))); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Active Subscriptions</h6>
            <h4><span><?php echo e(round(number_format($active, 2, '.', ','))); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Expired Subscriptions</h6>
            <h4> <span><?php echo e(round(number_format($expired, 2, '.', ','))); ?></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Total Employees</h6>
            <h4><span><?php echo e(round(number_format($employees, 2, '.', ','))); ?></span></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Packages Revenue</h3>
                        <div id="bar-charts"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$(document).ready(function() {

   
	
	Morris.Bar({
		element: 'bar-charts',
		data: [
			JSON.parse('<?php echo $tddata; ?>'),
            JSON.parse('<?php echo $wkdata; ?>'),
            JSON.parse('<?php echo $mndata; ?>'),
            JSON.parse('<?php echo $yrdata; ?>')
            
		],
		xkey: 'y',
		ykeys: <?php echo e($ykeys); ?>,
		labels: <?php echo $package_names; ?> ,
		lineColors: ['#f43b48', '#453a94', '#3a9445', '#94453a', '#453a94', '#3a9445', '#94453a', '#453a94', '#3a9445', '#94453a'],
		lineWidth: '3px',
		barColors: ['#f43b48', '#453a94', '#3a9445', '#94453a', '#453a94', '#3a9445', '#94453a', '#453a94', '#3a9445', '#94453a'],
		resize: true,
		redraw: true
	});
	
	
		
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>