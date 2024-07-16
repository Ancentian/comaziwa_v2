<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Shares</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_shares" action="<?php echo e(url('shares/update-shares', $share->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Collection Center <span class="text-danger">*</span></label>
                            <select name="center_id" id="center_id" class="select form-control" required readonly>
                                <option>Select Center</option>
                                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($center->id); ?>" <?php if($share->center_id == $center->id): ?> selected <?php endif; ?>><?php echo e($center->center_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Farmer <span class="text-danger">*</span></label>
                            <select name="farmer_id" id="farmer_id" class="select form-control" required readonly>
                                <option>Select Farmer</option>
                                <?php if(isset($share->farmer_id)): ?>
                                    <?php $__currentLoopData = $farmers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farmer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($farmer->center_id == $share->center_id): ?>
                                            <option value="<?php echo e($farmer->id); ?>" <?php if($share->farmer_id == $farmer->id): ?> selected <?php endif; ?>><?php echo e($farmer->fname . ' ' . $farmer->lname); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Share Contribution <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="<?php echo e($share->share_value); ?>" name="share_value" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Issue Date <span class="text-danger"></span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="<?php echo e($share->issue_date); ?>" name="issue_date" type="text" >
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Mode of Contribution <span class="text-danger">*</span></label>
                            <select name="mode_of_contribution" class="select form-control" required>
                                <option value="">Select Mode of Contribution</option>
                                <option value="cash" <?php if($share->mode_of_contribution == 'cash'): ?> selected <?php endif; ?>>Cash</option>
                                <option value="milk" <?php if($share->mode_of_contribution == 'milk'): ?> selected <?php endif; ?>>Milk Deduction</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Description <span class="text-danger"></span></label>
                            <textarea class="form-control" name="description" rows="4"><?php echo e($share->description); ?></textarea>
                        </div>
                    </div>                  
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var selectedCenterId = $('#center_id').val();
    if(selectedCenterId) {
        fetchFarmers(selectedCenterId, <?php echo e($share->farmer_id ?? 'null'); ?>);
    }

    $('#center_id').change(function(){
        var centerId = $(this).val();
        if(centerId) {
            fetchFarmers(centerId, null);
            $('#farmer_id').prop('readonly', false);
        } else {
            $('#farmer_id').empty();
            $('#farmer_id').append('<option>Select Farmer</option>');
            $('#farmer_id').prop('readonly', true);
        }
    });

    function fetchFarmers(centerId, selectedFarmerId) {
        $.ajax({
            url: '/getFarmersByCenter/' + centerId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#farmer_id').empty();
                $('#farmer_id').append('<option>Select Farmer</option>');
                $.each(data, function(key, value) {
                    var selected = selectedFarmerId && selectedFarmerId == value.id ? 'selected' : '';
                    $('#farmer_id').append('<option value="'+ value.id +'" '+ selected +'>' + value.fname + ' ' + value.lname + '</option>');
                });
            }
        });
    }
});

$(document).ready(function(){
        
    $('#edit_shares').on('submit', function (e) {
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
                frm.reset();
                
                // Close the modal
                $('#edit_modal').modal('hide');
                categories_table.ajax.reload();
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    });
});
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/shares/edit.blade.php ENDPATH**/ ?>