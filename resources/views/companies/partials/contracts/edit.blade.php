<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Department</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{url('departments/update',[$contract->id])}}" class="edit_form" method="POST" id="edit_contract_form">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
                            <input class="form-control" name="name" id="contract_name" type="text" value="{{$contract->name}}">
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
    $("#edit_contract_form").submit(function(e){
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
                    contract_types_table.ajax.reload();                    
                    $('#edit_modal').modal('hide');
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            });

        });
</script>