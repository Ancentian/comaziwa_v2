<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Statutory Deduction</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_stat_form" action="<?php echo e(url('deductions/update_statutoryDeduction',[$statutoryDed->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Name <span class="text-danger">*</span></label>
                    <input class="form-control" name="name" value="<?php echo e($statutoryDed->name); ?>" type="text">
                </div>
                <div class="form-group">
                    <label>Type <span class="text-danger">*</span></label>
                    <select class="form-control select" name="type">
                        <option value="fixed" <?php echo e($statutoryDed->type === 'fixed' ? 'selected' : ''); ?>>Fixed</option>
                        <option value="percentage" <?php echo e($statutoryDed->type === 'percentage' ? 'selected' : ''); ?>>Percentage</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label>Value<span class="text-danger">*</span></label>
                    <input class="form-control" name="value" value="<?php echo e($statutoryDed->value); ?>" type="number" step="0.01">
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_stat_form").submit(function(e){
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    statutory_table.ajax.reload();
                    $('#edit_modal').modal('hide');
                    toastr.success(response.message, 'Success');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });

        });
</script><?php /**PATH /home/ghpayroll/base/resources/views/companies/partials/deductions/editStatutoryDeduction.blade.php ENDPATH**/ ?>