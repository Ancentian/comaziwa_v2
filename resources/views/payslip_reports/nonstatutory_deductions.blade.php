@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Reports</a></li>
                <li class="breadcrumb-item active">Non Statutory Deductions</li>
            </ul>
        </div>       
    </div>
</div>
<!-- /Page Header -->

<form id="print_nonStatutory" action="{{url('payslip-exports/print-non-statutory')}}" method="POST">
    @csrf
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="pay_period" value="{{ date('Y-m') }}" id="pay_period">
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="form-group">
                <label>Statutory Deductions <span class="text-danger">*</span></label>
                <select class="form-control" name="non_ststutory" id="allowance">
                    @foreach($statutory as $one)
                        <option value="{{$one->id}}">{{$one->name}}</option>
                    @endforeach
                </select>
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
            <table class="table table-striped custom-table" id="nonstatutory_report_table">
                <thead>
                    <tr>                        
                        <th>Name</th>
                        <th>Position</th>
                        <th>SSN.</th>
                        <th>Non Statutory Deductions</th>
                        <th>Amount</th>
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
        nonstatutory_report_table = $('#nonstatutory_report_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('payslip-reports/non-statutory')}}",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                    d.allowance = $("#allowance").val();
                }
            },
            
            columns: [
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'ssn', name: 'ssn'},
                {data: 'allowance_name', name: 'allowance_name'},
                {data: 'value', name: 'value'},
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        $('#pay_period, #allowance').change(function() {
            nonstatutory_report_table.ajax.reload();
        });

    });

    function setAction(action) {
            document.getElementById('action').value = action;
        }

    $(document).ready(function() {
        $('#print_nonStatutory').submit(function(e) {
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