<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="edit_task_form" action="{{ url('staff/updateTask', [$task->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control select" name="status">
                        <option value="">Select</option>
                        <option value="complete" {{ $task->status === 'complete' ? 'selected' : '' }}>Complete</option>
                        <option value="inprogress" {{ $task->status === 'inprogress' ? 'selected' : '' }}>Inprogress</option>
                    </select>
                    <span class="modal-error invalid-feedback" role="alert"></span>
                </div>
                <div class="submit-section text-center">
                    <button class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_task_form").submit(function(e) {
        e.preventDefault();

        $("#submit_form").html("Please wait...").prop('disabled', true);
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
    
</script>