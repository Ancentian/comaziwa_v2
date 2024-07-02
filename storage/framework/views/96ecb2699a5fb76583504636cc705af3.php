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

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Pay Period <span class="text-danger">*</span></label>
            <select class="form-control" name="pay_period" id="pay_period">
                <?php
                $currentYear = date('Y');
                $startYear = $currentYear - 5;
                $endYear = $currentYear + 5;
                ?>
                <?php for($year = $startYear; $year <= $endYear; $year++): ?>
                    <option value="<?php echo e($year); ?>" <?php echo e($year == $currentYear ? 'selected' : ''); ?>>
                        <?php echo e($year); ?>

                    </option>
                <?php endfor; ?>
            </select>
        </div>
        
    </div>
    <hr>

    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="paye_report_table">
                <thead>
                    <tr>
                        <th class="notexport">Action</th>
                        <th>Pay Period</th>
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
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('staff/paye')); ?>",
                data: function(d){
                    d.pay_period = $("#pay_period").val();
                }
            },
            
            columns: [
                {data: 'action', name: 'action'},
                {data: 'pay_period', name: 'pay_period'},
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
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });

    });

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/reports/paye.blade.php ENDPATH**/ ?>