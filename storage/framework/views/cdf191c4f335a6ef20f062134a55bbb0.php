<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Record</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <input type="hidden" id="modal_delete_action">
                        <div class="col-6">
                            <a href="#" id="modal_delete_button" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<?php
       $allpackages = App\Models\Package::get();
?>



<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="welcome_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Welcome on board!</h3>
                    <p>Please choose one package that suits you and enjoy <?php echo e(env('TRIAL_PERIOD')); ?> days free trial!</p>
                </div>
                <?php if(!empty($allpackages)): ?>
                <div class="row">
                    <?php $__currentLoopData = $allpackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo e($module->name); ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> GHS <?php echo e(number_format($module->price)); ?></li>
                                <li class="list-group-item"><strong>No of Staff:</strong> <?php echo e(number_format($module->staff_no)); ?></li>
                              </ul>

                            <div class="d-flex justify-content-center mt-3 mb-2">
                              <a class="btn btn-primary mr-2 try-button btn-sm" data-action="<?php echo e(url('dashboard/tryplan',[$module->id])); ?>" href="#"><i class="fa fa-pencil"></i> Try it for Free</a>
                            </div>     
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal -->

<div class="modal custom-modal fade" id="renew_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Choose subscription!</h3>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>Choose and pay for a subscription!</p>
                    </div>
                </div>
                <?php if(!empty($allpackages)): ?>
                <div class="row">
                    <?php $__currentLoopData = $allpackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo e($module->name); ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> GHS <?php echo e(number_format($module->price)); ?></li>
                                <li class="list-group-item"><strong>No of Staff:</strong> <?php echo e(number_format($module->staff_no)); ?></li>
                                <?php
                                $moduleString = $module->module;
                                $modules = explode(',', $moduleString);
                                ?>
                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $moduleItem = str_replace('_', ' ', $moduleItem);
                                    $moduleItem = ucfirst($moduleItem);
                                    ?>
                                    <li class="list-group-item"> <i class="fa fa-check text-success"></i> <?php echo e($moduleItem); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="d-flex justify-content-center mt-3 mb-2">
                                <?php if($module->price == 0): ?>
                                    <a class="btn btn-success mr-2 try-button btn-sm" data-action="<?php echo e(url('dashboard/tryplan',[$module->id])); ?>" href="#"><i class="fa fa-pencil"></i> Try it for Free</a>
                                <?php else: ?>
                                <a class="btn btn-primary mr-2 pay-button" onclick="paysubscription(<?php echo e($module->price); ?>,<?php echo e($module->id); ?>,'monthly')" href="#"><i class="fa fa-pencil"></i> Pay <?php echo e(number_format($module->price, 2, '.', ',')); ?> Monthly</a>
                                <a class="btn btn-info mr-2 pay-button" onclick="paysubscription(<?php echo e($module->annual_price); ?>,<?php echo e($module->id); ?>,'annual')" href="#"><i class="fa fa-pencil"></i> Pay <?php echo e(number_format($module->annual_price, 2, '.', ',')); ?> Annually</a>
                                <?php endif; ?>
                              
                            </div>     
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete  Modal with Reload -->
<div class="modal custom-modal fade" id="delete_reload_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Record</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <input type="hidden" id="modal_delete_reload_action">
                        <div class="col-6">
                            <a href="#" id="modal_delete_reload_button" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Modal with reload -->


<div id="edit_modal" class="modal custom-modal fade" role="dialog">
</div>
<?php /**PATH /home/ghpayroll/base/resources/views/layout/components.blade.php ENDPATH**/ ?>