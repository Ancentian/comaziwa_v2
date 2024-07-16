


<?php $__env->startSection('content'); ?>
<style>
    #individual_deduction, #general_deduction {
        display: none;
    }
</style>
<input type="hidden" id="reload_page">
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Add Deduction</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Select Deduction Type <span class="text-danger">*</span></label>
            <select class="form-control select" id="deduction_type" name="deduction_type" required>
                <option id="" >--Choose Here--</option>
                <option id="individual" value="individual">Individual</option>
                <option id="general" value="general">General</option>
            </select>
            <span class="modal-error invalid-feedback" role="alert"></span>
        </div>
    </div> 
    <!-- Error message -->
    <div id="error_message" class="col-md-12 alert alert-danger">
        Please select a deduction type.
    </div>
    
    <div class="col-md-12" id="individual_deduction">
        <!-- Individual Deduction Form -->
        <form id="add_deduction_form"  action="<?php echo e(url('deductions/store-deduction')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="text" name="deduction_type" value="individual" hidden>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Select Center</label>
                    <select class="form-control select" name="center_id" id="center_id" required>
                        <option value="">Choose one</option>
                        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->center_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="form-group col-sm-4">
                    <label>Select Farmer</label>
                    <select class="form-control select" name="farmer_id" id="farmer_id_select" required>
                        <option value="">Choose one</option>
                        <?php $__currentLoopData = $farmers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->fname.' '.$key->lname.' - '.$key->farmerID); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-sm-4">  
                    <div class="form-group">
                        <label class="col-form-label">Deduction Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="date" type="text" required>
                        </div>
                    </div>
                </div>   
            </div>
            <hr>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Code</label>
                    <input type="text" class="form-control" id="farmer_code" readonly>
                </div>
                <div class="form-group col-sm-4">
                    <label>Name</label>
                    <input type="text" class="form-control"  id="farmer_name" readonly>
                </div>
            </div>
            <div id="course_details">            
                <div class="row">
                    <h4 class="text-center w-100">Farmers</h4>
                    <div class="col-md-12">
                        <table class="table table-striped custom-table mb-0" id="add_deductions_table">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th style="width: 35%;">Deduction</th>
                                    <th style="width: 20%;">Unit Cost</th>
                                    <th style="width: 25%;">Amount</th>
                                    <th style="width: 10%;"></th>
                                </tr>
                            </thead>                            
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select name="deduction_id[]" class="form-control select deduction-select" required>
                                            <option value="">Select Deduction</option>
                                            <?php $__currentLoopData = $individual_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td><input class="form-control deduction_cost" type="text" name="unit_cost[]" required readonly></td>
                                    <td><input class="form-control total" type="text" name="amount[]" value="0" readonly></td>
                                    <td><a href="javascript:void(0)" class="text-success font-18 add-deduction-btn" title="Add"><i class="fa fa-plus"></i></a></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: bold">
                                        Grand Total
                                    </td>
                                    <td style="font-size: 16px;">
                                        <input class="form-control text-right" type="text" id="grand_total" name="" value="Ksh. 0.00" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="col-md-12" id="general_deduction">
        <div class="row">
			<div class="col-sm-12">
				<form class="general_deduction_form" action="<?php echo e(url('deductions/store-general-deduction')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label>Date <span class="text-danger">*</span></label>
								<div class="cal-icon">
									<input class="form-control datetimepicker" type="text" id="" name="date" required>
								</div>
							</div>
						</div>
					</div>
					<input type="text" name="deduction_type" value="general" hidden>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-hover table-white" id="tableEstimate">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px">#</th>
                                            <th><input type="checkbox" id="checkAll"> Check All</th>
                                            <th hidden></th>
                                            <th class="col-sm-3">Deduction</th>   
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $general_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(++$i); ?></td>
                                            <td><input type="checkbox" class="deduction-checkbox" name="check_box[]" checked value="1"></td>
                                            <td hidden>
                                                <input class="form-control" type="text" name="deduction_id[]" value="<?php echo e($key['id']); ?>" readonly>
                                            </td>
                                            <td><input class="form-control"  type="text" value="<?php echo e($key['name']); ?>" readonly></td>
                                            <td><input class="form-control total" type="text" name="amount[]" value="<?php echo e($key['amount']); ?>" readonly></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
							</div>
							<div class="table-responsive">
								<table class="table table-hover table-white">
									<tbody>
										<tr>
											<td colspan="5" style="text-align: right; font-weight: bold">
												Grand Total
											</td>
											<td style="font-size: 16px;width: 230px">
												<input class="form-control text-right" type="text" id="grand_total" name="" value="Ksh. 0.00" readonly>
											</td>
										</tr>
									</tbody>
								</table>                               
							</div>
						</div>
					</div>
					<div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn" id="general_submit">Submit</button>
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
        $('#deduction_type').change(function(){
            var deductionType = $(this).val();
            if(deductionType == 'individual') {
                $('#individual_deduction').show();
                $('#general_deduction').hide();
                $('#error_message').hide();
            } else if(deductionType == 'general') {
                $('#individual_deduction').hide();
                $('#general_deduction').show();
                $('#error_message').hide();
            } else {
                $('#individual_deduction').hide();
                $('#general_deduction').hide();
                $('#error_message').show();
            }
        });

        // Function to check the checkbox state and enable/disable the submit button
        function checkCheckboxes() {
            if ($('.deduction-checkbox:checked').length == 0) {
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
            $('.deduction-checkbox').prop('checked', isChecked);
            $('.deduction-checkbox').each(function() {
                $(this).val(isChecked ? 1 : 0);
            });
            checkCheckboxes(); // Check the state after changing all checkboxes
        });

        // Attach change event listener to individual checkboxes
        $('.deduction-checkbox').change(function() {
            $(this).val($(this).is(':checked') ? 1 : 0);
            checkCheckboxes(); // Check the state after changing individual checkbox
        });
    });
     
    // Start Add Multiple Shop Items
    $(document).ready(function() {
    var rowIdx = 1;

    // Add new row
    $("#add_deductions_table").on("click", ".add-deduction-btn", function() {
        $('.select').select2();
        var newRow = `
        <tr id="R${++rowIdx}">
            <td class="row-index text-center"><p>${rowIdx}</p></td>
            <td>
                <select name="deduction_id[]"  class="form-control select deduction-select" required>
                    <option value="">Select Deduction</option>
                    <?php $__currentLoopData = $individual_deductions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td><input class="form-control deduction_cost"  type="text" name="amount[]" required readonly></td>
            <td><input class="form-control total" type="text" name="total_cost[]" value="0" readonly></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fa fa-trash-o"></i></a></td>
        </tr>`;
        $("#add_deductions_table tbody").append(newRow);
        // Reinitialize Select2 on the new select elements
        $('.select').select2();
    });


// Handle Deduction change
$("#add_deductions_table").on("change", ".deduction-select", function() {
    var dedId = $(this).val();
    var $row = $(this).closest("tr");

    if (dedId) {
        $.ajax({
            url: '/deductions/get-deduction-details/' + dedId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $row.find(".deduction_cost").val(data.amount);
                console.log(data);
                calculateTotal($row);
            }
        });
    } else {
        $row.find(".deduction_cost").val('');
        calculateTotal($row);
    }
});

// Calculate total amount for a row
function calculateTotal($row) {
    var unitCost = parseFloat($row.find(".deduction_cost").val()) || 0; 
    $row.find(".total").val(unitCost.toFixed(2)); 
    calc_total(); 
}

// Calculate grand total
function calc_total() {
    var sum = 0;
    $(".total").each(function () {
        sum += parseFloat($(this).val()) || 0; 
    });
    $("#grand_total").val(sum.toFixed(2)); 
    $(".subtotal").text(sum.toFixed(2)); 
}


// Remove row
$("#add_deductions_table").on("click", ".remove", function() {
    var $row = $(this).closest("tr");
    $row.remove();
    calc_total();
});

});




    // End Add Multiple Shop Items
    $(document).ready(function() {
    $('#center_id').on('change', function() {
        var centerId = $(this).val();

        // Clear farmer details and farmer select options
        $('#farmer_id').val('');
        $('#farmer_name').val('');
        $('#farmer_id_select').empty().append('<option value="">Choose one</option>');

        if (centerId) {
            $.ajax({
                url: '/sales/getFarmersByCenter/' + centerId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#farmer_id_select').append('<option value="'+ value.id +'">'+ value.fname +' '+ value.lname +' - '+ value.farmerID +'</option>');
                    });
                }
            });
        }
    });

    $('#farmer_id_select').on('change', function() {
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
                }
            });
        } else {
            $('#farmer_id').val('');
            $('#farmer_name').val('');
        }
    });
});
    //Add Sales
    $(document).ready(function(){       
        // Handle form submission
        $('#add_deduction_form, .general_deduction_form').on('submit', function (e) {
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
                    window.location.href = "<?php echo e(route('deductions.index')); ?>";
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!', 'Error');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/deductions/add-deduction.blade.php ENDPATH**/ ?>