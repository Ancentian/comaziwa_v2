<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">Are you sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="update_expense_request" action="{{ url('expenses/update-payment', [$expense->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" id="approval_status" name="payment_status">
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

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                all_expenses_table.ajax.reload();
                $("#edit_modal").modal('hide');
                toastr.success(response.message, 'Success');
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.log(xhr.responseText);
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Yes");
        });
    });
    
</script>