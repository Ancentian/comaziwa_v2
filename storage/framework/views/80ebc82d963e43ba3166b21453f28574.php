<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload Certificate </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="<?php echo e(url('trainings/update-certificate',[$training->id])); ?>" class="edit_form" method="POST" id="upload_certificate" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Upload Certificate<span class="text-danger">*</span></label>
                            <input class="form-control" name="certificate" type="file">
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#upload_certificate").submit(function(e){
    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var data = new FormData(form[0]);  // Use FormData to handle file uploads

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        processData: false,  // Prevent jQuery from processing the data
        contentType: false,  // Let the browser set the content type
        success: function(response) {
            list_trainings_table.ajax.reload();
            $('#edit_modal').modal('hide');
            toastr.success(response.message, 'Success');
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
});

</script><?php /**PATH /home/ghpayroll/base/resources/views/companies/trainings/upload_certificate.blade.php ENDPATH**/ ?>