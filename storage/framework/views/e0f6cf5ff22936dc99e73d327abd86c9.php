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
                    <label>Project</label>
                    <select class="form-control select" name="project_id">
                        <<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key->id); ?>" <?php echo e($key->id === $task->project_id ? 'selected' : ''); ?>><?php echo e($key->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Task Name</label>
                    <input type="text" name="title" value="<?php echo e($task->title); ?>" class="form-control">
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Assigned To</label>
                    <select class="form-control select" name="assigned_to">
                        <<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key->id); ?>" <?php echo e($key->id === $task->assigned_to ? 'selected' : ''); ?>><?php echo e($key->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Task Priority</label>
                    <select class="form-control select" name="priority">
                        <option>Select</option>
                        <option value="high" <?php echo e($task->priority === 'high' ? 'selected' : ''); ?>>High</option>
                        <option value="medium" <?php echo e($task->priority === 'medium' ? 'selected' : ''); ?>>Medium</option>
                        <option value="low" <?php echo e($task->priority === 'low' ? 'selected' : ''); ?>>Low</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select" name="status">
                        <option value="">Select</option>
                        <option value="complete" <?php echo e($task->status === 'complete' ? 'selected' : ''); ?>>Complete</option>
                        <option value="inprogress" <?php echo e($task->status === 'inprogress' ? 'selected' : ''); ?>>Inprogress</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" id="" cols="30" rows="4"><?php echo e($task->notes); ?></textarea>
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
    
</script><?php /**PATH C:\laragon\www\payroll\resources\views/companies/staff/tasks/edit_task.blade.php ENDPATH**/ ?>