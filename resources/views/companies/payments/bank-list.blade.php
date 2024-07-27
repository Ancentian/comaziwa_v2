@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Verified Bank List</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Pay Period <span class="text-danger">*</span></label>
            <input class="form-control" type="month" name="pay_period" value="{{ date('Y-m') }}" id="pay_period">
        </div>
    </div> 
    {{-- <div class="col-md-4">
        <div class="form-group">
            <label>Date Range <span class="text-danger">*</span></label>
            <input type="text" readonly id="daterange" class="form-control" value="{{date('m/01/Y')}} - {{date('m/t/Y')}}" />
        </div>
    </div> --}}
    <div class="form-group col-sm-4">
        <label for="center_id">Select Center</label>
        <select class="form-control select" name="center_id" id="center_id" required>
            <option value="">Choose one</option>
            @foreach($centers as $center)
                <option value="{{ $center->id }}">{{ $center->center_name }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group col-sm-4">
        <label for="farmer_id">Select Farmer</label>
        <select class="form-control select" name="farmer_id" id="farmer_id" required>
            <option value="">Choose one</option>
        </select>
    </div>
    <div class="form-group col-sm-4">
        <label for="center_id">Select Bank</label>
        <select class="form-control select" name="center_id" id="bank_id" required>
            <option value="">Choose one</option>
            @foreach($banks as $bank)
                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table table-hover" id="all_payments_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort notexport">Action</th>
                        <th class="text-center">Code</th>
                        <th>Full Name</th>
                        <th>Center</th>
                        <th>Bank</th>
                        <th>A/C No.</th>
                        <th>Net Pay</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
$(document).ready(function(){
    $(".warning").hide();
    $(".submit-btn").show();
    
    $(document).on('click', '#add_employee_btn', function () {
        var actionuRL = "{{url('/employees/create')}}";
        $('#add_employee').load(actionuRL, function() {
            $(this).modal('show');
        });
    });
    
    $(document).on('click', '#bulk_generate_btn', function () {
        $('#bulk_generate').modal("show");
    });

    $('#bulk_payslip_form').on('submit', function (e) {
        e.preventDefault();
        
        $(".warning").show();
        $(".submit-btn").hide();
        

        var form = this;
        var formData = $(this).serialize();
        var url = $(this).attr('action');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function (response) {
                
                form.reset();
                
                toastr.success(response.message,'Success');
                
                $(".warning").hide();
                $(".submit-btn").show();
                
                // Close the modal
                $('#bulk_generate').modal('hide');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
                toastr.error("Something went wrong, please try again",'Error');
                
                $(".warning").hide();
                $(".submit-btn").show();
            }
        });
    });
});


$(document).ready(function() {
    // Function to format pay_period to "Month, Year"
    function formatPayPeriod(payPeriod) {
        if (!payPeriod) return "June, 2024"; // Default value if pay_period is not provided

        // Split the pay_period into year and month
        var parts = payPeriod.split('-');
        var year = parts[0];
        var month = parts[1];

        // Create a date object to easily get the month name
        var date = new Date(year, month - 1);

        // Options for formatting the month name
        var options = { month: 'long' };
        var monthName = new Intl.DateTimeFormat('en-US', options).format(date);

        return monthName + ", " + year;
    }

    // Get the pay_period value from the input and format it
    var pay_period = formatPayPeriod($("#pay_period").val());

    // Initialize DataTable with export buttons
    var all_payments_table = $('#all_payments_table').DataTable({
        dom: 'Bfrtip',
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('payments/bank-list') }}",
            data: function(d) {
                d.pay_period = $("#pay_period").val();
                d.center_id = $("#center_id").val();
                d.farmer_id = $("#farmer_id").val();
                d.bank_id = $("#bank_id").val();
            }
        },
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i> Excel',
                className: 'btn btn-sm btn-default',
                title: 'Payment Summary for ' + pay_period,
                filename: 'Payment_Summary_' + pay_period.replace(/, /g, '_'),
                exportOptions: {
                    columns: ':not(.notexport)'
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="la la-file-excel-o"></i> CSV',
                className: 'btn btn-sm btn-default',
                title: 'Payment Summary for ' + pay_period,
                filename: 'Payment_Summary_' + pay_period.replace(/, /g, '_'),
                exportOptions: {
                    columns: ':not(.notexport)'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i> PDF',
                className: 'btn btn-sm btn-default',
                title: 'Payment Summary for ' + pay_period,
                filename: 'Payment_Summary_' + pay_period.replace(/, /g, '_'),
                exportOptions: {
                    columns: ':not(.notexport)'
                }
            }
        ],
        columnDefs: [
            {
                "targets": 1,
                "orderable": false,
                "searchable": false
            }
        ],
        columns: [
            { data: 'action', name: 'action', className: 'text-left' },
            { data: 'code', name: 'code' },
            { data: 'fullname', name: 'fullname' },
            { data: 'center_name', name: 'center_name' },
            { data: 'bank', name: 'bank' },
            { data: 'account_no', name: 'account_no' },
            { data: 'net_pay', name: 'net_pay' },
        ],
        drawCallback: function(settings) {
            var api = this.api();
            api.rows().every(function() {
                var row = $(api.row(this).node());
                var data = this.data();

                // Add table-danger class if net_pay <= 0
                if (parseFloat(data.net_pay) <= 0) {
                    row.addClass('table-danger');
                }
            });
        }
    });

    // Reload DataTable on filter change
    $('#pay_period, #center_id, #farmer_id, #bank_id').on('change', function () {
        all_payments_table.ajax.reload();
    });

    // Handle center change to populate farmers
    $('#center_id').on('change', function() {
        var centerId = $(this).val();

        // Clear farmer details and farmer select options
        $('#farmer_id').val('');
        $('#farmer_name').val('');
        $('#farmer_id').empty().append('<option value="">Choose one</option>');

        if (centerId) {
            $.ajax({
                url: '/sales/getFarmersByCenter/' + centerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#farmer_id').append('<option value="'+ value.id +'">'+ value.fname +' '+ value.lname +' - '+ value.farmerID +'</option>');
                    });
                },
                error: function() {
                    alert('Failed to retrieve farmers. Please try again.');
                }
            });
        }
    });

    // Handle farmer change to populate farmer details
    $('#farmer_id').on('change', function() {
        var farmerId = $(this).val();

        if (farmerId) {
            $.ajax({
                url: '/sales/getFarmerDetails/' + farmerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#farmer_id').val(data.id);
                    $('#farmer_code').val(data.farmerID);
                    $('#farmer_name').val(data.fname + ' ' + data.lname);
                    // Add more fields as necessary
                },
                error: function() {
                    alert('Failed to retrieve farmer details. Please try again.');
                }
            });
        } else {
            $('#farmer_id').val('');
            $('#farmer_name').val('');
        }
    });

    // Handle print payslip button click
    $('#all_payments_table').on('click', '.print-payslip', function() {
        var pay_period = $('#pay_period').val();
        var farmer_id = $(this).data('farmer-id'); // Get the farmer ID from the button's data attribute
        var record_id = $(this).data('record-id');

        $.ajax({
            url: '/payments/print-payslip', // Adjust this URL to your route
            type: 'POST',
            data: {
                pay_period: pay_period,
                farmer_id: farmer_id,
                record_id: record_id,
                _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
            },
            success: function(response) {
                // Handle the response from the server
                if (response.pdfUrl) {
                    window.open(response.pdfUrl, '_blank'); // Open the PDF in a new tab
                } else {
                    alert('Failed to print payslip');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    });
});

</script>
@endsection