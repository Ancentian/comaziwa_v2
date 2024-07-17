

<?php $__env->startSection('content'); ?>
<style>
    .hidden {
            display: none;
        }
</style>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Milk Spillages</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_spillage"><i class="fa fa-plus"></i> Add Spillage</a> &nbsp;
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="center_id">Center <span class="text-danger">*</span></label>
            <select class="form-control select" name="center_id" id="center_id">
                <option value="">Select Center</option>
                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->center_name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="milk_spillage_table">
                <thead>
                    <tr>
                        <th class="text-right">Action</th>
                        <th>Responsible</th>
                        <th>Date</th>
                        <th>Quantity</th>
                        
                        <th>Created on</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Spillage Modal -->
<div id="add_spillage" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Milk Spillage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_spillage_form">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_all">All Farmers <span class="text-danger">*</span></label>
                                <input type="checkbox" name="is_cooperative" id="is_cooperative" value="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="center_id">Center <span class="text-danger">*</span></label>
                                <select class="form-control select" name="center_id" id="center_id">
                                    <option value="">Select Center</option>
                                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->center_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quantity in Liters <span class="text-danger">*</span></label>
                                <input class="form-control" name="quantity" type="number" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" name="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Spillage Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$(document).ready(function(){

    $('#daterange').daterangepicker({
            opens: 'bottom',
            ranges: ranges
        }, function(start, end, label) {
            milk_spillage_table.ajax.reload();
        });

        $(document).on('change', ' #center_id', function () {
            milk_spillage_table.ajax.reload();
        })
    
    $('#add_spillage_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('milk-management/store-spillages')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                milk_spillage_table.ajax.reload();
                
                // Close the modal
                $('#add_spillage').modal('hide');
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


    $(document).ready(function() {
        // Function to handle the visibility of fields
        function toggleFields() {
            if ($('#is_cooperative').is(':checked')) {
                $('#center_id').parent().addClass('hidden');
                $('#center_id').val('');
            } else {
                $('#center_id').parent().removeClass('hidden');
            }

            if ($('#center_id').val() !== '') {
                $('#is_cooperative').parent().parent().addClass('hidden');
                $('#is_cooperative').prop('checked', false);
            } else {
                $('#is_cooperative').parent().parent().removeClass('hidden');
            }
        }

        // Initial call to set the correct visibility on page load
        toggleFields();

        // Event listeners to handle changes
        $('#is_cooperative').change(function() {
            toggleFields();
        });

        $('#center_id').change(function() {
            toggleFields();
        });
    });

$(document).ready(function(){
    $('#daterange').daterangepicker({
        opens: 'bottom',
        ranges: ranges
    }, function(start, end, label) {
        milk_spillage_table.ajax.reload();
    });

    $(document).on('change', ' #center_id', function () {
        milk_spillage_table.ajax.reload();
    })

    milk_spillage_table = $('#milk_spillage_table').DataTable({
        <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        processing: true,
        serverSide: false,
        ajax: {
            url : "<?php echo e(url('milk-management/milk-spillages')); ?>",
            data: function(d){
                // Access the start and end dates from the date range picker
                var startDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
                
                // Add the dates as parameters to the request
                d.start_date = startDate;
                d.end_date = endDate;
                d.center_id = $("#center_id").val();
                
            }
        },
        columnDefs:[{
                "targets": 1,
                "orderable": false,
                "searchable": false
            }],
        columns: [
            {data: 'action', name: 'action',className: 'text-left'}, 
            {data: 'responsible', name: 'responsible'},
            {data: 'date', name: 'date'},
            {data: 'quantity', name: 'quantity'},
            // {data: 'user', name: 'user'},
            {data: 'created_at', name: 'created_at'},
            {data: 'comments', name: 'comments'},
                            
        ],
        createdRow: function( row, data, dataIndex ) {
        }
    });

});

    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/milk_management/spillages/index.blade.php ENDPATH**/ ?>