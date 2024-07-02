<?php $__env->startSection('content'); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Welcome <?php echo e(auth()->guard('employee')->user()->name); ?>!</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">My Data</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">My Profile</h4>
            </div>
            <div class="card-body">
                <form id="edit_employee_form" action="<?php echo e(url('/employees/edit/'.$employee->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="<?php echo e($employee->name); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" value="<?php echo e($employee->email); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                       
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone No</label>
                                <input class="form-control" type="tel" name="phone_no" value="<?php echo e($employee->phone_no); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Staff No.</label>
                                <input class="form-control" id="staff_no" type="text"  value="<?php echo e($employee->staff_no); ?>" name="staff_no" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" type="text" name="position" value="<?php echo e($employee->position); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control" type="date" name="dob" placeholder="dd/mm/yyyy" value="<?php echo e($employee->dob); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" value="<?php echo e($employee->bank_name); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Branch Name</label>
                                <input class="form-control" type="text" name="branch_name" value="<?php echo e($employee->branch_name); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Branch Shortcode</label>
                                <input class="form-control" type="text" name="branch_shortcode" value="<?php echo e($employee->branch_shortcode); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Account No.</label>
                                <input class="form-control" type="text" name="account_no" value="<?php echo e($employee->account_no); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SSN.</label>
                                <input class="form-control" type="text" name="ssn" value="<?php echo e($employee->ssn); ?>" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
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
                                <input class="form-control" type="text" value="<?php echo e($employee->address); ?>" name="address">
                            </div>
                        </div>

                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Update</button>
                    </div>
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
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
                    
                    window.location.reload();
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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/settings.blade.php ENDPATH**/ ?>