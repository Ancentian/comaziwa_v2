<?php
    $employee_id = optional(auth()->guard('employee')->user())->id;
    $completed = \App\Models\Project::where('progress',100)->where('team_leader', $employee_id)->count();
    $progress = \App\Models\Project::where('progress','<',100)->where('team_leader', $employee_id)->count();
    $total = \App\Models\Project::where('team_leader', $employee_id)->count();
    $high = \App\Models\Project::where('priority','high')->where('team_leader', $employee_id)->count();
    $low = \App\Models\Project::where('priority','low')->where('team_leader', $employee_id)->count();
?>



<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Project</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card-group m-b-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Complete projects</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3"><?php echo e($completed); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($completed / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($completed / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">In progress</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3"><?php echo e($progress); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($progress / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($progress / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Low Priority</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3"><?php echo e($low); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($low / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($low / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">High Priority</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3"><?php echo e($high); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($high / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($high / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="employee_projects_table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Priority</th>
                        <th>Leader</th>
                        <th>Team</th>
                        <th>Progress(%)</th>
                        <th class="text-right notexport">Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Project Modal -->
<div id="edit_modal" class="modal custom-modal fade" role="dialog">
    
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {
        $('.progress-input').on('input', function() {
            var value = $(this).val();
            $('.progress-value').text(value + '%');
        });
    });

    <?php if(session('message')): ?>
        toastr.success('<?php echo e(session('message')); ?>', 'Success');
    <?php endif; ?>


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/companies/staff/projects/index.blade.php ENDPATH**/ ?>