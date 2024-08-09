@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Consumer Categories</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_category"><i class="fa fa-plus"></i> Add Category</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="consumer_categories_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Category Name</th>
                        <th>Status</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_category" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Consumer Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_consumer_cat" method="POST">
                    @csrf    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Category Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control select" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
						<div class="col-md-12">
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="description"></textarea>
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
$(document).ready(function() {
    $('#add_consumer_cat').on('submit', function(e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ url('milk-management/store-category') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                form.reset();
                consumer_categories_table.ajax.reload();

                // Close the modal
                $('#add_category').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false).html("Submit");
            },
            error: function(xhr, status, error) {
                // Handle error response
                var responseJSON = xhr.responseJSON;
                if (responseJSON && responseJSON.errors) {
                    // Display validation errors
                    var errors = responseJSON.errors;
                    Object.keys(errors).forEach(function(field) {
                        var errorMessage = errors[field][0];
                        var fieldElement = $('[name="' + field + '"]');
                        var errorElement = fieldElement.next('.modal-error');
                        fieldElement.addClass('is-invalid');
                        errorElement.text(errorMessage).show();
                        toastr.error(errorMessage, 'Error');
                    });
                } else {
                    toastr.error('Something went wrong! Please try again.', 'Error');
                }
                $(".submit-btn").prop('disabled', false).html("Submit");
            }
        });
    });
});

$(document).ready(function(){
    consumer_categories_table = $('#consumer_categories_table').DataTable({
        @include('layout.export_buttons')
        processing: true,
        serverSide: false,
        ajax: {
            url : "{{url('milk-management/consumer-categories')}}",
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
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},             
        ],
        createdRow: function( row, data, dataIndex ) {
        }
    });
});

    
</script>

@endsection