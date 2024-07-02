<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Benefit in Kind</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_leave_types_form" action="{{url('leave-types/update',[$benefit->id])}}" method="POST">
                @csrf
                <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input class="form-control" value="{{$benefit->type_name}}" name="type_name" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    
                    <div class="form-group">
                        <label>Leave Days<span class="text-danger">*</span></label>
                        <input class="form-control" value="{{$benefit->leave_days}}" name="leave_days" type="number" step="0.01">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#edit_leave_types_form").submit(function(e){
            e.preventDefault();

            $(".submit-btn").html("Please wait...").prop('disabled', true);
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    leave_types_table.ajax.reload();
                    $('#edit_modal').modal('hide');
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            });

        });
</script>