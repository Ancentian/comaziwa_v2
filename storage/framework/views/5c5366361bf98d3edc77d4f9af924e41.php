<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">Are you sure ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="update_expense_request" action="<?php echo e(url('expenses/update-status', [$expense->id])); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <input type="hidden" id="approval_status" name="approval_status">
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php /**PATH C:\laragon\www\payroll\resources\views/companies/expenses/approve.blade.php ENDPATH**/ ?>