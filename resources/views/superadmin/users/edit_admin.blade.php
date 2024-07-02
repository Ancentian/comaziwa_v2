<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Admin</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_admin_form" action="{{url('/superadmin/update-admin/'.$user->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{$user->name}}" required>
                        </div>
                    </div>
                   
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" value="{{$user->email}}" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">* (leave blank if no change)</span></label>
                            <input class="form-control" type="password" name="password" placeholder="(unchanged)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirm password <span class="login-danger">*</span></label>
                            <input type="password" class="form-control pass-confirm" name="password_confirmation">
                        </div>
                    </div> 
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone No</label>
                            <input class="form-control" type="tel" name="phone_number" value="{{$user->phone_number}}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select class="select form-control" name="role_id">
                                @foreach ($roles as $key)
                                    <option value="{{$key->id}}" @if($key->id == $user->role_id) selected @endif>{{$key->name}}</option>  
                                @endforeach
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#edit_admin_form').on('submit', function (e) {
            e.preventDefault();
            
            $(".submit-btn").html("Please wait...").prop('disabled', true);
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    agents_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                    $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                }
                $(".submit-btn").prop('disabled', false); 
                    $(".submit-btn").html("Submit");
            });
        });
    });
    </script>