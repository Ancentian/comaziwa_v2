<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            
            <?php if(session('is_admin') == 1 && optional(auth()->guard('employee')->user())->is_admin_configured == 1): ?>
                <h3 class="page-title">Welcome <?php echo e(optional(auth()->guard('employee')->user())->name); ?>!</h3>
            <?php else: ?>
                <h3 class="page-title">Welcome <?php echo e(auth()->user()->name); ?>!</h3>
            <?php endif; ?>

            
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                <div class="dash-widget-info">
                    <h3><?php echo e(App\Models\Employee::where('tenant_id',auth()->user()->id)->count()); ?></h3>
                    <span>Employees</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                <div class="dash-widget-info">
                    <h3><?php echo e(App\Models\Project::where('tenant_id',auth()->user()->id)->count()); ?></h3>
                    <span>Projects</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                <div class="dash-widget-info">
                    <h3><?php echo e(App\Models\Farmer::where('tenant_id',auth()->user()->id)->count()); ?></h3>
                    <span>Farmers</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                <div class="dash-widget-info">
                    <h3><?php echo e(App\Models\Leave::where('tenant_id',auth()->user()->id)->where('status',0)->count()); ?></h3>
                    <span>Pending Leaves</span>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
    use Carbon\Carbon;
    if(session('is_admin') == 1)
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    }else{
        $tenant_id = auth()->user()->id;
    }

    $todays = App\Models\Expense::whereDate('created_at',date('Y-m-d'))->where('tenant_id', $tenant_id)->count();
    $monthly = App\Models\Expense::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->where('tenant_id', $tenant_id)->count();
    $annually = App\Models\Expense::whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->where('tenant_id', $tenant_id)->count();
    $pending_requests = App\Models\Expense::where('approval_status', '=', 0)->whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->where('tenant_id', $tenant_id)->count();

    $today_requests = \App\Models\Expense::where('approval_status', '=', 1)->where('tenant_id', $tenant_id)->whereDate('created_at', '=', Carbon::today())->count();
    $monthly_requests = \App\Models\Expense::where('approval_status', '=', 2)->where('tenant_id', $tenant_id)->whereMonth('created_at', '=', Carbon::now()->month)->count();
    $yearly_requests = \App\Models\Expense::where('approval_status', '=', 2)->where('tenant_id', $tenant_id)->whereYear('created_at', '=', Carbon::now()->year)->count();
    //$pending_requests = \App\Models\Expense::where('approval_status', '=', 0)->count();
    
?>


<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Expense Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Today's Expense Requests</p>
                                <h3><?php echo e($todays); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>This Months Expense Requests</p>
                                <h3><?php echo e($monthly); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Annual Expense Requests</p>
                                <h3><?php echo e($annually); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Pending Expense Requests</p>
                                <h3><?php echo e($pending_requests); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
   $total_leaves = App\Models\Leave::count();
   $today_leaves =  $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->count() : 0;
   $month_leaves = $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->count() : 0;
   $year_leaves = $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->count() : 0;
?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-6 d-flex">
        <div class="card flex-fill dash-statistics">
            <div class="card-body">
                <h5 class="card-title">Leave Statistics</h5>
                <div class="stats-list">
                    <div class="stats-info">
                        <p>Today Leave <strong><?php echo e($today_leaves); ?> <small>/ <?php echo e($total_leaves); ?></small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($today_leaves > 0 ? ($today_leaves/$total_leaves*100) : 0); ?>%" aria-valuenow="<?php echo e($today_leaves > 0 ? ($today_leaves/$total_leaves*100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Month <strong><?php echo e($month_leaves); ?> <small>/ <?php echo e($total_leaves); ?></small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($month_leaves > 0 ? ($month_leaves/$total_leaves*100) : 0); ?>%" aria-valuenow="<?php echo e($month_leaves > 0 ? ($month_leaves/$total_leaves*100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Year <strong><?php echo e($year_leaves); ?> <small>/ <?php echo e($total_leaves); ?></small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($year_leaves > 0 ? ($year_leaves/$year_leaves*100) : 0); ?>%" aria-valuenow="<?php echo e($year_leaves > 0 ? ($year_leaves/$year_leaves*100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $projects = App\Models\Project::where('tenant_id',auth()->user()->id)->count();
        $inprogress = $projects > 0 ? App\Models\Project::where('progress','<',100)->where('tenant_id',auth()->user()->id)->count() : 0;
        $completed = $projects-$inprogress;
    ?>
    
    <div class="col-md-12 col-lg-6 col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Project Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>In Progress</p>
                                <h3><?php echo e($inprogress); ?></h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Completed</p>
                                <h3><?php echo e($completed); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-4">
                    <div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo e($completed > 0 ? ($completed/$projects*100) : 0); ?>%" aria-valuenow=" <?php echo e($completed > 0 ?($completed/$projects*100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"> <?php echo e($completed > 0 ?($completed/$projects*100) : 0); ?>%</div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($inprogress >0 ? ($inprogress/$projects*100) : 0); ?>%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="<?php echo e($inprogress >0 ? ($inprogress/$projects*100) : 0); ?>"><?php echo e($inprogress >0 ? ($inprogress/$projects*100) : 0); ?>%</div>
                </div>
                <div>
                    <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed <span class="float-right"><?php echo e($completed); ?></span></p>
                    <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress <span class="float-right"><?php echo e($inprogress); ?></span></p>
                </div>
            </div>
        </div>
    </div>


    
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/dashboard/index.blade.php ENDPATH**/ ?>