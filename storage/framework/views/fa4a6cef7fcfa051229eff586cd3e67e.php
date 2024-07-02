<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Email</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Email To:</label>
                    <input type="text" placeholder="To" value="<?php echo e($email->email); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" placeholder="Subject" value="<?php echo e($email->subject); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <?php echo $email->message; ?>

                </div>
                
            </form>
            
        </div>
    </div>
</div><?php /**PATH /home/ghpayroll/base/resources/views/communications/viewemail.blade.php ENDPATH**/ ?>