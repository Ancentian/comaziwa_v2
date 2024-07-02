@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Reports</a></li>
                <li class="breadcrumb-item active">Net Pay to Bank</li>
            </ul>
        </div>       
    </div>
</div>
<!-- /Page Header -->

<form id="printPaye" action="{{ url('payslip-exports/print-bank-net-pay') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="pay_period" value="{{ date('Y-m') }}" id="pay_period">
            </div>
        </div>
        <input type="hidden"  value="" name="action" id="action">
        <div class="col-md- mt-4">
            <button type="submit" class="btn btn-primary print-report" name="button" value="print" onclick="setAction('download')"><i class="fa fa-print"></i> Print </button> &nbsp;
            <button type="submit" class="btn btn-primary" name="button" value="download" onclick="setAction('download')"><i class="fa fa-download"></i> Download</button>
        </div>          
    </div>
</form>


<div class="row">
    <hr>
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="paye_report_table">
                <thead>
                    <tr>
                        
                        <th>SSN.</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Account No</th>
                        <th>Amount</th>
                        <th>Beneficiary Name</th>
                        <th>Beneficiary Ref</th>
                        <th>Bank Name</th>
                        <th>Branch Shortcode</th>
                        <th>Branch Name</th>               
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
        paye_report_table = $('#paye_report_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('staff/bank-net-pay')}}",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                }
            },
            
            columns: [
                {data: 'ssn', name: 'ssn'},
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'account_no', name: 'account_no'}, 
                {data: 'net_pay', name: 'net_pay'}, 
                {data: 'name', name: 'name'}, 
                {data: 'basic_salary', name: 'basic_salary'}, 
                {data: 'bank_name', name: 'bank_name'}, 
                {data: 'branch_shortcode', name: 'branch_shortcode'}, 
                {data: 'branch_name', name: 'branch_name'}, 
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        $('#pay_period').change(function() {
            paye_report_table.ajax.reload();
        });

});

    function setAction(action) {
        document.getElementById('action').value = action;
    }

        $(document).ready(function() {
        $('#printPaye').submit(function(e) {
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
                    console.error(error);
                }
            });
        });
    });
</script>

@endsection