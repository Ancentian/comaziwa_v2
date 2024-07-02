<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="invite_staff_form" action="<?php echo e(url('trainings/post-invite-staff', $training->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Invite:</label><br>
                        <select class="select multiple" style="width: 100% !important" name="employees[]" multiple required >
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?>(<?php echo e($key->position); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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
    $("#invite_staff_form").submit(function(e){
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
                    toastr.success(response.message)
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });

        });
        $('.select').select2();
</script><?php /**PATH /home/ghpayroll/base/resources/views/companies/trainings/add_staff.blade.php ENDPATH**/ ?>