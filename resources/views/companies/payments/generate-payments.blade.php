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
<form id="generatePayeeReport" action="{{url('payslip-exports/generate-payee-report')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="paye_period" value="{{ date('Y-m') }}" id="pay_period">
            </div>
        </div>
        <input type="hidden"  value="" name="action" id="action">
         
    </div>
</form>
<div class="row">
    <hr>

    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="generate_payments_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Milk</th> 
                        <th>Stores Deductions</th>
                        <th>Individual Deductions</th>
                        <th>General Deductions</th>
                        <th>Shares</th>
                        <th>Previous Dues</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="bulk_generate" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Generate Payslip</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="bulk_payslip_form" action="{{url('/payslip-exports/bulk-print-payslip')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pay Period <span class="text-danger">*</span></label>
                            <input class="form-control" type="month" name="pay_period" required>
                        </div>
                    </div>
                    
    
                    <div class="col-sm-6">
                        <br><button class="btn btn-primary submit-btn">Submit</button>
                        <div class="alert alert-warning warning">Please wait... Based on the number of staff in your database, this operation might take time<br> Please DO NOT close this window.</div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

</div>

<div id="bulk_email" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Email Payslip</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="bulk_email_form" action="{{url('/payslip-exports/bulk-email-payslip')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pay Period <span class="text-danger">*</span></label>
                            <input class="form-control" type="month" name="pay_period" required>
                        </div>
                    </div>
                    
    
                    <div class="col-sm-6">
                        <br><button class="btn btn-primary submit-btn">Submit</button>
                        <div class="alert alert-warning warning">Please wait... Based on the number of staff in your database, this operation might take time<br> Please DO NOT close this window.</div>
                    </div>
                </div>
                
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
        
        $(document).on('click', '#bulk_email_btn', function () {
            $('#bulk_email').modal("show");
        });
    
        generate_payments_table = $('#generate_payments_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('payments/generate-payments')}}",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'fullname', name: 'fullname'},
                {data: 'total_milk', name: 'total_milk'},
                {data: 'total_store_deductions', name: 'total_store_deductions'},
                {data: 'total_individual_deductions', name: 'total_individual_deductions'},
                {data: 'total_general_deductions', name: 'total_general_deductions'},
                {data: 'total_shares', name: 'total_shares'},
                // {data: 'total_previous_dues', name: 'total_previous_dues'}, 
                // {data: 'net_pay', name: 'net_pay'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        $('#pay_period').change(function() {
            generate_payments_table.ajax.reload();
        });

    });

    function setAction(action) {
        $('#action').val(action);
    }

        $(document).ready(function() {
        $('#generatePayeeReport').submit(function(e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    if($("#action").val() == 'print'){
                        $("#print_content").html(response);
                        $('#print_content').show().printThis({
                            importCSS: true,
                            afterPrint: function() {
                                $('#print_content').hide();
                            }
                        });
                    }else{
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        window.open(pdfUrl, '_blank');
                    }
                    
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                }
            });
        });
    });


</script>

@endsection