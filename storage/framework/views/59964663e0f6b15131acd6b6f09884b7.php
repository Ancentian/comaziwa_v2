<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">Are you sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="update_expense_request" action="<?php echo e(url('trainings/update-complete-status', [$training->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="hidden" id="approval_status" name="status">
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#update_expense_request").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                list_trainings_table.ajax.reload();
                $("#edit_modal").modal('hide');
                toastr.success(response.message, 'Success');
                
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
            }
        });
    });
    
</script><?php /**PATH /home/ghpayroll/base/resources/views/companies/trainings/complete_status.blade.php ENDPATH**/ ?>