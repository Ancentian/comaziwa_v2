


<?php $__env->startSection('content'); ?>

<input type="hidden" id="reload_page">
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Milk Collection</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <form id="add_milk_collection" action="<?php echo e(url('milkCollection/store-milk-collection')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label>Select Center</label>
                    <select class="form-control select" name="center_id" id="training_id" required>
                        <option value="">Choose one</option>
                        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->center_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-sm-4">  
                    <div class="form-group">
                        <label class="col-form-label">Collection Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="collection_date" type="text" required>
                        </div>
                    </div>
                </div>   
            </div>
            <div id="course_details">            
                <div class="row">
                    <h4 class="text-center w-100">Farmers</h4>
                    <div class="col-md-12">
                        <table class="table table-striped custom-table mb-0" id="milk_collection_table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Morning</th>
                                    <th>Evening</th> 
                                    <th>Rejected</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add your table rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
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
    $(document).on('change','#training_id',function(){
       $("#course_details").hide();
        var id = $(this).val();
        console.log(id);
        if(id){
            $("#milk_collection_table tbody").empty();
            
            $.ajax({
                url: "/milkCollection/center-farmers/"+id,
                method: 'GET',
                data: {},
                dataType: 'json',
                success: function(response) {
                    console.log(response)
                    $("#course_details").show();
                    
                    $("#course_id").val(response.training.course_id).trigger('change');
                    $("#venue_id").val(response.training.venue_id).trigger('change');
                    $("#facilitator_id").val(response.training.facilitator_id).trigger('change');
                    $("#room_id").val(response.training.room_id).trigger('change');
                    
                    if(response.parts){                           
                        $.each(response.parts, function( index, value ) {
                            
                          var tr = `
                                <tr>
                                    <td>` + value.farmerCode + ` - ` + value.fname + `</td>
                                    <td hidden><input type="text" class="form-control" name="farmer_id[]" value="`+value.farmer_id+`"></td>
                                    <td><input type="number" class="form-control morning" step="any" name="morning[]" value="0" id="farmerid" ></td>
                                    <td><input type="number" class="form-control evening" step="any" name="evening[]" value="0" id="evening" ></td>
                                    <td><input type="number" step="any" class="form-control rejected" name="rejected[]" value="0" id="reject" ></td>
                                    <td><input type="number" step="any" class="form-control total" name="total[]" id="total" readonly></td>
                                </tr>
                            `;
                            
                            $("#milk_collection_table tbody").append(tr);
                            
                            $("#confirmed_"+index).val(value.confirmed_status).trigger('change');
                            $("#agent_"+index).val(value.agent).trigger('change');
                        });
                    }
                    
                                        
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                }
            });
        }


        $("#milk_collection_table tbody").on("input", ".morning, .evening, .rejected", function () {
            var $row = $(this).closest("tr");
            var morning = parseFloat($row.find(".morning").val()) || 0;
            var evening = parseFloat($row.find(".evening").val()) || 0;
            var rejected = parseFloat($row.find(".rejected").val()) || 0;
            var total = $row.find(".total");
            total.val((morning + evening) - rejected);
            //calc_total();
        });
       
    });

    $(document).ready(function(){
            
            $('#add_milk_collection').on('submit', function (e) {
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
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/milkcollection/addcollection.blade.php ENDPATH**/ ?>