<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Assign User Agent</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="assign_user_agent" action="{{ url('superadmin/update-user-agent', [$user->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Agent</label>
                    <select class="select form-control" name="agent_id">
                        <option></option>
                        @foreach ($agents as $key)
                            <option value="{{$key->id}}" {{ $user->agent_id === $key->id ? 'selected' : '' }}>{{$key->name}}</option>
                        @endforeach
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
    $("#assign_user_agent").submit(function(e) {
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
                clients_table.ajax.reload();
                $('#edit_modal').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
            },
            error: function(xhr, status, error) {
                // Handle error response
                toastr.error('Something Went Wrong!, Try again!','Error');
                console.log(xhr.responseText);
            }
            $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
        });
    });
    
</script>