<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Farmer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_farmer_form" action="{{ url('cooperative/update-farmer', [$farmer->id]) }}" method="POST">
                @csrf
                @php
                    $pass = substr(mt_rand(1000000, 9999999), 0, 6);
                @endphp

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{$farmer->fname}}" name="fname" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input class="form-control" type="text" value="{{$farmer->mname}}" name="mname">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="lname" value="{{$farmer->lname}}" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Collection Center <span class="text-danger">*</span></label>
                            <select name="center_id" class="select form-control" required>
                                <option>Select Center</option>
                                @foreach($centers as $center)
                                <option value="{{ $center->id }}" @if($farmer->center_id == $center->id) selected @endif>{{ $center->center_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Farmer Code <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" value="{{$farmer->farmerID}}" name="farmerID" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>ID Number</label>
                            <input class="form-control" type="text" value="{{$farmer->id_number}}" name="id_number" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Primary Contact</label>
                            <input class="form-control" type="text" value="{{$farmer->contact1}}" name="contact1">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Secondary Contact</label>
                            <input class="form-control" type="text" value="{{$farmer->contact2}}" name="contact2">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Gender <span class="text-danger">*</span></label>
                            <select class="select form-control" name="gender" required>
                                <option value="">Select</option>
                                <option value="male" @if($farmer->gender == 'male') selected @endif>Male</option>
                                <option value="female" @if($farmer->gender == 'female') selected @endif>Female</option>
                                <option value="other" @if($farmer->gender == 'other') selected @endif>Other</option>
                            </select>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Joining Date <span class="text-danger"></span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="join_date" value="{{$farmer->join_date}}" type="text" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" name="dob" value="{{$farmer->dob}}" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" type="text" name="location" value="{{$farmer->location}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marital Status <span class="text-danger"></span></label>
                            <select name="marital_status" class="select form-control" >
                                <option value="single" @if($farmer->marital_status == 'single') selected @endif>Single</option>
                                <option value="married" @if($farmer->marital_status == 'married') selected @endif>Married</option>
                                <option value="divorced" @if($farmer->marital_status == 'divorced') selected @endif>Divorced</option>
                                <option value="widow" @if($farmer->marital_status == 'widow') selected @endif>Widow</option>
                                <option value="widower" @if($farmer->marital_status == 'widower') selected @endif>Widower</option>
                                <option value="separated" @if($farmer->marital_status == 'separated') selected @endif>Separated</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Status <span class="text-danger">*</span></label>
                            <select name="status" class="select form-control" required>
                                <option value="" selected disabled>--Select--</option>
                                <option value="0" @if($farmer->status == '0') selected @endif>In Active</option>
                                <option value="1" @if($farmer->status == '1') selected @endif>Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Education Levels <span class="text-danger">*</span></label>
                            <select name="education_level" class="select form-control" >
                                <option value="0" @if($farmer->education_level == 0) selected @endif>KCPE</option>
                                <option value="1" @if($farmer->education_level == 1) selected @endif>KCSE</option>
                                <option value="2" @if($farmer->education_level == 2) selected @endif>Certificate</option>
                                <option value="3" @if($farmer->education_level == 3) selected @endif>Diploma</option>
                                <option value="4" @if($farmer->education_level == 4) selected @endif>Degree</option>
                                <option value="5" @if($farmer->education_level == 5) selected @endif>Masters</option>
                                <option value="6" @if($farmer->education_level == 6) selected @endif>Doctorate</option>
                                <option value="7" @if($farmer->education_level == 7) selected @endif>Others</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Bank Name <span class="text-danger">*</span></label>
                            <select name="bank_id" class="select form-control" required>
                                <option>Select Bank</option>
                                @foreach($banks as $key)
                                    <option value="{{ $key->id }}" @if($farmer->bank_id == $key->id) selected @endif>{{ $key->bank_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bank Branch</label>
                            <input class="form-control" type="text" name="bank_branch" value="{{$farmer->bank_branch}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Account Name</label>
                            <input class="form-control" type="text" name="acc_name" value="{{$farmer->acc_name}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Account Number</label>
                            <input class="form-control" type="text" name="acc_number" value="{{$farmer->acc_number}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Mpesa Number</label>
                            <input class="form-control" type="text" name="mpesa_number" value="{{$farmer->mpesa_number}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Name</label>
                            <input class="form-control" type="text" name="nok_name" value="{{$farmer->nok_name}}" required>
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Phone</label>
                            <input class="form-control" type="text" name="nok_phone" value="{{$farmer->nok_phone}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Next of Kin Relationship</label>
                            <input class="form-control" type="text" name="relationship" value="{{$farmer->relationship}}">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                </div>

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit <span class="please-wait-message" style="display:none;">Please wait...</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#edit_farmer_form').on('submit', function (e) {
            e.preventDefault();
    
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
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    farmers_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script>