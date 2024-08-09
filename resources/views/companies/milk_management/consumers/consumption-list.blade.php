@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Milk Consumption</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{ route('add-consumption') }}" class="btn btn-danger" ><i class="fa fa-download"></i> Add Consumption</a> &nbsp;
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_category"><i class="fa fa-plus"></i> Add Category</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="consumptions_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Comsumer</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Created on</th> 
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_category" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Consumption</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="event-form" action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="date" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Milk Produced</label>
                                <input type="text" class="form-control" id="daily_production" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-hover table-white" id="tableEstimate">
                        <thead>
                            <tr>
                                <th class="text-success"> <input id="checkAll" type="checkbox"> Check All to Include</th>
                                <th hidden></th>
                                <th>Activity</th>
                                <th class="col-md-6">Description</th>
                                <th class="col-sm-3">Qty(Ltrs)</th>
                                <th class="col-md-3">Rate</th>	
                                <th>Total</th>	
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consumers as $i => $key)
                            <tr>
                                <td>
                                    <input type="checkbox" class="consumption-checkbox" name="check_box[]" checked>
                                    <input type="hidden" class="checkbox-value" name="check_box_value[]" value="1">
                                </td>
                                <td hidden>
                                    <input class="form-control"style="min-width:150px" type="text" name="category_id[]" value="{{ $key->id }}" >
                                </td>
                                <td><input class="form-control"style="min-width:150px" type="text" id="activity" value="{{ $key->name }}" readonly></td>
                                <td><input class="form-control"style="min-width:150px" type="text" id="comments" name="comments[]"></td>
                                <td><input class="form-control"style="min-width:150px" type="number" id="quantity" name="quantity[]"></td>
                                <td><input class="form-control"style="min-width:150px" type="number" id="rate" name="rate[]"></td>
                                <td><input class="form-control total" style="width:120px" type="text" id="amount" name="amount[]" value="0" readonly></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary submit-btn" id="general_submit">Add Consumption</button>
                        <button type="button" class="btn btn-danger submit-btn delete-event" data-dismiss="modal">Close</button>
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
                consumptions_table.ajax.reload();

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

    // Function to check the checkbox state and enable/disable the submit button
    function checkCheckboxes() {
        if ($('.consumption-checkbox:checked').length == 0) {
            $('#general_submit').prop('disabled', true);
        } else {
            $('#general_submit').prop('disabled', false);
        }
    }

    // Check initial state of checkboxes
    checkCheckboxes();

    // Attach change event listener to #checkAll
    $('#checkAll').change(function() {
        var isChecked = $(this).is(':checked');
        $('.consumption-checkbox').prop('checked', isChecked);
        $('.checkbox-value').each(function() {
            $(this).val(isChecked ? 1 : 0); // Update hidden input value
        });
        checkCheckboxes(); // Check the state after changing all checkboxes
    });

    // Attach change event listener to individual checkboxes
    $('.consumption-checkbox').change(function() {
        var isChecked = $(this).is(':checked');
        $(this).siblings('.checkbox-value').val(isChecked ? 1 : 0); // Update hidden input value
        checkCheckboxes(); // Check the state after changing individual checkbox
    });
});

$(document).ready(function(){
    consumptions_table = $('#consumptions_table').DataTable({
        @include('layout.export_buttons')
        processing: true,
        serverSide: false,
        ajax: {
            url : "{{url('milk-management/all-consumptions')}}",
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
            {data: 'consumer_name', name: 'consumer_name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'rate', name: 'rate'},
            {data: 'total', name: 'total'},
            {data: 'date', name: 'date'},
            {data: 'created_on', name: 'created_on'},             
        ],
        createdRow: function( row, data, dataIndex ) {
        }
    });
});

$(document).ready(function() {
    // Initialize the datetimepicker if not already initialized
    if ($.fn.datetimepicker) {
        $('#date').datetimepicker({
            format: 'YYYY-MM-DD' // Adjust the format as needed
        });
    }

    // Listen for change event on the date input
    $(document).on('change', '#date', function () {
        console.log("Date changed");
        var selected_date = $(this).val();
        console.log("Selected date:", selected_date);

        $.ajax({
            url: '/milk-management/daily-production', // Replace with your route
            method: 'GET',
            data: { date: selected_date },
            success: function(response) {
                // Assuming response contains the total production
                $('#daily_production').val(response.total_production);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching total production:', error);
                $('#daily_production').val('Error fetching data');
            }
        });
    });
});


    
</script>

@endsection