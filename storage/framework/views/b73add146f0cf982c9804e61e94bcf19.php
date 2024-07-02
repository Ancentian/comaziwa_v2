<?php
    $completed = \App\Models\Project::where('progress',100)->count();
    $progress = \App\Models\Project::where('progress','<',100)->count();
    $total = \App\Models\Project::count();
    $high = \App\Models\Project::where('priority','high')->count();
    $low = \App\Models\Project::where('priority','low')->count();
?>



<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Contracts</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#upload_contract"><i class="fa fa-plus"></i>Upload Contract</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="file-content">
    <div class="file-body">
        <div class="file-scroll">
            <div class="file-content-inner">
                <h4>Employees Contract Files</h4>
                <div class="row row-sm">
                    <?php $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">
                        <div class="card card-file">
                            <div class="dropdown-file">
                                <a href="" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="<?php echo e(Storage::url('contracts/'.$contract->file)); ?>" class="dropdown-item" download>
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                    <a class="dropdown-item delete-reload-button" data-action="<?php echo e(url('contracts/deleteContract', [$contract->id])); ?>" href="#"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>
                            <div class="card-file-thumb">
                                <i class="fa fa-file-pdf-o"></i>
                            </div>
                            <div class="card-body">
                                <h6><a href=""><?php echo e($contract->file); ?></a></h6>
                            </div>
                            <div class="card-footer">
                                <span class="d-none d-sm-inline">Last Modified: </span><?php echo e(\Carbon\Carbon::parse($contract->created_at)->diffForHumans()); ?>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Create Project Modal -->
<div id="upload_contract" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Contract</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="upload_contract_file" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>                   
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee</label>
                                <select class="select" name="employee_id">
                                    <option>--Choose Here--</option>
                                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Contract File <span class="text-danger">*</span></label>
                                <input class="form-control" type="file" name="file" id="file">
                                <span class="modal-error invalid-feedback" role="alert"></span>
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
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/employees/contracts/index.blade.php ENDPATH**/ ?>