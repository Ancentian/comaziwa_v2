

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Collection Report</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="<?php echo e(url('milkCollection/add-collection')); ?>" class="btn btn-info" ><i class="fa fa-plus"></i> Add Milk Collection</a> &nbsp;
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#import" hidden><i class="fa fa-download"></i> Import</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Date Range <span class="text-danger">*</span></label>
            <input type="text" readonly id="daterange" class="form-control" value="<?php echo e(date('m/01/Y')); ?> - <?php echo e(date('m/t/Y')); ?>" />
        </div>
    </div>
    <div class="form-group col-sm-6">
        <label for="farmer_id">Select Farmer</label>
        <select class="form-control select" name="farmer_id" id="farmer_id"  required>
            <option value="">Choose one</option>
           <?php $__currentLoopData = $farmers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $farmer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($farmer->id); ?>"><?php echo e($farmer->fname." ".$farmer->lname." - ".$farmer->farmerID); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="collected_milk_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th class="text-center">Code</th>
                        <th>Center</th>
                        <th>Col. Date</th>
                        <th>Morning</th>
                        <th>Evening</th>
                        <th>Rejected</th>
                        <th>Total</th>					
                        <th>Created at</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>



<div id="import" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Milk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                   
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-4 pull-right">
                            <a href="<?php echo e(asset('files/employee-import.xlsx')); ?>" class="btn btn-primary" download><i class="fa fa-download"></i> Download Template</a>
                        </div>
                    </div>
                    <form id="import_employee_form"  enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="form-group">
                            <input type="file" name="csv_file" class="form-control" required>
                        </div>
                       
                        <div class="form-group mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><span id="btn_employee_import">Import</span> <i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>


<!-- Add Allowance Modal -->
<div id="bulk_generate" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Generate Payslip</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="bulk_payslip_form" action="<?php echo e(url('/employees/bulk-generate-monthly-payslip')); ?>" method="POST">
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
    
    $(document).on('click', '#add_employee_btn', function () {
        var actionuRL = "<?php echo e(url('/employees/create')); ?>";
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

//Save Cooperative Farmers
$(document).ready(function(){
    
    $('#add_farmer_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('cooperative/store-farmers')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                collected_milk_table.ajax.reload();
                
                // Close the modal
                $('#add_farmer').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

});

$(document).ready(function(){

    var currentUrl = window.location.href;
    var centerId = currentUrl.split('/').pop();

    $('#daterange').daterangepicker({
        opens: 'bottom',
        ranges: ranges
    }, function(start, end, label) {
        collected_milk_table.ajax.reload();
    });

    $(document).on('change', ' #farmer_id', function () {
        collected_milk_table.ajax.reload();
    })

    collected_milk_table = $('#collected_milk_table').DataTable({
        <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        processing: true,
        serverSide: false,
        ajax: {
            url : "<?php echo e(url('analysis/collection-center-report')); ?>" + "/" + centerId,
            data: function(d){
            // Access the start and end dates from the date range picker
            var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
            
            // Add the dates as parameters to the request
            d.start_date = startDate;
            d.end_date = endDate;
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
            {data: 'collection_date', name: 'collection_date'},
            {data: 'morning', name: 'morning'},
            {data: 'evening', name: 'evening'},
            {data: 'rejected', name: 'rejected'},
            {data: 'total', name: 'total'},
            // {data: 'userName', name: 'userName'},
            {data: 'created_on', name: 'created_on'},            
        ],
        createdRow: function( row, data, dataIndex ) {
        }
    });

});  
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/reports/collection-center-report.blade.php ENDPATH**/ ?>