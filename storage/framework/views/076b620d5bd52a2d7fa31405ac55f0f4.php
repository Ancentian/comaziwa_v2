<?php
    $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
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
                <li class="breadcrumb-item active">Leaves Summary</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_leave"><i class="fa fa-plus"></i> Add Leave</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Leave Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Total Requests</h6>
            <h4><?php echo e(number_format($total)); ?></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Approved Leaves</h6>
            <h4><?php echo e(number_format($approved)); ?><span></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Pending Requests</h6>
            <h4><?php echo e(number_format($pending)); ?> <span></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Declined Requests</h6>
            <h4><?php echo e(number_format($declined)); ?></h4>
        </div>
    </div>
</div>
<!-- /Leave Statistics -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="staff_leaves_table">
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

<!-- Add Leave Modal -->
<div id="add_leave" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Leave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_leave_form">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Employee <span class="text-danger">*</span></label>
                        <select class="select" id="employee_id" name="employee_id">
                            <option>Select Employee</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Leave Type <span class="text-danger">*</span></label>
                        <select class="select" name="type" id="type" required>
                            <option>Select Leave Type</option>
                            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($one->id); ?>"><?php echo e($one->type_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>From <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="date_from" id="date_from" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>To <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="date_to" id="date_to" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Remaining Leaves <span class="text-danger">*</span></label>
                        <input class="form-control" id="days" name="remaining_days" readonly value="0" type="text">
                    </div>
                    <div class="form-group">
                        <label>Leave Reason <span class="text-danger">*</span></label>
                        <textarea rows="4" class="form-control" name="reasons"></textarea>
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
      var employeeId = $("#employee_id").val();
        $(".submit-btn").attr('disabled',true);
        
      $.ajax({
        url: '/leaves/remaining-days/' + employeeId,
        method: 'GET',
        data: {leave_type : $("#type").val()},
        success: function(response) {
          // Update the input field
          $('#days').val(response.message);
          $(".submit-btn").attr('disabled',false);
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


<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/companies/staff/leaves/allLeaves.blade.php ENDPATH**/ ?>