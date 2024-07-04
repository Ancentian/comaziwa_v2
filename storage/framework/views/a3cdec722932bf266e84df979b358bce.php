<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Unit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_unit" action="<?php echo e(url('inventory/update-unit', $unit->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Category Name <span class="text-danger">*</span></label>
                            <input class="form-control date" name="unit_name" value="<?php echo e($unit->unit_name); ?>" required>
                        </div>
                    </div> 
                    <div class="col-sm-12">  
                        <div class="form-group">
                            <label class="col-form-label">Unit Code <span class="text-danger">*</span></label>
                            <input class="form-control date" name="unit_code" value="<?php echo e($unit->unit_code); ?>" required>
                        </div>
                    </div> 
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id="" cols="10" rows="3"><?php echo e($unit->description); ?></textarea>
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
            
        $('#edit_unit').on('submit', function (e) {
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
                    units_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/inventory/units/edit.blade.php ENDPATH**/ ?>