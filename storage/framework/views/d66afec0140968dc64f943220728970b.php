<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Update Inventory</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_inventory" action="<?php echo e(url('inventory/update-inventory', $inventory->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Categories<span class="text-danger">*</span></label>
                            <select class="form-control select" name="category_id" required>
                                <option value="">Choose one</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>" <?php if($key->id == $inventory->category_id): ?> selected <?php endif; ?>><?php echo e($key->cat_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Product Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="<?php echo e($inventory->name); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Unit<span class="text-danger">*</span></label>
                            <select class="form-control select" name="unit_id" required>
                                <option value="">Choose one</option>
                                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>" <?php if($key->id == $inventory->unit_id): ?> selected <?php endif; ?>><?php echo e($key->unit_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Quantity<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="quantity" value="<?php echo e($inventory->quantity); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Alert Quantity<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" value="<?php echo e($inventory->alert_quantity); ?>" name="alert_quantity" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Buying Price<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="buying_price" value="<?php echo e($inventory->buying_price); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Selling Price<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="selling_price" value="<?php echo e($inventory->selling_price); ?>" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Status<span class="text-danger">*</span></label>
                            <select class="form-control select" name="status" required>
                                <option value="">Choose one</option>
                                <option value="1" <?php if($inventory->status == 1): ?> selected <?php endif; ?>>Active</option>
                                <option value="0" <?php if($inventory->status == 0): ?> selected <?php endif; ?>>Inactive</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" id="" cols="10" rows="3"><?php echo e($inventory->description); ?></textarea>
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
            
        $('#edit_inventory').on('submit', function (e) {
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
                    inventories_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/inventory/edit-inventory.blade.php ENDPATH**/ ?>