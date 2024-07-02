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

<form id="printPaye" action="<?php echo e(url('payslip-exports/print-paye-tax')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Pay Period <span class="text-danger">*</span></label>
                <input class="form-control" type="month" name="pay_period" value="<?php echo e(date('Y-m')); ?>" id="pay_period">
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
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>

$(document).ready(function(){
        paye_report_table = $('#paye_report_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('payslip-reports/paye-tax')); ?>",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                }
            },
            
            columns: [
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/payslip_reports/paye-tax.blade.php ENDPATH**/ ?>