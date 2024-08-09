


<?php $__env->startSection('content'); ?>
<input type="hidden" id="reload_page">
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Add Milk Consumption</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12" id="general_deduction">
        <div class="row">
			<div class="col-sm-12">
				<form id="add_consumption_form" action="<?php echo e(route('store-consumption')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text" id="condate" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Milk Produced</label>
                                <input type="text" class="form-control" id="daily_production" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-hover table-white" id="tableEstimate">
                        <thead>
                            <tr>
                                <th class="text-success"> <input id="checkAll" type="checkbox"> Check All to Include</th>
                                <th hidden></th>
                                <th>Activity</th>
                                <th class="col-md-6">Description</th>
                                <th class="col-sm-3">Qty(Ltrs)</th>
                                <th class="col-md-3">Rate</th>	
                                <th>Total</th>	
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $consumers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="consumption-checkbox" name="check_box[]" checked>
                                    <input type="hidden" class="checkbox-value" name="check_box_value[]" value="1">
                                </td>
                                <td hidden>
                                    <input class="form-control"style="min-width:150px" type="text" name="category_id[]" value="<?php echo e($key->id); ?>" >
                                </td>
                                <td><input class="form-control"style="min-width:150px" type="text" id="activity" value="<?php echo e($key->name); ?>" readonly></td>
                                <td><input class="form-control"style="min-width:150px" type="text" id="comments" name="comments[]"></td>
                                <td><input class="form-control"style="min-width:150px" type="number" id="quantity" name="quantity[]"></td>
                                <td><input class="form-control"style="min-width:150px" type="number" id="rate" name="rate[]"></td>
                                <td><input class="form-control total" style="width:120px" type="text" id="amount" name="amount[]" value="0" readonly></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary submit-btn" id="general_submit">Add Consumption</button>
                        <button type="button" class="btn btn-danger submit-btn delete-event" data-dismiss="modal">Close</button>
                    </div>
                </form>
			</div>
		</div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    //Add Consumption
$(document).ready(function(){       
    // Handle form submission
    $('#add_consumption_form').on('submit', function (e) {
        e.preventDefault();

        var form = $(this);
        var frm = this;
        var formData = form.serialize();
        var url = form.attr('action');
        console.log(formData);
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                console.log(response);
                frm.reset();
                
                // Redirect or show success message
                window.location.href = "<?php echo e(route('consumption-list')); ?>";
                toastr.success(response.message, 'Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                
                toastr.error('Something Went Wrong.!, Try again!', 'Error');
            }
        });
    });

     // Function to check the checkbox state and enable/disable the submit button
     function checkCheckboxes() {
        if ($('.consumption-checkbox:checked').length == 0) {
            $('#general_submit').prop('disabled', true);
        } else {
            $('#general_submit').prop('disabled', false);
        }
    }

    // Check initial state of checkboxes
    checkCheckboxes();

    // Attach change event listener to #checkAll
    $('#checkAll').change(function() {
        var isChecked = $(this).is(':checked');
        $('.consumption-checkbox').prop('checked', isChecked);
        $('.checkbox-value').each(function() {
            $(this).val(isChecked ? 1 : 0); // Update hidden input value
        });
        checkCheckboxes(); // Check the state after changing all checkboxes
    });

    // Attach change event listener to individual checkboxes
    $('.consumption-checkbox').change(function() {
        var isChecked = $(this).is(':checked');
        $(this).siblings('.checkbox-value').val(isChecked ? 1 : 0); // Update hidden input value
        checkCheckboxes(); // Check the state after changing individual checkbox
    });
});

$(document).ready(function() {
    console.log("Document ready!");

    // Initialize the datetimepicker if not already initialized
    if ($.fn.datetimepicker) {
        console.log("Initializing datetimepicker...");
        $('#condate').datetimepicker({
            format: 'YYYY-MM-DD' // Adjust the format as needed
        }).on('change.datetimepicker', function(e) {
            console.log("Date changed");
            var selected_date = $('#condate').val();
            console.log("Selected date:", selected_date);

            $.ajax({
                url: '/milk-management/daily-production', // Replace with your route
                method: 'GET',
                data: { date: selected_date },
                success: function(response) {
                    // Assuming response contains the total production
                    console.log('Success response:', response);
                    $('#daily_production').val(response.total_production);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching total production:', error);
                    $('#daily_production').val('Error fetching data');
                }
            });
        });
    } else {
        console.error("Datetimepicker plugin not found!");
    }
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/milk_management/consumers/add-consumption.blade.php ENDPATH**/ ?>