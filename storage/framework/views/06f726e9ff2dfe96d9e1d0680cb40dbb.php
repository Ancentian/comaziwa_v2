<?php
    $pending = \App\Models\Leave::where('status', '=',0)->where('employee_id',$employee_id)->count();
    $approved = \App\Models\Leave::where('status','=',1)->where('employee_id',$employee_id)->count();
    $declined = \App\Models\Leave::where('status','=',2)->where('employee_id',$employee_id)->count();
    $total = \App\Models\Leave::where('employee_id',$employee_id)->count();

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

<!-- Leave Statistics -->
<div class="row">
    <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="stats-info">
                <h6><?php echo e($one->type_name); ?></h6>
                <h4><?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays($employee_id,$one->id)['taken']); ?><span> Days</span></h4>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
</div>
<!-- /Leave Statistics -->

<input type="hidden" value="<?php echo e($employee_id); ?>" id="employee_leaves_id">

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="employee_leaves_table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
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
<script>
    leaves_table = $('#employee_leaves_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('leaves/employeeLeaves',$employee_id)); ?>",
                data: function(d){
                    
                }
            }, 
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'employeeName', name: 'employeeName'},
                {data: 'type', name: 'type'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_to', name: 'date_to'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action',className: 'text-right'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/employees/leaves/employee_leaves.blade.php ENDPATH**/ ?>