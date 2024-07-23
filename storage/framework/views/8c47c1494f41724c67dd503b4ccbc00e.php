<?php
$tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
$employee_id = optional(auth()->guard('employee')->user())->id;
$pending = \App\Models\Leave::where('status', 0)->where('employee_id', $employee_id)->count();
$approved = \App\Models\Leave::where('status','=',1)->where('employee_id', $employee_id)->count();
$declined = \App\Models\Leave::where('status','=',2)->where('employee_id', $employee_id)->count();
$total = \App\Models\Leave::where('employee_id', $employee_id)->count();

$leave_types = \App\Models\LeaveType::where('tenant_id',$tenant_id)->get();

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
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_emp_leave"><i class="fa fa-plus"></i> Request Leave</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Leave Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="stats-info">
            <h6>Approved Leaves</h6>
            <h4><?php echo e($approved); ?><span></span></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <h6>Pending Requests</h6>
            <h4><?php echo e($pending); ?> <span></span></h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <h6>Declined Requests</h6>
            <h4><?php echo e($declined); ?></h4>
        </div>
    </div>
</div>
<!-- /Leave Statistics -->

<!-- Leave Statistics -->
<div class="row">
    <div class="col-md-4">
        <div class="stats-info">
            <h4> <span>Total Days</span></h4>
            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['total']); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <h4> <span>Days Taken</span></h4>
            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['taken']); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <h4> <span>Days Remaining</span></h4>
            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <strong><?php echo e($one->type_name); ?></strong>: <?php echo e(\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['balance']); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    
</div>
<!-- /Leave Statistics -->

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Date Range <span class="text-danger">*</span></label>
            <input type="text" readonly id="daterange" class="form-control" value="<?php echo e(date('m/01/Y')); ?> - <?php echo e(date('m/t/Y')); ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Leave Type </label>
            <select class="select" id="leave_type">
                <option value="">Leave Type</option>
                <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key->id); ?>"><?php echo e($key->type_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Approval Status </label>
            <select class="select" id="status">
                <option value="">Select Leave Type</option>
                <option value="0">Pending</option>
                <option value="1">Approved</option>
                <option value="2">Declined</option>
            </select>
        </div>
    </div>
    
    
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="emp_leaves_table">
                <thead>
                    <tr>
                        
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        
                        <th>Status</th>
                        
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Add Leave Modal -->
<div id="add_emp_leave" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Leave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_emp_leave_form">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="employee_id" value="<?php echo e($employee_id); ?>" hidden>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Leave Type <span class="text-danger">*</span></label>
                                <select class="select" name="type" id="type" required>
                                    <option>Select Leave Type</option>
                                    <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($one->id); ?>"><?php echo e($one->type_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supervisor </label>
                                <select class="select" name="supervisor_id" required>
                                    <option>Select Supervisor</option>
                                    <?php $__currentLoopData = $supervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="date_from" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="date_to" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remaining Days <span class="text-danger">*</span></label>
                                <input class="form-control" name="remaining_days" id="days" readonly value="0" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Leave Reason <span class="text-danger">*</span></label>
                        <textarea rows="3" class="form-control" name="reasons"></textarea>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Leave Modal -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {
        // Add event listener to the template select element
        $('#employee_id,#type').on('change', function() {
            var employeeId = "<?php echo e($employee_id); ?>";
            $(".submit-btn").attr('disabled',true);
            
            $.ajax({
                url: '/leaves/remaining-days/' + employeeId,
                method: 'GET',
                data: {leave_type : $("#type").val()},
                success: function(response) {
                    // Update the input field
                    $('#days').val(response.message);
                    $(".submit-btn").attr('disabled',false);
                    //toastr.success(response.message, 'Success');
                },
                error: function(xhr, status, error) {
                    console.log(error); 
                }
            });
        });
        
        
        
        $('#date_to, #date_from').on('change', function() {
            var fromDate = new Date($('#date_from').val());
            var toDate = new Date($('#date_to').val());
            var daysDifference = Math.floor((toDate - fromDate) / (1000 * 60 * 60 * 24));
            var remainingDays = parseInt($('#days').val());
            
            if (toDate < fromDate) {
                toastr.error('To date should be greater than from date');
                return false;
            }
            
            if (daysDifference > remainingDays) {
                var message = 'Only ' + remainingDays + ' leave days are available for this selection';
                toastr.error(message);
                
                return false;
            }
        });
        
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/leaves/index.blade.php ENDPATH**/ ?>