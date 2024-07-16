<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Asset Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_asset" action="<?php echo e(url('assets/update-asset', $asset->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label> Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control select" id="">
                                <option value="">Choose one</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>" <?php if($asset->category_id == $key->id): ?> selected <?php endif; ?>><?php echo e($key->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label> Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="asset_name" value="<?php echo e($asset->asset_name); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input class="form-control" type="date" name="purchase_date" value="<?php echo e($asset->purchase_date); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Purchase Price<span class="text-danger">*</span></label>
                            <input class="form-control" name="purchase_price" value="<?php echo e($asset->purchase_price); ?>" type="number" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Current Value<span class="text-danger">*</span></label>
                            <input class="form-control" name="current_value" type="number" value="<?php echo e($asset->current_value); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Location<span class="text-danger">*</span></label>
                            <input class="form-control" name="location" type="text" value="<?php echo e($asset->location); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" id="" class="form-control select">
                                <option value="">--Select Status--</option>
                                <option value="0" <?php if($asset->status == '0'): ?> selected <?php endif; ?>>In Active</option>
                                <option value="1" <?php if($asset->status == '1'): ?> selected <?php endif; ?>>Active</option>
                                <option value="2" <?php if($asset->status == '2'): ?> selected <?php endif; ?>>Sold</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description<span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" id="" rows="3"><?php echo e($asset->description); ?></textarea>
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
            
        $('#edit_asset').on('submit', function (e) {
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
                    assets_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/assets/edit.blade.php ENDPATH**/ ?>