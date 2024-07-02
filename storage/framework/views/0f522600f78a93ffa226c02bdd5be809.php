<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Employee</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_employee_form" action="<?php echo e(url('/employees/edit/'.$employee->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="<?php echo e($employee->name); ?>" required>
                        </div>
                    </div>
                   
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" value="<?php echo e($employee->email); ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">* (leave blank if no change)</span></label>
                            <input class="form-control" type="password" name="password" placeholder="(unchanged)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone No</label>
                            <input class="form-control" type="tel" name="phone_no" value="<?php echo e($employee->phone_no); ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Staff No</label>
                            <input class="form-control" type="text" name="staff_no" value="<?php echo e($employee->staff_no); ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Position</label>
                            <input class="form-control" type="text" name="position" value="<?php echo e($employee->position); ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input class="form-control" type="date" name="dob" value="<?php echo e($employee->dob); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bank</label>
                            <input class="form-control" type="text" name="bank_name" value="<?php echo e($employee->bank_name); ?>" required>
                        </div>
                    </div>
                    
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Branch Name</label>
                            <input class="form-control" type="text" name="branch_name" value="<?php echo e($employee->branch_name); ?>" required>
                        </div>
                    </div>
                    
                     <div class="col-sm-6">
                        <div class="form-group">
                            <label>Sort Code</label>
                            <input class="form-control" type="text" name="branch_shortcode" value="<?php echo e($employee->branch_shortcode); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Account No.</label>
                            <input class="form-control" type="text" name="account_no" value="<?php echo e($employee->account_no); ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Name.</label>
                            <input class="form-control" type="text" name="nok_name" value="<?php echo e($employee->nok_name); ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Phone.</label>
                            <input class="form-control" type="text" name="nok_phone" value="<?php echo e($employee->nok_phone); ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Address.</label>
                            <input class="form-control" type="text" name="address" value="<?php echo e($employee->address); ?>" >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>SSN.</label>
                            <input class="form-control" type="text" name="ssn" value="<?php echo e($employee->ssn); ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Department.</label>
                            <select name="contract_type" class="select form-control select2" required>
                                <option value="">Select one</option>
                                <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($one->id); ?>" <?php if($employee->contract_type == $one->id): ?> selected <?php endif; ?> ><?php echo e($one->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#edit_employee_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            console.log(formData)
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    frm.reset();

                    toastr.success(response.message,'Success');
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    employees_table.ajax.reload();
                },
                error: function (xhr, status, error) {
                    
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
                    
                    // Handle error response
                    console.error(error);
                    toastr.error('Something went wrong, please try again','Error');
                }
            });
        });
    });
    </script><?php /**PATH /home/ghpayroll/base/resources/views/employees/edit.blade.php ENDPATH**/ ?>