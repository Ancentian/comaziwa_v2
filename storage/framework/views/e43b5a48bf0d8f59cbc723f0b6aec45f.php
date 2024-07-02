<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Role</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="assign_permissions_form" action="<?php echo e(url('/superadmin/assign-permissions/'.$role->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h5>User Management</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="add.system.admin" id="add.system.admin" value="1" class="input-icheck" 
                            <?php echo e(in_array('add.system.admin',$permissions) ? 'checked' : ''); ?>>
                            <label for="add.system.admin">Create System Admins</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="assign.roles" id="assign.roles" value="1" class="input-icheck" 
                            <?php echo e(in_array('assign.roles',$permissions) ? 'checked' : ''); ?>>
                            <label for="assign.roles">Assign Roles</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.system.admin" id="delete.system.admin" value="1" class="input-icheck" 
                            <?php echo e(in_array('delete.system.admin',$permissions) ? 'checked' : ''); ?>>
                            <label for="is_service_staff">Delete System Admins</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.system.admin" id="edit.system.admin" value="1" class="input-icheck" 
                            <?php echo e(in_array('edit.system.admin',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.system.admin">Edit System Admin</label>
                        </div>
                    </div>
                   
                   
                </div>
                <hr>

                <h5>Client Management</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="add.client" id="add.client" value="1" class="input-icheck" 
                            <?php echo e(in_array('add.client',$permissions) ? 'checked' : ''); ?>>
                            <label for="add.client">Add Client</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="assign.agent" id="assign.agent" value="1" class="input-icheck" 
                            <?php echo e(in_array('assign.agent',$permissions) ? 'checked' : ''); ?>>
                            <label for="assign.agent">Assign Agent</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.client" id="edit.client" value="1" class="input-icheck" 
                            <?php echo e(in_array('edit.client',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.client">Edit Client</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="extend.expiry.dates" id="extend.expiry.dates" value="1" class="input-icheck" 
                            <?php echo e(in_array('extend.expiry.dates',$permissions) ? 'checked' : ''); ?>>
                            <label for="extend.expiry.dates">Extend Expiry Dates</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.user.package" id="edit.user.package" value="1" class="input-icheck" 
                            <?php echo e(in_array('edit.user.package',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.user.package">Edit User Package</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.client" id="delete.client" value="1" class="input-icheck" 
                            <?php echo e(in_array('delete.client',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.client">Delete Client</label>
                        </div>
                    </div>                   
                   
                </div>
                <hr>

                <h5>Package Management</h5>
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="add.package" id="add.package" value="1" class="input-icheck" 
                            <?php echo e(in_array('add.package',$permissions) ? 'checked' : ''); ?>>
                            <label for="add.package">Add Package</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="delete.package" id="delete.package" value="1" class="input-icheck" 
                            <?php echo e(in_array('delete.package',$permissions) ? 'checked' : ''); ?>>
                            <label for="delete.package">Delete Package</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="checkbox">
                            <input type="checkbox" name="edit.package" id="edit.package" value="1" class="input-icheck" 
                            <?php echo e(in_array('edit.package',$permissions) ? 'checked' : ''); ?>>
                            <label for="edit.package">Edit Package</label>
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
    $(document).ready(function(){
            
        $('#assign_permissions_form').on('submit', function (e) {
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
    </script><?php /**PATH /home/ghpayroll/base/resources/views/superadmin/roles/assign_permissions.blade.php ENDPATH**/ ?>