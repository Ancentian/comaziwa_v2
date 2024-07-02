<!-- Sidebar -->
<?php
    if(session('is_admin') == 1)
    {
        $userId = optional(auth()->guard('employee')->user())->tenant_id;
    }else{
        $userId = auth()->user()->id;
    }
    $user = \App\Models\User::find($userId);
    $userType = $user->type;

    if ($userType === 'client') {
        $package_id = $user->package_id;
        $package = \App\Models\Package::where('id', $package_id)->first();    
        $subscribedModules = !empty($package) ? explode(',', $package->module) : [];

        $moduleUrls = [
            'hr' => [
                'employees' => 'employees',
                'contracts' => 'contracts/list',
            ],
            'attendance' => [
                'attendance' => 'attendance/list'
            ],
            'leaves' => [
                'Leaves Summary' => 'leaves/list',
                'Leaves' => 'leaves/all-leaves',
                'Pending Leaves' => 'leaves/pendingLeaves'
            ],
            'projects' => [
                'projects' => 'projects/list',
            ],
            'tasks' => [
                'tasks' => 'tasks/list'
            ],

            'bulky_email' => [
                'emails' => 'communications/emails',
                'Email Templates' => 'communications/email-templates',
            ],
            'payroll' => [
                'Payslips' => 'payslip-reports/paye',
                'PAYE Tax Returns Report' => 'payslip-reports/paye-tax',
                'Tier One' => 'payslip-reports/tier-one',
                'Tier Two' => 'payslip-reports/tier-two',
                'Allowances Report' => 'payslip-reports/allowances',
                'Benefits Report' => 'payslip-reports/benefits',
                'Statutory Deductions' => 'payslip-reports/statutory',
                'Non Statutory Deductions' => 'payslip-reports/non-statutory',
                'Net Pay to Bank Report' => 'payslip-reports/bank-net-pay'
            ],
            'expenses' => [
                'Expenses' => 'expenses/list',
            ],
            'trainings' => [
                'Trainings' => 'trainings/list',
                'Training Requests/Invites' => 'trainings/list-requests',
                'Pending Requests' => 'trainings/list-pending',
            ],
    ];

    }
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <?php if(auth()->user()->type == 'superadmin'): ?>
                            <li><a href="<?php echo e(url('superadmin/dashboard')); ?>">Dashboard</a></li>                    
                        <?php else: ?>
                            <li><a href="<?php echo e(url('dashboard/index')); ?>">Dashboard</a></li>  
                        <?php endif; ?>
                    </ul>
                </li>

                <?php if(auth()->user()->type == 'superadmin'): ?>                  
                    
                    <li class="submenu">
                        <a href="#"><i class="la la-user-plus"></i> <span> User Management </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('superadmin/list/users')); ?>">System Admins</a></li>
                            <li><a href="<?php echo e(url('superadmin/list/roles')); ?>">Roles</a></li>
                            <li><a href="<?php echo e(url('superadmin/list/agents')); ?>">Agents</a></li>
                            
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-users"></i> <span> Client Management </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('superadmin/list/clients')); ?>">Clients</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('packages/list')); ?>"> Packages </a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <?php if(usercan('view.revenue.reports')): ?>
                                <li><a href="<?php echo e(url('superadmin/subscription-plans')); ?>"> Revenue </a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php else: ?>
                
                
                    <?php if(in_array('hr', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-users"></i> <span> HR </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php $__currentLoopData = $moduleUrls['hr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array('attendance', $subscribedModules)): ?>
                                    <?php $__currentLoopData = $moduleUrls['attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('trainings', $subscribedModules)): ?>
                    <li class="submenu">
                        <a href="#"><i class="la la-graduation-cap"></i> <span> Trainings</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <?php $__currentLoopData = $moduleUrls['trainings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('projects', $subscribedModules) || in_array('tasks', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-rocket"></i> <span> Projects & Tasks </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php if(in_array('projects', $subscribedModules)): ?>
                                    <?php $__currentLoopData = $moduleUrls['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php if(in_array('tasks', $subscribedModules)): ?>
                                    <?php $__currentLoopData = $moduleUrls['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> User Admin </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('company/profile')); ?>"> Company Profile </a></li>
                            <li><a href="<?php echo e(url('company/settings')); ?>"> Company Settings </a></li>
                            <li><a href="<?php echo e(url('communications/mailSettings')); ?>"> Email Settings </a></li>
                            <?php if(auth()->user()->type == 'superadmin'): ?>
                                <li><a href="<?php echo e(url('packages/list')); ?>"> Packages </a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    
                    <?php if(in_array('payroll', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php $__currentLoopData = $moduleUrls['payroll']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('expenses', $subscribedModules)): ?>
                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Expenses</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <?php $__currentLoopData = $moduleUrls['expenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('bulky_email', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-bullhorn"></i> <span> Communications </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php $__currentLoopData = $moduleUrls['bulky_email']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('leaves', $subscribedModules)): ?>
                    <li class="submenu">
                        <a href="#"><i class="la la-user-secret"></i> <span> Leaves </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <?php $__currentLoopData = $moduleUrls['leaves']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                
                <?php endif; ?> 

                  
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar --><?php /**PATH /home/ghpayroll/base/resources/views/layout/sidebar.blade.php ENDPATH**/ ?>