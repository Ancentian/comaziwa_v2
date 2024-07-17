<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Deduction Type</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_deduction_type" action="<?php echo e(url('deductions/update-deduction', $deduction->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Deduction Name <span class="text-danger">*</span></label>
                            <input class="form-control date" name="name" value="<?php echo e($deduction->name); ?>" required>
                        </div>
                    </div> 
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Deduction Type <span class="text-danger">*</span></label>
                            <select class="form-control select" id="deduction_type" name="type" required>
                                <option value="">--Choose Here--</option>
                                <option value="individual" <?php if($deduction->type == 'individual'): ?> selected <?php endif; ?>>Individual</option>
                                <option value="general" <?php if($deduction->type == 'general'): ?> selected <?php endif; ?>>General</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Amount <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="amount" value="<?php echo e($deduction->amount); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
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
            
        $('#edit_deduction_type').on('submit', function (e) {
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
                    deduction_types_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/deductions/edit-deduction.blade.php ENDPATH**/ ?>