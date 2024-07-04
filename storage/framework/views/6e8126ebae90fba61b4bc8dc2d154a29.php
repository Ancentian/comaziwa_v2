

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Units</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_product"><i class="fa fa-plus"></i> Add Product</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="inventories_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Alert Qty</th>
                        <th>BP</th>
                        <th>SP</th>
                        <th>Status</th>			
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_product" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_inventory_form" method="POST">
                    <?php echo csrf_field(); ?>    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Categories<span class="text-danger">*</span></label>
                                <select class="form-control select" name="category_id" required>
                                    <option value="">Choose one</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->cat_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Product Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Unit<span class="text-danger">*</span></label>
                                <select class="form-control select" name="unit_id" required>
                                    <option value="">Choose one</option>
                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->unit_name."".($key->unit_code)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Quantity<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="quantity" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Alert Quantity<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="alert_quantity" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Buying Price<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="buying_price" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Selling Price<span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="selling_price" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status<span class="text-danger">*</span></label>
                                <select class="form-control select" name="status" required>
                                    <option value="">Choose one</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" id="" cols="10" rows="3"></textarea>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>                     
                    </div>
    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit <span class="please-wait-message" style="display:none;">Please wait...</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
//Save Product
$(document).ready(function(){
    
    $('#add_inventory_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('inventory/store-inventory')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                inventories_table.ajax.reload();
                
                // Close the modal
                $('#add_product').modal('hide');
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
        inventories_table = $('#inventories_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('inventory/all-inventory')); ?>",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'},
                {data: 'name', name: 'name'},
                {data: 'cat_name', name: 'cat_name'}, 
                {data: 'unit_name', name: 'unit_name'},
                {data: 'quantity', name: 'quantity'},
                {data: 'alert_quantity', name: 'alert_quantity'},
                {data: 'selling_price', name: 'selling_price'},
                {data: 'buying_price', name: 'buying_price'},
                {data: 'status', name: 'status'},             
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/inventory/all_inventory.blade.php ENDPATH**/ ?>