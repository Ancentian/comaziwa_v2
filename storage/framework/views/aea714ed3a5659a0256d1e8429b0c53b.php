<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Assign User Agent</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="assign_user_agent" action="<?php echo e(url('superadmin/update-user-agent', [$user->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Agent</label>
                    <select class="select form-control" name="agent_id">
                        <option></option>
                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>" <?php echo e($user->agent_id === $key->id ? 'selected' : ''); ?>><?php echo e($key->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    $("#assign_user_agent").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                clients_table.ajax.reload();
                $('#edit_modal').modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
                console.log(xhr.responseText);
            }
        });
    });
    
</script><?php /**PATH /home/ghpayroll/base/resources/views/superadmin/users/assign_agent.blade.php ENDPATH**/ ?>