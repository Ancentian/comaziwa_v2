<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_project_form" action="<?php echo e(url('projects/updateProject', [$project->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" name="title" value="<?php echo e($project->title); ?>" type="text">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Priority</label><br>
                            <select class="select form-control" style="width: 100%;" name="priority">
                                <option>--Choose Here--</option>
                                <option value="high" <?php echo e($project->priority === 'high' ? 'selected' : ''); ?>>High</option>
                                <option value="medium" <?php echo e($project->priority === 'medium' ? 'selected' : ''); ?>>Medium</option>
                                <option value="low" <?php echo e($project->priority === 'low' ? 'selected' : ''); ?>>Low</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Date</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="start_date" value="<?php echo e($project->start_date); ?>" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Due Date</label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="due_date" value="<?php echo e($project->due_date); ?>" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Team Leader</label><br>
                            <select class="select form-control w-100 multiple" style="width: 100%;" name="team_leader">
                                <option>--Choose Here--</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>" <?php echo e($key->id === $project->team_leader ? 'selected' : ''); ?>><?php echo e($key->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Project Team</label><br>
                            <select class="select multiple" name="project_team[]" multiple style="width: 100%;">
                                <option>--Choose Here--</option>
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>" <?php echo e(in_array($key->id,json_decode($project->project_team)) ? 'selected' : ''); ?> ><?php echo e($key->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>                                          
                </div>
                <div class="row">     
                    <div class="col-12">
                        <div class="pro-progress">
                            <div class="pro-progress-bar">
                            <h4>Progress</h4>
                            <div class="progress">
                                <input type="range" min="0" max="100" value="<?php echo e($project->progress); ?>" name="progress" class="progress-range progress-input"  style="width: 100%">
                            </div>
                            <span class="progress-value"><?php echo e($project->progress); ?>%</span>
                            </div>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" id="" cols="30" rows="4"><?php echo e($project->notes); ?></textarea>
                    </div>
                </div>
                
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".select").select2();
    $("#edit_project_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                projects_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                $("#edit_modal").modal('hide');
                toastr.success(response.message,'Successs');
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
        });
    }); 

    $(document).ready(function() {
        $('.progress-input').on('input', function() {
            var value = $(this).val();
            $('.progress-value').text(value + '%');
        });
    });

</script>
<?php /**PATH C:\laragon\www\payroll\resources\views/companies/staff/projects/edit_project.blade.php ENDPATH**/ ?>