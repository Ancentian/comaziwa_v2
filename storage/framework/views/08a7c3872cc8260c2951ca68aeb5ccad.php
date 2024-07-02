<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_project_form" action="<?php echo e(url('staff/updateProject', [$project->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
                //packages_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                window.location.reload(); // Reload the page
                toastr.success(response.message, 'Success');
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
                toastr.error(response.message, 'Error');
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
<?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/projects/edit.blade.php ENDPATH**/ ?>