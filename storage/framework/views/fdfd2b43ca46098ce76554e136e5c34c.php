<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Packages</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
          <?php if(usercan('add.package')): ?>
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_package"><i class="fa fa-plus"></i> Add Package</a>
          <?php endif; ?>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <?php $__currentLoopData = $package; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-12 col-md-6 col-lg-4 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo e($module->name); ?></h5>
                <?php if($module->is_system ==1): ?>
                    <span class="text-danger">Free Version</span>
                <?php endif; ?>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><strong>Monthly Price:</strong> GHS <?php echo e(number_format($module->price)); ?></li>
              <li class="list-group-item"><strong>Annual Price:</strong> GHS <?php echo e(number_format($module->annual_price)); ?></li>
              <li class="list-group-item"><strong>No of Staff:</strong> <?php echo e(number_format($module->staff_no)); ?></li>
            </ul>
            
            <ul class="list-group list-group-flush">
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
              <?php if(usercan('edit.package')): ?>
                <a class="btn btn-success mr-2 edit-button btn-sm" data-action="<?php echo e(url('packages/edit', [$module->id])); ?>" href="#"><i class="fa fa-pencil"></i> Edit</a>
              <?php endif; ?>
              
              <?php if($module->is_system ==0 && usercan('delete.package')): ?>
                <a class="btn btn-primary delete-reload-button btn-sm" data-action="<?php echo e(url('packages/delete', [$module->id])); ?>" href="#"><i class="fa fa-trash"></i> Delete</a>
              <?php endif; ?>
              
            </div>     
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Add Modal -->
<div class="modal custom-modal fade" id="add_package" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Package</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="package_form">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Monthly Price<span class="text-danger">*</span></label>
                                <input class="form-control" name="price" type="number">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Annual Price<span class="text-danger">*</span></label>
                                <input class="form-control" name="annual_price" type="number">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label>No. of Staff<span class="text-danger">*</span></label>
                              <input class="form-control" name="staff_no" type="number">
                              <span class="modal-error invalid-feedback" role="alert"></span>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Is Hidden<span class="text-danger"></span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_hidden" value="1">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="row" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]" id="module1" value="hr">
                                  <label class="form-check-label" for="module1">
                                    HR (Employee Management)
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]" id="module2" value="payroll">
                                  <label class="form-check-label" for="module2">
                                    Payroll
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module3" value="attendance">
                                  <label class="form-check-label" for="module3">
                                    Attendance
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module4" value="contracts">
                                  <label class="form-check-label" for="module4">
                                    Contracts
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]" id="module5" value="leaves">
                                  <label class="form-check-label" for="module5">
                                    Leaves
                                  </label>
                                </div>
                              </div>
                        </div>
                        <div class="col-md-6">      
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]" id="module6" value="projects">
                                  <label class="form-check-label" for="module6">
                                    Projects
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module7" value="tasks">
                                  <label class="form-check-label" for="module7">
                                    Tasks
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module8" value="bulky_sms">
                                  <label class="form-check-label" for="module8">
                                    Bulky SMS
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module9" value="bulky_email">
                                  <label class="form-check-label" for="module9">
                                    Bulky Email
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]" id="module10" value="expenses">
                                  <label class="form-check-label" for="module10">
                                    Expenses
                                  </label>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="module[]"  id="module11" value="trainings">
                                  <label class="form-check-label" for="module11">
                                    Trainings
                                  </label>
                                </div>
                              </div>   
                        </div>
                    </div>           
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Modal -->

<!-- Edit Modal -->
<div class="modal custom-modal fade" id="edit_plan" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscription Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Plan Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="plan_name" type="text">
                    </div>
                    <div class="form-group">
                        <label>No. of Days <span class="text-danger">*</span></label>
                        <input class="form-control" name="no_of_days" type="number">
                    </div>
                    <div class="form-group">
                        <label>Price<span class="text-danger">*</span></label>
                        <input class="form-control" name="price" type="number">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /edit Modal -->

<!-- Delete Plan Modal -->
<div class="modal custom-modal fade" id="delete_plan" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Plan</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Plan Modal -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/superadmin/packages/index.blade.php ENDPATH**/ ?>