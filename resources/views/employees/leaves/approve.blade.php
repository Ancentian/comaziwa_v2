<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">Are you sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="update_leave_form" action="{{ url('leaves/updateStatus', [$leave->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" id="leave_status" name="status">
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#update_leave_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                if ($('#leaves_table').length > 0) {
                    leaves_table.ajax.reload();
                }

                if ($('#pending_leaves_table').length > 0) {
                    pending_table.ajax.reload();
                }

                if ($('#all_leaves_table').length > 0) {
                    leaves_table.ajax.reload();
                }

                if ($('#staff_leaves_table').length > 0) {
                    staff_leaves_table.ajax.reload();
                }
                
                $("#edit_modal").modal('hide');
                
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
            }
        });
    });
    
</script>