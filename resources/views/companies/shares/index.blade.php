@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Share Contributions</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_shares"><i class="fa fa-plus"></i> Add Shares</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="shares_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Name</th>
                        <th>Center</th>
                        <th>Share Value</th> 
                        <th>Mode</th>
                        <th>Date</th>
                        <th>Created at</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_shares" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Farmer Shares</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_shares_form" method="POST">
                    @csrf    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Collection Center <span class="text-danger">*</span></label>
                                <select name="center_id" id="center_id" class="select form-control" required>
                                    <option>Select Center</option>
                                    @foreach($centers as $center)
                                    <option value="{{$center->id}}">{{$center->center_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Farmer <span class="text-danger">*</span></label>
                                <select name="farmer_id" id="farmer_id" class="select form-control" required>
                                    <option>Select Farmer</option>
                                </select>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Share Contribution <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="share_value" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label class="col-form-label">Issue Date <span class="text-danger"></span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="issue_date" type="text" >
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Mode of Contribution <span class="text-danger">*</span></label>
                                <select name="mode_of_contribution" class="select form-control" required>
                                    <option value="">Select Mode of Contribution</option>
                                    <option value="cash">Cash</option>
                                    <option value="milk">Milk Deduction</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">  
                            <div class="form-group">
                                <label class="col-form-label">Description <span class="text-danger"></span></label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
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
</div>
@endsection

@section('javascript')
<script>
//Save Cooperative Farmers
$(document).ready(function(){
    
    $('#add_shares_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('shares/store-shares') }}',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                shares_table.ajax.reload();
                
                // Close the modal
                $('#add_shares').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

});

$(document).ready(function(){
    shares_table = $('#shares_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('shares/all-shares')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'fullname', name: 'fullname'}, 
                {data: 'center_name', name: 'center_name'},
                {data: 'share_value', name: 'share_value'},
                {data: 'mode_of_contribution', name: 'mode_of_contribution'},
                {data: 'issue_date', name: 'issue_date'},
                {data: 'created_on', name: 'created_on'},

            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    $(document).ready(function(){
    $('#center_id').change(function(){
        var centerId = $(this).val();
        if(centerId) {
            $.ajax({
                url: '/cooperative/getFarmersByCenter/' + centerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $('#farmer_id').empty();
                    $('#farmer_id').append('<option>Select Farmer</option>');
                    $.each(data, function(key, value) {
                        $('#farmer_id').append('<option value="'+ value.id +'">' + value.fname + ' ' + value.lname + '</option>');
                    });
                }
            });
        } else {
            $('#farmer_id').empty();
            $('#farmer_id').append('<option>Select Farmer</option>');
        }
    });
});
</script>
@endsection