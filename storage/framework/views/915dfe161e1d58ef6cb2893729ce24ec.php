<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Training</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_training_form" action="<?php echo e(url('trainings/update-training', $training->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Training Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" value="<?php echo e($training->name); ?>" type="text">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Training Type</label>
                            <select class="select form-control" name="type">
                                <option value="compulsory" <?php echo e($training->type === 'compulsory' ? 'selected' : ''); ?>>Compulsory</option>
                                <option value="optional" <?php echo e($training->type === 'optional' ? 'selected' : ''); ?>>Optional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="<?php echo e($training->start_date); ?>" name="start_date" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>End Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" value="<?php echo e($training->end_date); ?>" name="end_date" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label>Time<span class="text-danger">*</span></label>
                                <input class="form-control " value="<?php echo e($training->time); ?>" name="time" type="time">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Vendor <span class="text-danger">*</span></label>
                                <input class="form-control" name="vendor" value="<?php echo e($training->vendor); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Location <span class="text-danger">*</span></label>
                                <input class="form-control" name="location" value="<?php echo e($training->location); ?>" type="text">
                            </div>
                        </div>
                    
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="4"><?php echo e($training->description); ?></textarea>
                        </div>
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
    $("#edit_training_form").submit(function(e){
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    trainings_table.ajax.reload();
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
</script><?php /**PATH C:\laragon\www\payroll\resources\views/companies/trainings/edit.blade.php ENDPATH**/ ?>