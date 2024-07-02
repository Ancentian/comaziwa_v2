<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="edit_task_form" action="<?php echo e(url('staff/updateTask', [$task->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select" name="status">
                        <option value="">Select</option>
                        <option value="complete" <?php echo e($task->status === 'complete' ? 'selected' : ''); ?>>Complete</option>
                        <option value="inprogress" <?php echo e($task->status === 'inprogress' ? 'selected' : ''); ?>>Inprogress</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="submit-section text-center">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_task_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                //packages_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                window.location.reload(); // Reload the page
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
            }
        });
    });
    
</script><?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/tasks/edit.blade.php ENDPATH**/ ?>