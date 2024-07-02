<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Employee Leave</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_leave_form"  action="<?php echo e(url('leaves/update', [$leave->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Employee <span class="text-danger">*</span></label>
                    <select class="select form-control" name="employee_id" id="employeeID">
                        <option>Select Employee</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key->id); ?>" <?php echo e($key->id === $leave->employee_id ? 'selected' : ''); ?>><?php echo e($key->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Leave Type <span class="text-danger">*</span></label>
                    <select class="select form-control" name="type" id="leaveType">
                            <?php $__currentLoopData = $leave_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>" <?php echo e($key->id == $leave->type ? 'selected' : ''); ?>><?php echo e($key->type_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>From <span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="date_from" value="<?php echo e($leave->date_from); ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label>To <span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="date_to" value="<?php echo e($leave->date_to); ?>" type="text">
                    </div>
                </div>
                <div class="form-group">
                        <label>Remaining Days <span class="text-danger">*</span></label>
                        <input class="form-control" name="remaining_days" id="rem_days" readonly value="<?php echo e($leave->remaining_days); ?>" type="text">
                    </div>
                <div class="form-group">
                    <label>Leave Reason <span class="text-danger">*</span></label>
                    <textarea rows="4" class="form-control" name="reasons"><?php echo e($leave->reasons); ?></textarea>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_leave_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                leaves_table.ajax.reload();
                $("#edit_modal").modal('hide');
            },
            error: function(xhr, status, error) {
                if (xhr.status == 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = "";
            
                        // Loop through the errors and concatenate them into a single string
                        for (var key in errors) {
                            errorMessage += errors[key].join('<br>') + '<br>';
                        }
            
                        // Display the error message in a toast
                        toastr.error(errorMessage, 'Validation Error');
                        
                        return false;
                    }
            }
        });
    });
    
    $(document).ready(function() {
    // Add event listener to the template select element
    $('#employeeID, #leaveType').on('change', function() {
      var employeeId = $("#employeeID").val();
      var type = $("#leaveType").val();
        console.log(employeeId, type);
      
        $(".submit-btn").attr('disabled',true);
        
      $.ajax({
        url: '/leaves/remaining-days/' + employeeId,
        method: 'GET',
        data: {leave_type : type},
        success: function(response) {
          // Update the input field
          $('#rem_days').val(response.message);
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
        var remainingDays = parseInt($('#rem_days').val());

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
    
    
   
    
  //});
    
</script><?php /**PATH /home/ghpayroll/base/resources/views/employees/leaves/edit.blade.php ENDPATH**/ ?>