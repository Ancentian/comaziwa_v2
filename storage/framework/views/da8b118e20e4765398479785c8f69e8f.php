

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Assets</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_asset"><i class="fa fa-plus"></i> Add Asset</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="assets_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Asset</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Current Value</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Purchase Date</th>
                        <th>Created on</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_asset" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Asset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_asset_form" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label> Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control select" id="">
                                    <option value="">Choose one</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->category_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label> Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="asset_name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label class="col-form-label">Purchase Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="purchase_date" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Purchase Price<span class="text-danger">*</span></label>
                                <input class="form-control" name="purchase_price" type="number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Current Value<span class="text-danger">*</span></label>
                                <input class="form-control" name="current_value" type="number" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Location<span class="text-danger">*</span></label>
                                <input class="form-control" name="location" type="text" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" id="" class="form-control select">
                                    <option value="">--Select Status--</option>
                                    <option value="0">In Active</option>
                                    <option value="1">Active</option>
                                    <option value="2">Sold</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>File<span class="text-danger">*</span></label>
                                <input class="form-control" name="file" type="file" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description<span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" id="" rows="3"></textarea>
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
//Save Cooperative Farmers
$(document).ready(function(){
    $('#add_asset_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: '<?php echo e(url('assets/store-assets')); ?>',
            method: 'POST',
            data: formData,
            contentType: false, // Important for file upload
            processData: false, // Important for file upload
            success: function (response) {
                // Handle success response
                form.reset();
                assets_table.ajax.reload();

                // Close the modal
                $('#add_asset').modal('hide');
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
                } else {
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            }
        });
    });
});

$(document).ready(function(){
        assets_table = $('#assets_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('assets/all-assets')); ?>",
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
                {data: 'asset_name', name: 'asset_name'}, 
                {data: 'category_name', name: 'category_name'},
                {data: 'purchase_price', name: 'purchase_price'},
                {data: 'current_value', name: 'current_value'},
                {data: 'location', name: 'location'},
                {data: 'status', name: 'status'},
                {data: 'purchase_date', name: 'purchase_date'},
                {data: 'created_at', name: 'created_at'},            
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/assets/index.blade.php ENDPATH**/ ?>