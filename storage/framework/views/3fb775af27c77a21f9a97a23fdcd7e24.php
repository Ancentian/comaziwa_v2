<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Spillage</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_spillage" action="<?php echo e(url('milk-management/update-spillage', $spill->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date <span class="text-danger">*</span></label>
                            <input class="form-control" type="date" id="" name="date" value="<?php echo e($spill->date); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity in Liters <span class="text-danger">*</span></label>
                            <input class="form-control" name="quantity" value="<?php echo e($spill->quantity); ?>" type="number">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="3" name="description"><?php echo e($spill->description); ?></textarea>
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
            
        $('#edit_spillage').on('submit', function (e) {
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
                    milk_spillage_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/milk_management/spillages/edit.blade.php ENDPATH**/ ?>