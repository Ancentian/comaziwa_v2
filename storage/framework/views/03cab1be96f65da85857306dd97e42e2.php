<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Permissions</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Is Admin Configured </label>
                    <select class="form-control select" id="is_admin_configured">
                        <option value="0"> No</option>
                        <option value="1" <?php if($employee->is_admin_configured == 1): ?> selected <?php endif; ?>> Yes</option>
                    </select>
                </div>
            </div>
        </div>
        <form id="assign_permissions_form" action="<?php echo e(url('/staff/post-assign-permissions/'. $employee->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h5>Leave Management</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.leave" id="view.leave" value="1" class="input-icheck" <?php echo e(in_array('view.leave',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.leave"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="request.leave" id="request.leave" value="1" class="input-icheck" <?php echo e(in_array('request.leave',$permissions) ? 'checked' : ''); ?>>
                            <label for="request.leave"> Create</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="approve.leave" id="approve.leave" value="1" class="input-icheck" <?php echo e(in_array('approve.leave',$permissions) ? 'checked' : ''); ?>>
                            <label for="approve.leave"> Approve</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="decline.leave" id="decline.leave" value="1" class="input-icheck" <?php echo e(in_array('decline.leave',$permissions) ? 'checked' : ''); ?>>
                            <label for="decline.leave"> Decline</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.leave" id="delete.leave" value="1" class="input-icheck" <?php echo e(in_array('delete.leave',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.leave"> Delete</label>
                        </div>
                    </div>
                </div>
                <hr>

                <h5>Trainings</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.training" id="view.training" value="1" class="input-icheck" <?php echo e(in_array('view.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.training"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.training" id="create.training" value="1" class="input-icheck" <?php echo e(in_array('create.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.training"> Create</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.training" id="edit.training" value="1" class="input-icheck" <?php echo e(in_array('edit.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.training"> Edit</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="invite.individual" id="invite.individual" value="1" class="input-icheck" <?php echo e(in_array('invite.individual',$permissions) ? 'checked' : ''); ?>>
                            <label for="invite.individual"> Invite Individual</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="invite.department" id="invite.department" value="1" class="input-icheck" <?php echo e(in_array('invite.department',$permissions) ? 'checked' : ''); ?>>
                            <label for="invite.department"> Invite Department</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="approve.training" id="approve.training" value="1" class="input-icheck" <?php echo e(in_array('approve.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="approve.training"> Approve </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="decline.training" id="decline.training" value="1" class="input-icheck" <?php echo e(in_array('decline.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="decline.training"> Decline </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.training" id="delete.training" value="1" class="input-icheck" <?php echo e(in_array('delete.training',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.training"> Delete</label>
                        </div>
                    </div> 
                </div>
                <hr>

                <h5> Projects</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.project" id="view.project" value="1" class="input-icheck" <?php echo e(in_array('view.project', $permissions) ? 'checked' : ''); ?>>
                            <label for="view.project"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.project" id="create.project" value="1" class="input-icheck" <?php echo e(in_array('create.project',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.project"> Create</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.project" id="edit.project" value="1" class="input-icheck" <?php echo e(in_array('edit.project',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.project"> Edit</label>
                        </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.project" id="delete.project" value="1" class="input-icheck" <?php echo e(in_array('delete.project', $permissions) ? 'checked' : ''); ?>>
                            <label for="delete.project"> Delete</label>
                        </div>
                    </div>
                </div>
                <hr>

                <h5> Tasks</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.task" id="view.task" value="1" class="input-icheck" <?php echo e(in_array('view.task',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.task"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.task" id="create.task" value="1" class="input-icheck" <?php echo e(in_array('create.task',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.task"> Create</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.task" id="edit.task" value="1" class="input-icheck" <?php echo e(in_array('edit.task',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.task"> Edit</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.task" id="delete.task" value="1" class="input-icheck" <?php echo e(in_array('delete.task',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.task"> Delete</label>
                        </div>
                    </div>
                </div>
                <hr>

                <h5> Communications</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.emails" id="view.emails" value="1" class="input-icheck" <?php echo e(in_array('view.emails',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.emails"> View Emails</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.template" id="create.template" value="1" class="input-icheck" <?php echo e(in_array('create.template',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.template"> Create Template</label>
                        </div>
                    </div>
                    
                </div>
                <hr>

                <h5> Expenses</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.expenses" id="view.expenses" value="1" class="input-icheck" <?php echo e(in_array('view.expenses',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.expenses"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="approve.expense" id="approve.expense" value="1" class="input-icheck" <?php echo e(in_array('approve.expense',$permissions) ? 'checked' : ''); ?>>
                            <label for="approve.expense"> Approve</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.expense" id="delete.expense" value="1" class="input-icheck" <?php echo e(in_array('delete.expense',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.expense"> Delete</label>
                        </div>
                    </div>
                </div>
                <hr>

                <h5> Contracts</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.contract" id="view.contract" value="1" class="input-icheck" <?php echo e(in_array('view.contract',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.contract"> View</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="upload.contract" id="upload.contract" value="1" class="input-icheck" <?php echo e(in_array('upload.contract',$permissions) ? 'checked' : ''); ?>>
                            <label for="upload.contract"> Upload </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.contract" id="delete.contract" value="1" class="input-icheck" <?php echo e(in_array('delete.contract',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.contract"> Delete</label>
                        </div>
                    </div>
                </div>
                <hr> 
                
                <h5> Settings</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.company.profile" id="create.company.profile" value="1" class="input-icheck" <?php echo e(in_array('create.company.profile',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.company.profile"> Company Profile</label>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="create.company.settings" id="create.company.settings" value="1" class="input-icheck" <?php echo e(in_array('create.company.settings',$permissions) ? 'checked' : ''); ?>>
                            <label for="create.company.settings"> Company Settings </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.email.settings" id="edit.email.settings" value="1" class="input-icheck" <?php echo e(in_array('edit.email.settings',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.email.settings"> Email Settings</label>
                        </div>
                    </div>
                </div>
                <hr> 
                
                <h5> Reports</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="paye.tax.returns.report" id="paye.tax.returns.report" value="1" class="input-icheck" <?php echo e(in_array('paye.tax.returns.report',$permissions) ? 'checked' : ''); ?>>
                            <label for="paye.tax.returns.report"> PAYE Tax Returns Report </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.paye" id="view.paye" value="1" class="input-icheck" <?php echo e(in_array('view.paye',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.paye"> View PAYE</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.tier.one" id="view.tier.one" value="1" class="input-icheck" <?php echo e(in_array('view.tier.one',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.tier.one"> Tier One</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.tier.two" id="view.tier.two" value="1" class="input-icheck" <?php echo e(in_array('view.tier.two',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.tier.two"> Tier Two</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.allowances" id="view.allowances" value="1" class="input-icheck" <?php echo e(in_array('view.allowances',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.allowances"> Allowances Report</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.benefits.report" id="view.benefits.report" value="1" class="input-icheck" <?php echo e(in_array('view.benefits.report',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.benefits.report"> Benefits Report</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.statutory.report" id="view.statutory.report" value="1" class="input-icheck" <?php echo e(in_array('view.statutory.report',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.statutory.report"> Statutory Report</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.non.statutory.report" id="view.non.statutory.report" value="1" class="input-icheck" <?php echo e(in_array('view.non.statutory.report',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.non.statutory.report"> Non Statutory Report</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="view.net.pay.to.bank.report" id="view.net.pay.to.bank.report" value="1" class="input-icheck" <?php echo e(in_array('view.net.pay.to.bank.report',$permissions) ? 'checked' : ''); ?>>
                            <label for="view.net.pay.to.bank.report"> Net Pay To Bank</label>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($('#is_admin_configured').val() === "0") {
            $('#assign_permissions_form').hide();
        }

        $('#is_admin_configured').change(function() {
            var isAdminConfigured = $(this).val();
            var permissionCheckboxes = $('#assign_permissions_form input[type="checkbox"]');

            if (isAdminConfigured === "1") {
                $('#assign_permissions_form').show(); // Show the form
                permissionCheckboxes.closest(".col-md-6").show(); 
            } else {
                $('#assign_permissions_form').hide(); 
            }
        });
    });

    $(document).ready(function(){
            
        $('#assign_permissions_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    frm.reset();

                    toastr.success(response.message,'Success');
                    
                    // Close the modal
                    $('#edit_modal').modal('hide');
                    roles_table.ajax.reload();
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
    });
</script>


<?php /**PATH C:\laragon\www\payroll\resources\views/employees/assign_permissions.blade.php ENDPATH**/ ?>