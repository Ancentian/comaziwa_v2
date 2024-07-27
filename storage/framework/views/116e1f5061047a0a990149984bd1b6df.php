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
                'farmers' => 'cooperative/farmers',
                'employees' => 'employees',
                'contracts' => 'contracts/list',
            ],
            'leaves' => [
                'Leaves Summary' => 'leaves/list',
                'Leaves' => 'leaves/all-leaves',
                'Pending Leaves' => 'leaves/pendingLeaves'
            ],

            'bulky_email' => [
                'emails' => 'communications/emails',
                'Email Templates' => 'communications/email-templates',
            ],
            'payroll' => [
                'Payslips' => 'payslip-reports/paye',
                'Net Pay to Bank Report' => 'payslip-reports/bank-net-pay'
            ],
            'expenses' => [
                'Expenses' => 'expenses/list',
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
                        </ul>
                    </li>
                <?php endif; ?>

                    <li class="submenu">
                        <a href="#"><i class="la la-cubes"></i> <span> Milk Collection </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('milkCollection/add-collection')); ?>">Add Collection</a></li>
                            <li><a href="<?php echo e(url('milkCollection/index')); ?>">Milk List</a></li>  
                            <li><a href="<?php echo e(url('milk-management/spillages')); ?>">Milk Spillages</a></li>                          
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cart-arrow-down"></i> <span> Store </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('sales/add-sales')); ?>">Add Sales</a></li>
                            <li><a href="<?php echo e(url('sales/index')); ?>">All Sales</a></li>
                            <li><a href="<?php echo e(url('sales/all-transactions')); ?>">Transactions</a></li>
                            <li><a href="<?php echo e(url('inventory/all-inventory')); ?>">Inventory List</a></li> 
                            <li><a href="<?php echo e(url('inventory/categories')); ?>">Categories</a></li> 
                            <li><a href="<?php echo e(url('inventory/units')); ?>">Units</a></li>                          
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-scissors"></i> <span> Deductions </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('deductions/index')); ?>">List</a></li>
                            <li><a href="<?php echo e(url('deductions/add-deduction')); ?>">Add Deduction</a></li>
                            <li><a href="<?php echo e(url('deductions/deduction-types')); ?>"> Deduction Types</a></li> 
                            <li><a href="<?php echo e(url('shares/index')); ?>"> Shares</a></li>                         
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('company/settings')); ?>"> Cooperative Settings </a></li>
                            <li><a href="<?php echo e(url('communications/mailSettings')); ?>"> Email Settings </a></li>
                            <li><a href="<?php echo e(url('shares/shares-settings')); ?>"> Shares Settings </a></li>
                            <?php if(auth()->user()->type == 'superadmin'): ?>
                                <li><a href="<?php echo e(url('packages/list')); ?>"> Packages </a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    
                    <li class="submenu" hidden>
                        <a href="#"><i class="la la-user-secret"></i> <span> User Admin </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('company/profile')); ?>"> Company Profile </a></li>
                            <li><a href="<?php echo e(url('company/settings')); ?>"> Company Settings </a></li>
                            <li><a href="<?php echo e(url('communications/mailSettings')); ?>"> Email Settings </a></li>
                            <?php if(auth()->user()->type == 'superadmin'): ?>
                                <li><a href="<?php echo e(url('packages/list')); ?>"> Packages </a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-space-shuttle"></i> <span> Assets </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('assets/index')); ?>"> Assets List </a></li>
                            <li><a href="<?php echo e(url('assets/categories')); ?>"> Categories </a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="<?php echo e(url('payments/index')); ?>"> Payments List </a></li>
                            <li><a href="<?php echo e(url('payments/generate-payments')); ?>"> Generate Payments </a></li>
                        </ul>
                    </li>
                    
                    <?php if(in_array('payroll', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-files-o"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="<?php echo e(url('analysis/collection-center-monthly-report')); ?>"> Collection Report </a></li>
                                <li><a href="<?php echo e(url('analysis/farmers-monthly-report')); ?>"> Farmers Report </a></li>
                                <li><a href="<?php echo e(url('analysis/sales-monthly-report')); ?>"> Sales Report </a></li>
                                <li><a href="<?php echo e(url('analysis/monthly-deductions-report')); ?>"> Deduction Report </a></li>
                                <li><a href="<?php echo e(url('analysis/payments-report')); ?>"> Payments Report </a></li>
                                
                                <?php $__currentLoopData = $moduleUrls['payroll']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(in_array('expenses', $subscribedModules)): ?>
                    <li class="submenu">
                        <a href="#"><i class="la la-credit-card"></i> <span> Expenses</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <?php $__currentLoopData = $moduleUrls['expenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $moduleUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(url($moduleUrl)); ?>"> <?php echo e(ucfirst($moduleName)); ?> </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?> 
                    
                    <?php if(in_array('bulky_email', $subscribedModules)): ?>
                        <li class="submenu" hidden>
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
                        <a href="#"><i class="la la-user-plus"></i> <span> Leaves </span> <span class="menu-arrow"></span></a>
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
<!-- /Sidebar --><?php /**PATH C:\laragon\www\comaziwa\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>