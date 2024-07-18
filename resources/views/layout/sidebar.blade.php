<!-- Sidebar -->
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
                'farmers' => 'cooperative/farmers',
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
    ];

    }
@endphp

<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @if(auth()->user()->type == 'superadmin')
                            <li><a href="{{url('superadmin/dashboard')}}">Dashboard</a></li>                    
                        @else
                            <li><a href="{{url('dashboard/index')}}">Dashboard</a></li>  
                        @endif
                    </ul>
                </li>

                @if(auth()->user()->type == 'superadmin')                  
                    
                    <li class="submenu">
                        <a href="#"><i class="la la-user-plus"></i> <span> User Management </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('superadmin/list/users')}}">System Admins</a></li>
                            <li><a href="{{url('superadmin/list/roles')}}">Roles</a></li>
                            <li><a href="{{url('superadmin/list/agents')}}">Agents</a></li>
                            
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-users"></i> <span> Client Management </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('superadmin/list/clients')}}">Clients</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('packages/list')}}"> Packages </a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-money"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @if(usercan('view.revenue.reports'))
                                <li><a href="{{url('superadmin/subscription-plans')}}"> Revenue </a></li>
                            @endif
                        </ul>
                    </li>
                @else
                
                
                    @if (in_array('hr', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-users"></i> <span> HR </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($moduleUrls['hr'] as $moduleName => $moduleUrl)
                                    <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                @endforeach
                                @if (in_array('attendance', $subscribedModules))
                                    @foreach ($moduleUrls['attendance'] as $moduleName => $moduleUrl)
                                        <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endif

                    <li class="submenu">
                        <a href="#"><i class="la la-cubes"></i> <span> Milk Collection </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('milkCollection/add-collection')}}">Add Collection</a></li>
                            <li><a href="{{url('milkCollection/index')}}">Milk List</a></li>  
                            <li><a href="{{url('milk-management/spillages')}}">Milk Spillages</a></li>                          
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cubes"></i> <span> Store </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('sales/add-sales')}}">Add Sales</a></li>
                            <li><a href="{{url('sales/index')}}">All Sales</a></li>
                            <li><a href="{{url('inventory/all-inventory')}}">Inventory List</a></li> 
                            <li><a href="{{url('inventory/categories')}}">Categories</a></li> 
                            <li><a href="{{url('inventory/units')}}">Units</a></li>                          
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cubes"></i> <span> Deductions </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('deductions/index')}}">List</a></li>
                            <li><a href="{{url('deductions/add-deduction')}}">Add Deduction</a></li>
                            <li><a href="{{url('deductions/deduction-types')}}"> Deduction Types</a></li> 
                            <li><a href="{{url('shares/index')}}"> Shares</a></li>                         
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Settings </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('company/profile')}}"> Collection Centers </a></li>
                            <li><a href="{{url('company/settings')}}"> Company Settings </a></li>
                            <li><a href="{{url('communications/mailSettings')}}"> Email Settings </a></li>
                            <li><a href="{{url('shares/shares-settings')}}"> Shares Settings </a></li>
                            @if(auth()->user()->type == 'superadmin')
                                <li><a href="{{url('packages/list')}}"> Packages </a></li>
                            @endif
                        </ul>
                    </li>
                    
                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> User Admin </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('company/profile')}}"> Company Profile </a></li>
                            <li><a href="{{url('company/settings')}}"> Company Settings </a></li>
                            <li><a href="{{url('communications/mailSettings')}}"> Email Settings </a></li>
                            @if(auth()->user()->type == 'superadmin')
                                <li><a href="{{url('packages/list')}}"> Packages </a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Assets </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('assets/index')}}"> Assets List </a></li>
                            <li><a href="{{url('assets/categories')}}"> Categories </a></li>
                        </ul>
                    </li>

                    <li class="submenu">
                        <a href="#"><i class="la la-cog"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="{{url('payments/index')}}"> Payments List </a></li>
                            <li><a href="{{url('payments/generate-payments')}}"> Generate Payments </a></li>
                        </ul>
                    </li>
                    
                    @if (in_array('payroll', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-money"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($moduleUrls['payroll'] as $moduleName => $moduleUrl)
                                    <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    
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
                    
                    @if (in_array('bulky_email', $subscribedModules))
                        <li class="submenu">
                            <a href="#"><i class="la la-bullhorn"></i> <span> Communications </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @foreach ($moduleUrls['bulky_email'] as $moduleName => $moduleUrl)
                                    <li><a href="{{ url($moduleUrl) }}"> {{ ucfirst($moduleName) }} </a></li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    
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

                  
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->