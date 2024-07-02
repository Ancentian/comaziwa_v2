<?php $__env->startSection('content'); ?>
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
<form id="generatePayeeReport" action="<?php echo e(url('payslip-exports/generate-payee-report')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="paye_period" value="<?php echo e(date('Y-m')); ?>" id="pay_period">
            </div>
        </div>
        <input type="hidden"  value="" name="action" id="action">
        <div class="col-md- mt-4">
            <button type="submit" class="btn btn-primary" name="button" value="print" onclick="setAction('download')"><i class="fa fa-print"></i> Print </button> &nbsp;
            <button type="submit" class="btn btn-primary" name="button" value="download" onclick="setAction('download')"><i class="fa fa-download"></i> PDF</button>
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
                        <th class="notexport">Action</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>SSN.</th>
                        <th>Basic Salary</th>
                        <th>PAYE</th>
                        <th>Tier 1</th>
                        <th>Tier 2</th>
                        <th>Allowances</th>
                        <th>Benefits</th>
                        <th>Statutory Deductions</th>
                        <th>Non Statutory Deductions</th>
                        <th>Net Salary</th>
                    </tr>
                    <tr>
                        <td colspan="13">
                            <button type="button" id="bulk_generate_btn" class="badge btn-danger">Print All Payslips</button>
                            &nbsp;
                            <button type="button" id="bulk_email_btn" class="badge btn-primary">Email All Payslips</button>
                        </td>
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
            <form id="bulk_payslip_form" action="<?php echo e(url('/payslip-exports/bulk-print-payslip')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
            <form id="bulk_email_form" action="<?php echo e(url('/payslip-exports/bulk-email-payslip')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
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
    
        paye_report_table = $('#paye_report_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('payslip-reports/paye')); ?>",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                }
            },
            
            columns: [
                {data: 'action', name: 'action'},
                {data: 'name', name: 'name'},
                {data: 'position', name: 'position'},
                {data: 'ssn', name: 'ssn'},
                {data: 'basic_salary', name: 'basic_salary'},
                {data: 'paye', name: 'paye'}, 
                {data: 'tier_one', name: 'tier_one'}, 
                {data: 'tier_two', name: 'tier_two'}, 
                {data: 'allowances', name: 'allowances'}, 
                {data: 'benefits', name: 'benefits'}, 
                {data: 'statutory_deductions', name: 'statutory_deductions'}, 
                {data: 'nonstatutory_deductions', name: 'nonstatutory_deductions'}, 
                {data: 'net_pay', name: 'net_pay'},   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

        $('#pay_period').change(function() {
            paye_report_table.ajax.reload();
        });

        $(document).on('click', '.print-report', function (e) {
            e.preventDefault();

            var url = $(this).data('href');
            var action = $(this).data('string');
            console.log(url);
            $.ajax({
                url: url, 
                method: 'GET', 
                dataType: 'html',           
                success: function (response) {
                
                    if(action == 'print'){
                        // $("#print_content").html(response);
                        // $('#print_content').show().printThis({
                        //     importCSS: true,
                        //     afterPrint: function() {
                        //         $('#print_content').hide();
                        //     }
                        // });
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        console.log(pdfUrl);
                        $("#pdfViewer").attr("src", pdfUrl);

                        // Show the embed once the PDF is loaded
                        $("#pdfViewer").on("load", function() {
                            $(this).show();
                
                            // Trigger the print function once the PDF is loaded
                            window.frames['pdfViewer'].focus();
                            window.frames['pdfViewer'].print();
                        });

                    }else{
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        window.open(pdfUrl, '_blank');
                    }
                    

                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
        
        $(document).on('click', '.email-report', function (e) {
            e.preventDefault();

            var url = $(this).data('href');
            var action = $(this).data('string');
            console.log(url);
            $.ajax({
                url: url, 
                method: 'GET', 
                dataType: 'html',           
                success: function (response) {
                    toastr.success('Success','Payslip emailed successfully');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
        
        $(document).on('submit', '#bulk_payslip_form', function (e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var formData = $(this).serialize();
            
            $(".warning").show();
            $(".submit-btn").hide();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $(".warning").hide();
                    $(".submit-btn").show();
                    var pdfUrl = JSON.parse(response).pdfUrl;
                    window.open(pdfUrl, '_blank');
                    
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                    
                    $(".warning").hide();
                    $(".submit-btn").show();
                }
            });
        });
        $(document).on('submit', '#bulk_email_form', function (e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var formData = $(this).serialize();
            
            $(".warning").show();
            $(".submit-btn").hide();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    $(".warning").hide();
                    $(".submit-btn").show();
                    toastr.success('Success','Payslips emailed successfully');
                    
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                    
                    $(".warning").hide();
                    $(".submit-btn").show();
                }
            });
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/payslip_reports/paye.blade.php ENDPATH**/ ?>