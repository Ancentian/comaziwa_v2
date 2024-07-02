<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Mail Template</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <form id="" >
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" placeholder="Subject" value="<?php echo e($email->name); ?>" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <?php echo $email->template; ?>

                </div>
                
            </form>
            
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\payroll\resources\views/communications/view_template.blade.php ENDPATH**/ ?>