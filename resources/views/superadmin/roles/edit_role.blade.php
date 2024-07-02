<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Role</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_role_form" action="{{url('/superadmin/update-role/'.$role->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{$role->name}}" required>
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
    $(document).ready(function(){
            
        $('#edit_role_form').on('submit', function (e) {
            e.preventDefault();
            
            $(".submit-btn").html("Please wait...").prop('disabled', true);
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            console.log(formData)
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    roles_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
                $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
            });
        });
    });
    </script>