<?php
    $completed = \App\Models\Task::where('status', 'complete')->count();
    $inprogress = \App\Models\Task::where('status', 'inprogress')->count();
    $total = \App\Models\Task::count();
?>


<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Tasks</li>
            </ul>
        </div>
        <?php if(staffCan("create.task")): ?>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_task_modal"><i class="fa fa-plus"></i> Add Task</a>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card-group m-b-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Complete</span>
                        </div>
                        <div>
                            <span class="text-success"><?php echo e($total > 0 ? ceil($completed / $total * 100) : 0); ?>%</span>
                        </div>
                    </div>
                    <h3 class="mb-3"><?php echo e($completed); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($completed / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($completed / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">In Progress</span>
                        </div>
                        <div>
                            <span class="text-danger"><?php echo e($total > 0 ? ceil($inprogress / $total * 100) : 0); ?>%</span>
                        </div>
                    </div>
                    <h3 class="mb-3"><?php echo e($inprogress); ?></h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo e($total > 0 ? ceil($inprogress / $total * 100) : 0); ?>%;" aria-valuenow="<?php echo e($total > 0 ? ceil($inprogress / $total * 100) : 0); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>



<div class="kanban-board card mb-0">
    <div class="card-body">
        
            <div class="row">
                <div class="col-md-6">
                    <div class="kanban-list w-100 kanban-success">
                        <div class="kanban-header">
                            <span class="status-title">Complete</span>
                        </div>
                        <div class="kanban-wrap">
                            <?php $__currentLoopData = $completeTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card panel">
                                <div class="kanban-box">
                                    <div class="task-board-header">
                                        <span class="status-title"><a href="#"><?php echo e($key->title); ?> - <small>(<?php echo e($key->projectName); ?>)</small></a></span>
                                        <div class="btn-group">
                                            <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edit-button" data-action="<?php echo e(url('tasks/edit', [$key->id])); ?>" href="#"><i class="fa fa-pencil"></i> Edit</a>
                                                <a class="dropdown-item delete-reload-button" data-action="<?php echo e(url('tasks/delete', [$key->id])); ?>" href="#"><i class="fa fa-trash"></i> Delete</a>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="task-board-body">
                                        <div class="kanban-info">
                                            <p><?php echo e($key->notes); ?></p>
                                        </div>
                                        <div class="kanban-footer">
                                            <span class="task-info-cont">
                                                <span class="task-date"><b>Assigned To:</b> <?php echo e($key->employeeName); ?></span>
                                                <?php if($key->priority == "high"): ?>
                                                    <span class="task-priority badge bg-inverse-danger"><?php echo e($key->priority); ?></span>
                                                <?php elseif($key->priority == "medium"): ?>
                                                    <span class="task-priority badge bg-inverse-success"><?php echo e($key->priority); ?></span>
                                                <?php else: ?>
                                                    <span class="task-priority badge bg-inverse-warning"><?php echo e($key->priority); ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="kanban-list w-100 kanban-warning">
                        <div class="kanban-header">
                            <span class="status-title">Inprogress</span>
                        </div>
                        <div class="kanban-wrap">
                            <?php $__currentLoopData = $inprogressTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card panel">    
                                <div class="kanban-box">
                                    <div class="task-board-header">
                                        <span class="status-title"><a href="#"><?php echo e($key->title); ?> - <small>(<?php echo e($key->projectName); ?>)</small></a></span>
                                        <div class="btn-group">
                                            <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item edit-button" data-action="<?php echo e(url('tasks/edit', [$key->id])); ?>" href="#"><i class="fa fa-pencil"></i> Edit</a>
                                                <a class="dropdown-item delete-reload-button" data-action="<?php echo e(url('tasks/delete', [$key->id])); ?>" href="#"><i class="fa fa-trash"></i> Delete</a>
                                            </div>
                                          </div>
                                    </div>
                                    <div class="task-board-body">
                                        <div class="kanban-info">
                                            <p><?php echo e($key->notes); ?></p>
                                        </div>
                                        <div class="kanban-footer">
                                            <span class="task-info-cont">
                                                <span class="task-date"><b>Assigned To:</b> <?php echo e($key->employeeName); ?></span>
                                                <?php if($key->priority == "high"): ?>
                                                    <span class="task-priority badge bg-inverse-danger"><?php echo e($key->priority); ?></span>
                                                <?php elseif($key->priority == "medium"): ?>
                                                    <span class="task-priority badge bg-inverse-success"><?php echo e($key->priority); ?></span>
                                                <?php else: ?>
                                                    <span class="task-priority badge bg-inverse-warning"><?php echo e($key->priority); ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>       
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>




<!-- Add Task Modal -->
<div id="add_task_modal" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Task</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add_task_form">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Project</label>
                        <select class="form-control select" name="project_id">
                            <<?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Task Name</label>
                        <input type="text" name="title" class="form-control">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Assigned To</label>
                        <select class="form-control select" name="assigned_to">
                            <<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key->id); ?>"><?php echo e($key->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Task Priority</label>
                        <select class="form-control select" name="priority">
                            <option>Select</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control select" name="status">
                            <option value="">Select</option>
                            <option value="complete">Complete</option>
                            <option value="inprogress">Inprogress</option>
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" id="" cols="30" rows="4"></textarea>
                    </div>
                    <div class="submit-section text-center">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Task Modal -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ghpayroll/base/resources/views/companies/tasks/index.blade.php ENDPATH**/ ?>