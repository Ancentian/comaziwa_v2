<!-- Sidebar -->
<div class="sidebar" id="sidebar">
     {{staffCan('th')}}
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
        @if(session('is_admin') == 0)
        <ul>
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a  href="{{url('staff/index')}}">Dashboard</a></li>
                        
                    </ul>
                </li>

                <li class="submenu">
                    <a href="#"><i class="la la-users"></i> <span> HR </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        {{-- <li><a href="{{url('staff/payslip')}}">Pay Slip</a></li> --}}
                        <li><a href="{{url('staff/leaves')}}"> My Leaves </a></li>
                        <li><a href="{{url('attendance/staffAttendance')}}"> Attendance </a></li>
                    </ul>
                </li>
                
                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Projects & Tasks </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{url('staff/projects')}}"> Projects </a></li>
                        <li><a href="{{url('staff/tasks')}}"> Tasks </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-graduation-cap"></i> <span> Trainings </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{url('staff/trainings')}}"> Trainings </a></li>
                        <li><a href="{{url('staff/list-requests')}}"> Requested Trainings </a></li>
                        <li><a href="{{url('staff/list-invites')}}"> Invited Trainings </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-money"></i> <span> Expenses </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{url('expenses/staff-expenses')}}"> Expenses </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-files-o"></i> <span> Payslip Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{url('staff/paye')}}"> PAYE Report </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="{{url('staff/settings')}}"> My Data </a></li>
                    </ul>
                </li>

            </ul>
        @endif  
        
        
        @if(session('is_admin') == 1)
        @php
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
        @endphp
        
        <ul>
           
                    @if(
                        staffCan('view.training') || 
                        staffCan('edit.training') || 
                        staffCan('invite.department') || 
                        staffCan('create.training') || 
                        staffCan('invite.individual') || 
                        staffCan('delete.training')
                    )
                        @if (in_array('trainings', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-graduation-cap"></i> <span> Trainings</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($moduleUrls['trainings'] as $moduleName => $moduleUrl)
                                    <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    @endif
                    
                    
                    @if(
                        staffCan('view.project') || 
                        staffCan('edit.project') || 
                        staffCan('delete.project') || 
                        staffCan('create.project') || 
                        
                        staffCan('view.task') || 
                        staffCan('edit.task') || 
                        staffCan('delete.task') || 
                        staffCan('create.task')
                    )
                    
                        @if (in_array('projects', $subscribedModules) || in_array('tasks', $subscribedModules))
                            <li class="submenu">
                                <a href="#"><i class="la la-rocket"></i> <span> Projects & Tasks </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    @if(
                                        staffCan('view.project') || 
                                        staffCan('edit.project') || 
                                        staffCan('delete.project') || 
                                        staffCan('create.project')
                                    )
                                        @if (in_array('projects', $subscribedModules))
                                            @foreach ($moduleUrls['projects'] as $moduleName => $moduleUrl)
                                                <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                            @endforeach
                                        @endif
                                    @endif
                                    
                                    @if(
                                        staffCan('view.task') || 
                                        staffCan('edit.task') || 
                                        staffCan('delete.task') || 
                                        staffCan('create.task')
                                    )
                                        @if (in_array('tasks', $subscribedModules))
                                            @foreach ($moduleUrls['tasks'] as $moduleName => $moduleUrl)
                                                <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                            @endforeach
                                        @endif
                                    @endif
                                </ul>
                            </li>
                        @endif
                        
                    @endif
                    
                    @if(
                        staffCan('create.company.profile') || 
                        staffCan('edit.email.settings') || 
                        staffCan('create.company.settings')
                    )
                        <li class="submenu">
                            <a href="#"><i class="la la-cog"></i> <span> User Admin </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @if(staffCan('create.company.profile'))
                                    <li><a href="{{url('company/profile')}}"> Company Profile </a></li>
                                @endif
                                
                                @if(staffCan('edit.email.settings'))
                                    <li><a href="{{url('company/settings')}}"> Company Settings </a></li>
                                @endif
                                
                                @if(staffCan('create.company.settings'))
                                    <li><a href="{{url('communications/mailSettings')}}"> Email Settings </a></li>
                                @endif
                                
                            </ul>
                        </li>
                    @endif
                   
                    
                    @if (in_array('payroll', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @if(staffCan('view.paye'))
                                    <li><a href="{{ url('payslip-reports/paye') }}"> Payslips </a></li>
                                @endif
                                
                                @if(staffCan('paye.tax.returns.report'))
                                    <li><a href="{{ url('payslip-reports/paye-tax') }}"> PAYE Tax Returns Report </a></li>
                                @endif
                                
                                @if(staffCan('view.tier.one'))
                                    <li><a href="{{ url('payslip-reports/tier-one') }}"> Tier One </a></li>
                                @endif
                                
                                @if(staffCan('view.tier.two'))
                                    <li><a href="{{ url('payslip-reports/tier-two') }}"> Tier Two </a></li>
                                @endif
                                
                                @if(staffCan('view.allowances'))
                                    <li><a href="{{ url('payslip-reports/allowances') }}"> Allowances Report </a></li>
                                @endif
                                
                                @if(staffCan('view.benefits.report'))
                                    <li><a href="{{ url('payslip-reports/benefits') }}"> Benefits Report </a></li>
                                @endif
                                
                                @if(staffCan('view.statutory.report'))
                                    <li><a href="{{ url('payslip-reports/statutory') }}"> Statutory Deductions </a></li>
                                @endif
                                
                                @if(staffCan('view.non.statutory.report'))
                                    <li><a href="{{ url('payslip-reports/non-statutory') }}"> Non Statutory Deductions </a></li>
                                @endif
                                
                                @if(staffCan('view.net.pay.to.bank.report'))
                                    <li><a href="{{ url('payslip-reports/bank-net-pay') }}"> Net Pay to Bank Report </a></li>
                                @endif
                                
                            </ul>
                        </li>
                    @endif
                    
                    
                    @if(
                        staffCan('view.expenses') || 
                        staffCan('delete.expense') || 
                        staffCan('approve.expense')
                    )
                        @if (in_array('expenses', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span> Expenses</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($moduleUrls['expenses'] as $moduleName => $moduleUrl)
                                    <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        
                    @endif
                    
                    
                    
                    @if(
                        staffCan('view.emails') || 
                        staffCan('edit.template') || 
                        staffCan('edit.template') ||
                        staffCan('delete.template')
                    )
                        @if (in_array('bulky_email', $subscribedModules))
                            <li class="submenu">
                                <a href="#"><i class="la la-bullhorn"></i> <span> Communications </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    @if(
                                        staffCan('view.emails') 
                                    )
                                        <li><a href="{{ url('communications/emails') }}"> Emails </a></li>
                                    @endif
                                    
                                    @if(
                                        staffCan('edit.template') || 
                                        staffCan('edit.template') ||
                                        staffCan('delete.template')
                                    )
                                        <li><a href="{{ url('communications/email-templates') }}"> Email Templates </a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endif
                    
                    
                    @if(
                        staffCan('view.leave') || 
                        staffCan('approve.leave') || 
                        staffCan('delete.leave') ||
                        staffCan('request.leave') ||
                        staffCan('decline.leave') 
                    )
                        @if (in_array('leaves', $subscribedModules))
                            <li class="submenu">
                                <a href="#"><i class="la la-user-secret"></i> <span> Leaves </span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    @foreach ($moduleUrls['leaves'] as $moduleName => $moduleUrl)
                                        <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
        
                    @endif
                    </ul>
        
        </div>
    </div>
</div>
<!-- /Sidebar -->