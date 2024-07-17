

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Sales</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="<?php echo e(url('milkCollection/add-collection')); ?>" class="btn btn-info" ><i class="fa fa-plus"></i> Add Milk Collection</a> &nbsp;
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#import"><i class="fa fa-download"></i> Import</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Date Range <span class="text-danger">*</span></label>
            <input type="text" readonly id="daterange" class="form-control" value="<?php echo e(date('m/01/Y')); ?> - <?php echo e(date('m/t/Y')); ?>" />
        </div>
    </div>
    <div class="form-group col-sm-4">
        <label for="center_id">Select Center</label>
        <select class="form-control select" name="center_id" id="center_id" required>
            <option value="">Choose one</option>
            <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($center->id); ?>"><?php echo e($center->center_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <table class="table table-striped custom-table" id="all_sales_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        
                        <th>Name</th>
                        <th>Center</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Cost</th>
                        <th>Total Cost</th>
                        <th>Date</th>					
                        
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
                <h5 class="modal-title">Import Employee</h5>
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


$(document).ready(function(){
    $('#daterange').daterangepicker({
        opens: 'bottom',
        ranges: ranges
    }, function(start, end, label) {
        all_sales_table.ajax.reload();
    });

    $(document).on('change', ' #center_id, #farmer_id', function () {
        all_sales_table.ajax.reload();
    })

    all_sales_table = $('#all_sales_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('sales/index')); ?>",
                data: function(d){
                    // Access the start and end dates from the date range picker
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                
                // Add the dates as parameters to the request
                d.start_date = startDate;
                d.end_date = endDate;
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
                // {data: 'farmerID', name: 'farmerID'},
                {data: 'fullname', name: 'fullname'},
                {data: 'center_name', name: 'center_name'},
                {data: 'product_name', name: 'product_name'},
                {data: 'qty', name: 'qty'},
                {data: 'unit_cost', name: 'unit_cost'},
                {data: 'total_cost', name: 'total_cost'},
                {data: 'order_date', name: 'order_date'},
                // {data: 'userName', name: 'userName'},
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/sales/index.blade.php ENDPATH**/ ?>