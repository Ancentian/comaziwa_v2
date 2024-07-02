<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Decline Invite</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_course_form" action="{{ url('staff/decline-invite', [$training->id]) }}" method="POST">
                @csrf
                <input type="text" name="approval_status" value="2" hidden>
                    <div class="row">    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Decline Reasons</label>
                                <textarea name="decline_reasons" class="form-control" id="" cols="30" rows="3" required></textarea>
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
    $("#edit_course_form").submit(function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        // SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to decline?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed the decline action
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#edit_modal').modal('hide');
                        staff_invited_trainings_table.ajax.reload();
                        toastr.success(response.message, 'Success');
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log(xhr.responseText);
                        toastr.error(response.message, 'Error');
                    }
                });
            } else {
                // User cancelled the decline action
                // You can add any code here if you want to handle the cancellation
            }
        });
    });
</script>

