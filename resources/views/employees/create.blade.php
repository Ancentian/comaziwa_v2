<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Create </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="add_employee_form" action="{{url('/employees/create')}}" method="POST">
                @csrf
                @php
                    
                    $package_id = auth()->user()->package_id;
                    $package = \App\Models\Package::where('id', $package_id)->first();

                    $totalStaff = \App\Models\Employee::where('tenant_id',auth()->user()->id)->count();
                    $pass = substr(mt_rand(1000000, 9999999), 0, 6);
                   
                @endphp

                @if($totalStaff < $package->staff_no)
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input class="form-control" type="email" name="email" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-6" hidden>
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input class="form-control" name="password" type="password" value="{{$pass}}" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone No</label>
                                <input class="form-control" type="tel" name="phone_no" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Staff No.</label>
                                <input class="form-control" id="staff_no" type="text" value="{{substr(mt_rand(1000000, 9999999), 0, 7)}}" name="staff_no" required readonly>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Position</label>
                                <input class="form-control" type="text" name="position" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input class="form-control" type="date" name="dob" placeholder="dd/mm/yyyy" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" type="text" name="bank_name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Branch Name</label>
                                <input class="form-control" type="text" name="branch_name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Short Code</label>
                                <input class="form-control" type="text" name="branch_shortcode" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Account No.</label>
                                <input class="form-control" type="text" name="account_no" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SSN.</label>
                                <input class="form-control" type="text" name="ssn" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Next of Kin Name.</label>
                                <input class="form-control" type="text" name="nok_name" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Next of Kin Phone.</label>
                                <input class="form-control" type="text" name="nok_phone" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Address.</label>
                                <input class="form-control" type="text" name="address">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Department.</label>
                                <select name="contract_type" class="select form-control" required>
                                    <option value="">Select one</option>
                                    @foreach($contracts as $one)
                                        <option value="{{$one->id}}">{{$one->name}}</option>
                                    @endforeach
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                    </div>
                @else
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{$package->name}} package only allows maximum of <strong>{{$package->staff_no}}</strong> employees! Contact the admin.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                @endif
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit <span class="please-wait-message" style="display:none;">Please wait...</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
                    
        $('#add_employee_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');

            $(form).find('button[type="submit"]').prop('disabled', true);
            $(form).find('.please-wait-message').text('Please wait...');
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#add_employee').modal('hide');
                    employees_table.ajax.reload();
                    //window.location.href = "{{ url('/employees/generateinitialPayslip/') }}" + "/"+response.id;
                },
                error: function (xhr, status, error) {
                    if (xhr.status == 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = "";
            
                        // Loop through the errors and concatenate them into a single string
                        for (var key in errors) {
                            errorMessage += errors[key].join('<br>') + '<br>';
                        }
            
                        // Display the error message in a toast
                        toastr.error(errorMessage, 'Validation Error');
                    }
                }
            });
        });
    });
    </script>