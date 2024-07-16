<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Farmer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_farmer_form" action="<?php echo e(url('cooperative/update-farmer', [$farmer->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php
                    $pass = substr(mt_rand(1000000, 9999999), 0, 6);
                ?>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->fname); ?>" name="fname" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->mname); ?>" name="mname">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="lname" value="<?php echo e($farmer->lname); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Collection Center <span class="text-danger">*</span></label>
                            <select name="center_id" class="select form-control" required>
                                <option>Select Center</option>
                                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($center->id); ?>" <?php if($farmer->center_id == $center->id): ?> selected <?php endif; ?>><?php echo e($center->center_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Farmer Code <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->farmerID); ?>" name="farmerID" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>ID Number</label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->id_number); ?>" name="id_number" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Primary Contact</label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->contact1); ?>" name="contact1">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Secondary Contact</label>
                            <input class="form-control" type="text" value="<?php echo e($farmer->contact2); ?>" name="contact2">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Gender <span class="text-danger">*</span></label>
                            <select class="select form-control" name="gender" required>
                                <option value="">Select</option>
                                <option value="male" <?php if($farmer->gender == 'male'): ?> selected <?php endif; ?>>Male</option>
                                <option value="female" <?php if($farmer->gender == 'female'): ?> selected <?php endif; ?>>Female</option>
                                <option value="other" <?php if($farmer->gender == 'other'): ?> selected <?php endif; ?>>Other</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Joining Date <span class="text-danger"></span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="join_date" value="<?php echo e($farmer->join_date); ?>" type="text" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="dob" value="<?php echo e($farmer->dob); ?>" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" type="text" name="location" value="<?php echo e($farmer->location); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marital Status <span class="text-danger"></span></label>
                            <select name="marital_status" class="select form-control" >
                                <option value="single" <?php if($farmer->marital_status == 'single'): ?> selected <?php endif; ?>>Single</option>
                                <option value="married" <?php if($farmer->marital_status == 'married'): ?> selected <?php endif; ?>>Married</option>
                                <option value="divorced" <?php if($farmer->marital_status == 'divorced'): ?> selected <?php endif; ?>>Divorced</option>
                                <option value="widow" <?php if($farmer->marital_status == 'widow'): ?> selected <?php endif; ?>>Widow</option>
                                <option value="widower" <?php if($farmer->marital_status == 'widower'): ?> selected <?php endif; ?>>Widower</option>
                                <option value="separated" <?php if($farmer->marital_status == 'separated'): ?> selected <?php endif; ?>>Separated</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Status <span class="text-danger">*</span></label>
                            <select name="status" class="select form-control" required>
                                <option value="" selected disabled>--Select--</option>
                                <option value="0" <?php if($farmer->status == '0'): ?> selected <?php endif; ?>>In Active</option>
                                <option value="1" <?php if($farmer->status == '1'): ?> selected <?php endif; ?>>Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Education Levels <span class="text-danger">*</span></label>
                            <select name="education_level" class="select form-control" >
                                <option value="0" <?php if($farmer->education_level == 0): ?> selected <?php endif; ?>>KCPE</option>
                                <option value="1" <?php if($farmer->education_level == 1): ?> selected <?php endif; ?>>KCSE</option>
                                <option value="2" <?php if($farmer->education_level == 2): ?> selected <?php endif; ?>>Certificate</option>
                                <option value="3" <?php if($farmer->education_level == 3): ?> selected <?php endif; ?>>Diploma</option>
                                <option value="4" <?php if($farmer->education_level == 4): ?> selected <?php endif; ?>>Degree</option>
                                <option value="5" <?php if($farmer->education_level == 5): ?> selected <?php endif; ?>>Masters</option>
                                <option value="6" <?php if($farmer->education_level == 6): ?> selected <?php endif; ?>>Doctorate</option>
                                <option value="7" <?php if($farmer->education_level == 7): ?> selected <?php endif; ?>>Others</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Bank Name <span class="text-danger">*</span></label>
                            <select name="bank_id" class="select form-control" required>
                                <option>Select Bank</option>
                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>" <?php if($farmer->bank_id == $key->id): ?> selected <?php endif; ?>><?php echo e($key->bank_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bank Branch</label>
                            <input class="form-control" type="text" name="bank_branch" value="<?php echo e($farmer->bank_branch); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Account Name</label>
                            <input class="form-control" type="text" name="acc_name" value="<?php echo e($farmer->acc_name); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input class="form-control" type="text" name="acc_number" value="<?php echo e($farmer->acc_number); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Mpesa Number</label>
                            <input class="form-control" type="text" name="mpesa_number" value="<?php echo e($farmer->mpesa_number); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Name</label>
                            <input class="form-control" type="text" name="nok_name" value="<?php echo e($farmer->nok_name); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Phone</label>
                            <input class="form-control" type="text" name="nok_phone" value="<?php echo e($farmer->nok_phone); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Relationship</label>
                            <input class="form-control" type="text" name="relationship" value="<?php echo e($farmer->relationship); ?>">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit <span class="please-wait-message" style="display:none;">Please wait...</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#edit_farmer_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    farmers_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/cooperatives/edit_farmer.blade.php ENDPATH**/ ?>