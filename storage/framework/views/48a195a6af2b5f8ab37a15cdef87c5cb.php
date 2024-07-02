<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Payment for <?php echo e($agent->name); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="add_payment_form" action="<?php echo e(url('/superadmin/pay')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input class="form-control" type="text" name="agent_id" value="<?php echo e($agent->id); ?>" hidden required>
                <div class="row">
                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Commission: <?php echo e(number_format(\App\Models\Agent::calculatecommission($agent->id), 2, '.', ',')); ?></h5>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Paid: <?php echo e(number_format(\App\Models\Agent::calculatePaid($agent->id), 2, '.', ',')); ?></h5>
                    </div>

                    <div class="col-sm-4">
                        <h5 class="text-danger">Total Balance: <?php echo e(number_format(\App\Models\Agent::calculateBalance($agent->id), 2, '.', ',')); ?></h5>
                    </div>
                </div>
                <hr>
                <div class="row">                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Date</label>
                            <div class="cal-icon">
                                <input type="date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" name="date" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Amount <span class="text-danger">*</span></label>
                            <input class="form-control" type="number" max="<?php echo e(\App\Models\Agent::calculateBalance($agent->id)); ?>" name="amount"  required>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#add_payment_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            console.log(formData)
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    agents_table.ajax.reload();
                    toastr.success(response.message, 'Success');
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    toastr.error('Something Went Wrong!, Try again!','Error');
                    console.error(error);
                }
            });
        });
    });
    </script><?php /**PATH /home/ghpayroll/base/resources/views/superadmin/users/add_payment.blade.php ENDPATH**/ ?>