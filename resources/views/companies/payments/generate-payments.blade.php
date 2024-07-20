@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Reports</a></li>
                <li class="breadcrumb-item active">PAYE</li>
            </ul>
        </div>       
    </div>
</div>
<!-- /Page Header -->
<form id="generatePayment">
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="paye_period" value="{{ date('Y-m') }}" id="pay_period">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Collection Center <span class="text-danger">*</span></label>
                <select class="form-control select" name="collection_center" id="center_id">
                    <option value="">Choose one</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">  
            <div class="form-group">
                <label class="col-form-label">Milk Pay Rate <span class="text-danger">*</span></label>
                <input class="form-control" name="milk_rate" id="milk_rate" type="number" placeholder="0.00" required>
            </div>
        </div>
        <div class="col-sm-4">  
            <div class="form-group">
                <label class="col-form-label">Bonus Rate <span class="text-danger">*</span></label>
                <input class="form-control" name="bonus_rate" id="bonus_rate" type="number" placeholder="0.00" required>
            </div>
        </div>
    </div>

<div class="row">
    <hr>

    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="generate_payments_table">
                <thead>
                    <tr>
                        <th>Member Name - Code </th>
                        <th style="display: none;">Farmer ID</th>
                        <th>Total Milk</th> 
                        <th>Stores Deductions</th>
                        <th>Individual Deductions</th>
                        <th>General Deductions</th>
                        <th>Shares Contribution</th>
                        <th>Previous Dues</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <button type="submit" id="submit_payments" class="btn btn-primary mt-3">Submit Payments</button>
    </form>
    </div>
</div>
</div>

</div>

@endsection

@section('javascript')
<script>

$(document).ready(function(){
        $(".warning").hide();
        $(".submit-btn").show();
        $(document).on('click', '#bulk_generate_btn', function () {
            $('#bulk_generate').modal("show");
        });
    
        generate_payments_table = $('#generate_payments_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('payments/generate-payments')}}",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                    d.center_id = $("#center_id").val();
                }
            },
                columnDefs: [
                {
                    "targets": 1, // Target the farmer_id column
                    "visible": false, // Hide the column
                    "searchable": false,
                    "orderable": false
                }
            ],
            columns: [
                {data: 'fullname', name: 'fullname'},
                {data: 'farmer_id', name: 'farmer_id'},
                {data: 'total_milk', name: 'total_milk'},
                {data: 'total_store_deductions', name: 'total_store_deductions'},
                {data: 'total_individual_deductions', name: 'total_individual_deductions'},
                {data: 'total_general_deductions', name: 'total_general_deductions'},
                {data: 'total_shares', name: 'total_shares'},
                {data: 'previous_dues', name: 'previous_dues'},    
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        $('#pay_period, #center_id').change(function() {
            generate_payments_table.ajax.reload();
        });

        $('#generatePayment').submit(function(e) {
    e.preventDefault();

    // Get data from the table
    var tableData = generate_payments_table.rows().data().toArray();

    // Get the value from the collection center select input
    var center_id = $("#center_id").val();
    var pay_period = $("#pay_period").val();
    var milk_rate = $("#milk_rate").val();
    var bonus_rate = $("#bonus_rate").val();

    // Prepare data for submission
    var submitData = tableData.map(function(row) {
        return {
            farmer_id: row.farmer_id,
            total_milk: row.total_milk,
            store_deductions: row.total_store_deductions,
            individual_deductions: row.total_individual_deductions,
            general_deductions: row.total_general_deductions,
            shares_contribution: row.total_shares,
            previous_dues: row.previous_dues
        };
    });

    // First confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to submit the payment data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, submit it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Second confirmation dialog
            Swal.fire({
                title: 'This operation cannot be reversed!',
                text: "Are you absolutely sure you want to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form via AJAX
                    $.ajax({
                        url: "{{ url('payments/store-payments') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            center_id: center_id,
                            pay_period: pay_period,
                            milk_rate: milk_rate,
                            bonus_rate: bonus_rate,
                            payments: submitData
                        },
                        success: function(response) {
                            // Handle the response
                            Swal.fire(
                                'Submitted!',
                                'Your payment data has been submitted.',
                                'success'
                            );
                        },
                        error: function(error) {
                            // Handle errors
                            Swal.fire(
                                'Error!',
                                'Something went wrong! Please try again.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    });
});

    });

    function setAction(action) {
        $('#action').val(action);
    }
</script>

@endsection