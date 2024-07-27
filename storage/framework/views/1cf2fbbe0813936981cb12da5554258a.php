

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Share Settings</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_shares_settings"><i class="fa fa-plus"></i> Add Setting</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="shares_settings_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Share Value</th> 
                        <th>Accumulative Amount</th>
                        <th>Status</th>
                        <th>Created at</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="add_shares_settings" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shares Configuration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_shares_settings_form" method="POST">
                    <?php echo csrf_field(); ?>    
                    <div class="row"> 
                        <div class="col-sm-6" hidden>
                            <div class="form-group">
                                <label>Share Code</label>
                                <input class="form-control" type="text" value="<?php echo e(substr(mt_rand(1000000, 9999999), 0, 7)); ?>" name="shares_code" required >
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Share Name<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="shares_name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Share Contribution <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="deduction_amount" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Accumulative Contribution <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" name="accumulative_amount" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                         
                        <div class="col-sm-12">  
                            <div class="form-group">
                                <label class="col-form-label">Description <span class="text-danger"></span></label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
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
    
    $('#add_shares_settings_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('shares/store-shares-settings')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                shares_settings_table.ajax.reload();
                
                // Close the modal
                $('#add_shares_settings').modal('hide');
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
    shares_settings_table = $('#shares_settings_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('shares/all-shares-settings')); ?>",
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
                {data: 'shares_code', name: 'shares_code'}, 
                {data: 'shares_name', name: 'shares_name'},
                {data: 'accumulative_amount', name: 'accumulative_amount'},
                {data: 'deduction_amount', name: 'deduction_amount'},
                {data: 'status', name: 'status'},
                {data: 'created_on', name: 'created_on'},

            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/shares/shares-settings.blade.php ENDPATH**/ ?>