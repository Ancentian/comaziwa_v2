<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Extend Subscription</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_subscription_form" action="{{url('superadmin/updateSubscription',[$subscription->id])}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Extend Date To<span class="text-danger">*</span></label>
                    <div class="cal-icon">
                        <input class="form-control datetimepicker" name="end_date" value="{{$subscription->end_date}}" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
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
    $("#edit_subscription_form").submit(function(e){
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
                    subscriptions_table.ajax.reload();
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