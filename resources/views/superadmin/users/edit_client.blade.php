<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_client_form" action="{{url('/superadmin/update-client/'.$client->id)}}" method="POST"  autocomplete="off">
                @csrf
                
                
                <div class="row">
                    <div class="col-xl-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h4 class="text-muted mb-0">Company Admin Details (<small>Contact Person</small>)</h4>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{$client->name}}" name="name" type="text">
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{$client->email}}" autocomplete="new-password" name="email" type="email">
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Password (<small>Leave blank if no change</small>)</label>
                                            <input class="form-control" autocomplete="new-password" name="password" type="password">
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input class="form-control"  type="password" name="password_confirmation">
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input class="form-control" value="{{$client->phone_number}}" name="phone_number" type="text">
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" value="client" name="type">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Package</label>
                                            <select class="select form-control" name="package_id">
                                                @foreach ($packages as $key)
                                                    <option value="{{$key->id}}" @if($key->id == $client->package_id) selected @endif>{{$key->name}}</option>  
                                                @endforeach
                                            </select>
                                            <span class="modal-error invalid-feedback" role="alert"></span>
                                        </div>
                                    </div>
                                    
                                </div>
                                    
                                    
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="text-muted mb-0">Company Info</h5>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input class="form-control" value="{{!empty($company) ? $company->name : null}}" name="company_name" type="text" required>
                                        </div>
                                    </div>

                                    
            
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Mobile No.</label>
                                            <input class="form-control" value="{{!empty($company) ? $company->tel_no : null}}" name="company_tel_no" type="tel" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Landline.</label>
                                            <input class="form-control" value="{{!empty($company) ? $company->land_line : null}}" name="company_land_line" type="tel">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>SSN</label>
                                            <input class="form-control" name="company_ssni_est" value="{{!empty($company) ? $company->ssni_est : null}}" type="text" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>TIN</label>
                                            <input class="form-control" name="company_tin" value="{{!empty($company) ? $company->tin : null}}" type="text" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input class="form-control" name="company_address" value="{{!empty($company) ? $company->address : null}}" type="text" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Primary Email</label>
                                            <input class="form-control"  type="email"value="{{!empty($company) ? $company->email : null}}" name="company_email" type="text" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Secondary Email</label>
                                            <input class="form-control" type="email"value="{{!empty($company) ? $company->secondary_email : null}}" name="secondary_email" type="text">
                                        </div>
                                    </div>
            
                                    <div class="col-md-4" hidden>
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <input class="form-control" name="logo" type="file" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-4" hidden>
                                        @if(!empty($company->logo))
                                            <span class=""><img src="{{ asset('storage/logos/'.$company->logo) }}" alt="" class="rounded-circle user-img"></span>
                                        @endif
                                    </div>

                                </div>
                                                                        
                            </div>
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
            
        $('#edit_client_form').on('submit', function (e) {
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
                    clients_table.ajax.reload();
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