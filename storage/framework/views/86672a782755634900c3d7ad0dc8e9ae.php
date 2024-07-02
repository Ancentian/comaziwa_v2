<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Request By:</label>
                    <input type="text" placeholder="To" value="<?php echo e($expense->employeeName); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Amount:</label>
                    <input type="text" placeholder="To" value="<?php echo e($expense->amount); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" placeholder="To" value="<?php echo e($expense->date); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Purpose:</label> <br>
                    <?php echo $expense->purpose; ?>

                </div>
                
            </form>
            
        </div>
    </div>
</div><?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/expenses/view_purpose.blade.php ENDPATH**/ ?>