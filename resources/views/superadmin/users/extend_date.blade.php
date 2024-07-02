<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Extend Expiry Date</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="extend_expiry_date_form" action="{{ url('superadmin/extend_userDates', [$user->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Expiry Date</label>
                    <div class="cal-icon">
                        <input type="date" class="form-control" name="expiry_date" value="{{$user->expiry_date}}" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                </div>
                <div class="submit-section text-center">
                    <button class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#extend_expiry_date_form").submit(function(e) {
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
                //packages_table.ajax.reload();
                //$('#edit_modal').modal('hide');
                window.location.reload(); // Reload the page
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