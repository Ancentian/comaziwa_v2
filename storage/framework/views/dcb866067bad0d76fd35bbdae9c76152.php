


<?php $__env->startSection('content'); ?>

<input type="hidden" id="reload_page">
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Add Sales</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <form id="add_store_sales" action="<?php echo e(url('sales/store-sales')); ?>" method="POST">
            <?php echo csrf_field(); ?>
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
                        <label class="col-form-label">Order Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="order_date" type="text" required>
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
                        <table class="table table-striped custom-table mb-0" id="add_sales_table">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th style="width: 20%;">Category</th>
                                    <th style="width:30%;">Product</th>
                                    <th style="width: 10%;">Qty</th>
                                    <th style="width: 15%;">Unit Cost</th>
                                    <th style="width: 15%;">Amount</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <select name="category_id[]" style="min-width:150px" class="form-control select category-select" required>
                                            <option value="">Select Category</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key->id); ?>"><?php echo e($key->cat_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="item_id[]" style="min-width:150px" class="form-control select item-select" required>
                                            <option value="">Select Item</option>
                                        </select>
                                    </td>
                                    <td><input class="form-control qty" style="width:80px" type="text" name="qty[]" required></td>
                                    <td><input class="form-control unit_price" style="width:100px" type="text" name="unit_cost[]" required readonly></td>
                                    <td><input class="form-control total" style="width:120px" type="text" name="total_cost[]" value="0" readonly></td>
                                    <td><a href="javascript:void(0)" class="text-success font-18 add-sale-btn" title="Add"><i class="fa fa-plus"></i></a></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right; font-weight: bold">
                                        Grand Total
                                    </td>
                                    <td style="font-size: 16px;width: 230px">
                                        <input class="form-control text-right" type="text" id="grand_total" name="" value="Ksh. 0.00" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-white">
                            <tbody>
                                <tr>
                                    <td>
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment Mode <span class="text-danger"></span></label>
                                                <select name="payment_mode" class="select" required>
                                                    <option>Select Payment Mode</option>
                                                    <option value="1">Pay by Milk</option>
                                                    <option value="2">Pay Cash/Mpesa</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                               
                    </div>
                </div>
                <input type="text" name="description" hidden>
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    // $(document).on('change','#training_id',function(){
    //    $("#course_details").hide();
    //     var id = $(this).val();
    //     console.log(id);
    //     if(id){
    //         $("#milk_collection_table tbody").empty();
            
    //         $.ajax({
    //             url: "/milkCollection/center-farmers/"+id,
    //             method: 'GET',
    //             data: {},
    //             dataType: 'json',
    //             success: function(response) {
    //                 console.log(response)
    //                 $("#course_details").show();
                    
    //                 $("#course_id").val(response.training.course_id).trigger('change');
    //                 $("#venue_id").val(response.training.venue_id).trigger('change');
    //                 $("#facilitator_id").val(response.training.facilitator_id).trigger('change');
    //                 $("#room_id").val(response.training.room_id).trigger('change');
                    
    //                 if(response.parts){                           
    //                     $.each(response.parts, function( index, value ) {
                            
    //                       var tr = `
    //                             <tr>
    //                                 <td>` + value.farmerCode + ` - ` + value.fname + `</td>
    //                                 <td hidden><input type="text" class="form-control" name="farmer_id[]" value="`+value.farmer_id+`"></td>
    //                                 <td><input type="number" class="form-control morning" step="any" name="morning[]" value="0" id="farmerid" ></td>
    //                                 <td><input type="number" class="form-control evening" step="any" name="evening[]" value="0" id="evening" ></td>
    //                                 <td><input type="number" step="any" class="form-control rejected" name="rejected[]" value="0" id="reject" ></td>
    //                                 <td><input type="number" step="any" class="form-control total" name="total[]" id="total" readonly></td>
    //                             </tr>
    //                         `;
                            
    //                         $("#milk_collection_table tbody").append(tr);
                            
    //                         $("#confirmed_"+index).val(value.confirmed_status).trigger('change');
    //                         $("#agent_"+index).val(value.agent).trigger('change');
    //                     });
    //                 }
                    
                                        
    //             },
    //             error: function(xhr, status, error) {
    //                 toastr.error('Something Went Wrong!, Try again!','Error');
    //                 console.error(error);
    //             }
    //         });
    //     }


    //     $("#milk_collection_table tbody").on("input", ".morning, .evening, .rejected", function () {
    //         var $row = $(this).closest("tr");
    //         var morning = parseFloat($row.find(".morning").val()) || 0;
    //         var evening = parseFloat($row.find(".evening").val()) || 0;
    //         var rejected = parseFloat($row.find(".rejected").val()) || 0;
    //         var total = $row.find(".total");
    //         total.val((morning + evening) - rejected);
    //         //calc_total();
    //     });
       
    // });
    
    // Start Add Multiple Shop Items
    $(document).ready(function() {
    var rowIdx = 1;

    // Add new row
    $("#add_sales_table").on("click", ".add-sale-btn", function() {
        // Initialize Select2 on page load
        $('.select').select2();
        var newRow = `
        <tr id="R${++rowIdx}">
            <td class="row-index text-center"><p>${rowIdx}</p></td>
            <td>
                <select name="category_id[]" style="min-width:150px" class="form-control select category-select" required>
                    <option value="">Select Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key->id); ?>"><?php echo e($key->cat_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </td>
            <td>
                <select name="item_id[]" style="min-width:150px" class="form-control select item-select" required>
                    <option value="">Select Item</option>
                </select>
            </td>
            <td><input class="form-control qty" style="width:80px" type="text" name="qty[]" required></td>
            <td><input class="form-control unit_price" style="width:100px" type="text" name="unit_cost[]" required readonly></td>
            <td><input class="form-control total" style="width:120px" type="text" name="total_cost[]" value="0" readonly></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="fa fa-trash-o"></i></a></td>
        </tr>`;
        $("#add_sales_table tbody").append(newRow);
        // Reinitialize Select2 on the new select elements
        $('.select').select2();
    });

    // Handle category change
    $("#add_sales_table").on("change", ".category-select", function() {
        var categoryId = $(this).val();
        var $row = $(this).closest("tr");
        var $itemSelect = $row.find(".item-select");

        if (categoryId) {
            $.ajax({
                url: '/sales/getProductsByCategory/' + categoryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $itemSelect.empty();
                    $itemSelect.append('<option value="">Select Item</option>');
                    $.each(data, function(key, value) {
                        $itemSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $itemSelect.empty();
            $itemSelect.append('<option value="">Select Item</option>');
        }
    });

    // Handle item change
$("#add_sales_table").on("change", ".item-select", function() {
    var itemId = $(this).val();
    var $row = $(this).closest("tr");

    if (itemId) {
        $.ajax({
            url: '/sales/get-product-details/' + itemId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $row.find(".unit_price").val(data.selling_price);
                calculateTotal($row);
            }
        });
    } else {
        $row.find(".unit_price").val('');
        calculateTotal($row);
    }
});

// Handle quantity change
$("#add_sales_table").on("input", ".qty", function() {
    var $row = $(this).closest("tr");
    calculateTotal($row);
});

// Calculate total amount
function calculateTotal($row) {
    var qty = $row.find(".qty").val();
    var unitCost = $row.find(".unit_price").val();
    var total = (qty * unitCost).toFixed(2);
    $row.find(".total").val(total);

    calc_total();
}

function calc_total() {
    var sum = 0;
    $(".total").each(function () {
        sum += parseFloat($(this).val()) || 0;
    });
    $("#grand_total").val(sum.toFixed(2));
    $(".subtotal").text(sum.toFixed(2));
}

// Remove row
$("#add_sales_table").on("click", ".remove", function() {
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
        $('#add_store_sales').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
            console.log(form);
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    //$('#edit_modal').modal('hide');
                    window.location.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/sales/add-sales.blade.php ENDPATH**/ ?>