<!-- Sidebar -->
<div class="sidebar" id="sidebar">
     <?php echo e(staffCan('th')); ?>

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
        <?php if(session('is_admin') == 0): ?>
        <ul>
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a  href="<?php echo e(url('staff/index')); ?>">Dashboard</a></li>
                        
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-users"></i> <span> HR </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        
                        <li><a href="<?php echo e(url('staff/leaves')); ?>"> My Leaves </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cubes"></i> <span> Milk Collection </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?php echo e(url('staff/add-milk-collection')); ?>">Add Collection</a></li>
                        <li><a href="<?php echo e(url('staff/index-milk')); ?>">Milk List</a></li>  
                        <li><a href="<?php echo e(url('milk-management/spillages')); ?>">Milk Spillages</a></li>                          
                    </ul>
                </li>
               
                <li class="submenu">
                    <a href="#"><i class="la la-money"></i> <span> Expenses </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?php echo e(url('expenses/staff-expenses')); ?>"> Expenses </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-files-o"></i> <span> Payslip Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?php echo e(url('staff/paye')); ?>"> PAYE Report </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?php echo e(url('staff/settings')); ?>"> My Data </a></li>
                    </ul>
                </li>

            </ul>
        <?php endif; ?>  
        
        
        <?php if(session('is_admin') == 1): ?>
        <?php
            if(session('is_admin') == 1)
            {
                $userId = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $userId = auth()->user()->id;
            }
            $user = \App\Models\User::find($userId);
            logger("Ancent");
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
                    
            ];

            }
        ?>
        
        <ul>
                                     
                    <?php if(
                        staffCan('create.company.profile') || 
                        staffCan('edit.email.settings') || 
                        staffCan('create.company.settings')
                    ): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-cog"></i> <span> User Admin </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php if(staffCan('create.company.profile')): ?>
                                    <li><a href="<?php echo e(url('company/profile')); ?>"> Company Profile </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('edit.email.settings')): ?>
                                    <li><a href="<?php echo e(url('company/settings')); ?>"> Company Settings </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('create.company.settings')): ?>
                                    <li><a href="<?php echo e(url('communications/mailSettings')); ?>"> Email Settings </a></li>
                                <?php endif; ?>
                                
                            </ul>
                        </li>
                    <?php endif; ?>
                   
                    
                    <?php if(in_array('payroll', $subscribedModules)): ?>
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <?php if(staffCan('view.paye')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/paye')); ?>"> Payslips </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('paye.tax.returns.report')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/paye-tax')); ?>"> PAYE Tax Returns Report </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.tier.one')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/tier-one')); ?>"> Tier One </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.tier.two')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/tier-two')); ?>"> Tier Two </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.allowances')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/allowances')); ?>"> Allowances Report </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.benefits.report')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/benefits')); ?>"> Benefits Report </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.statutory.report')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/statutory')); ?>"> Statutory Deductions </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.non.statutory.report')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/non-statutory')); ?>"> Non Statutory Deductions </a></li>
                                <?php endif; ?>
                                
                                <?php if(staffCan('view.net.pay.to.bank.report')): ?>
                                    <li><a href="<?php echo e(url('payslip-reports/bank-net-pay')); ?>"> Net Pay to Bank Report </a></li>
                                <?php endif; ?>
                                
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    
                    <?php if(
                        staffCan('view.expenses') || 
                        staffCan('delete.expense') || 
                        staffCan('approve.expense')
                    ): ?>
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
                        
                    <?php endif; ?>
                    
                    
                    
                    <?php if(
                        staffCan('view.emails') || 
                        staffCan('edit.template') || 
                        staffCan('edit.template') ||
                        staffCan('delete.template')
                    ): ?>
                        <?php if(in_array('bulky_email', $subscribedModules)): ?>
                            <li class="submenu">
                                <a href="#"><i class="la la-bullhorn"></i> <span> Communications </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <?php if(
                                        staffCan('view.emails') 
                                    ): ?>
                                        <li><a href="<?php echo e(url('communications/emails')); ?>"> Emails </a></li>
                                    <?php endif; ?>
                                    
                                    <?php if(
                                        staffCan('edit.template') || 
                                        staffCan('edit.template') ||
                                        staffCan('delete.template')
                                    ): ?>
                                        <li><a href="<?php echo e(url('communications/email-templates')); ?>"> Email Templates </a></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    
                    <?php if(
                        staffCan('view.leave') || 
                        staffCan('approve.leave') || 
                        staffCan('delete.leave') ||
                        staffCan('request.leave') ||
                        staffCan('decline.leave') 
                    ): ?>
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
        
                    <?php endif; ?>
                    </ul>
        
        </div>
    </div>
</div>
<!-- /Sidebar --><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/layout/sidebar.blade.php ENDPATH**/ ?>