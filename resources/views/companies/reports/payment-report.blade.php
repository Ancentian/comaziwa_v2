@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Payments Report</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{route('payments.generate-payments')}}" class="btn btn-info" ><i class="fa fa-plus"></i> Generate Payment</a> &nbsp;
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#import" hidden><i class="fa fa-download"></i> Import</a> &nbsp;
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
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="all_payments_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Farmer</th>
                        <th>Center</th>
                        <th>Bank</th>
                        {{-- <th>Pay Period</th> --}}
                        <th>Total Milk</th>
                        <th>Milk Rate</th>
                        <th>Store Deductions</th>
                        <th>Individual Deductions</th>
                        <th>General Deductions</th>
                        <th>Shares Deduction</th>
                        <th>Total Deductions</th>
                        <th>Previous Dues</th>
                        <th>Gross Pay</th>
                        <th>Net Pay</th>
                        <th>Created On</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
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


$(document).ready(function(){
    // $('#daterange').daterangepicker({
    //     opens: 'bottom',
    //     ranges: ranges
    // }, function(start, end, label) {
    //     all_payments_table.ajax.reload();
    // });

    $(document).on('change', '#pay_period, #center_id, #farmer_id', function () {
        all_payments_table.ajax.reload();
    })

    all_payments_table = $('#all_payments_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('analysis/payments-report')}}",
                data: function(d){
                d.pay_period = $("#pay_period").val();
                d.center_id = $("#center_id").val();
                d.farmer_id = $("#farmer_id").val();
                    
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
                {data: 'bank', name: 'bank'},
                {data: 'total_milk', name: 'total_milk'},
                {data: 'milk_rate', name: 'milk_rate'},
                {data: 'store_deductions', name: 'store_deductions'},
                {data: 'individual_deductions', name: 'individual_deductions'},
                {data: 'general_deductions', name: 'general_deductions'},
                {data: 'shares_contribution', name: 'shares_contribution'},
                {data: 'total_deductions', name: 'total_deductions'},
                
                {data: 'previous_dues', name: 'previous_dues'},
                {data: 'gross_pay', name: 'gross_pay'},
                {data: 'net_pay', name: 'net_pay'},
                {data: 'created_on', name: 'created_on'},              
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    $(document).ready(function() {
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
});

    
</script>

@endsection