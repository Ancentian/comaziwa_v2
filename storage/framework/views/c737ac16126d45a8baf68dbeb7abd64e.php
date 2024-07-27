

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Share Contributions Report</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
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
            <table class="table table-striped custom-table" id="shares_report_table">
                <thead>
                    <tr>
                        <th class="text-left no-sort">Action</th>
                        <th>Name</th>
                        <th>Center</th>
                        <th>Total Shares</th> 
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
//Save Cooperative Farmers
$(document).ready(function(){
    
    $('#add_shares_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('shares/store-shares')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                shares_report_table.ajax.reload();
                
                // Close the modal
                $('#add_shares').modal('hide');
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
    $(document).on('change', ' #center_id, #farmer_id', function () {
        shares_report_table.ajax.reload();
    })
    shares_report_table = $('#shares_report_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('analysis/shares-contribution-report')); ?>",
                data: function(d){
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
                {data: 'fullname', name: 'fullname'}, 
                {data: 'center_name', name: 'center_name'},
                {data: 'total_shares', name: 'total_shares'},
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
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/reports/shares-contribution-report.blade.php ENDPATH**/ ?>