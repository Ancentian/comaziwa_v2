<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

use DB;
use Auth;
use Session;
use Hash;
use Flash;
use PDF;
use App\Models\EmployeeGroup;
use App\Models\SalaryType;
use App\Models\ContractType;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\EmployeePayslip;

use App\Models\Leave;
use App\Models\PaySlips;
use App\Models\Attendance;
use App\Models\EmailSettings;
use App\Models\LeaveType;
use App\Mail\SendMail;
use App\Mail\SendNotification;
use App\Models\User;
use Carbon\Carbon;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class StaffController extends Controller
{
    public function index()
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        
        $employee = Employee::where('employees.id', $employee_id)
            ->where('employees.tenant_id', $tenant_id)
            ->first();
    
        return view('companies.staff.index', compact('employee'));
    }

    

    public function settings()
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        
        $employee = Employee::where('employees.id', $employee_id)
            ->where('employees.tenant_id', $tenant_id)
            ->first();
        
        return view('companies.staff.settings', compact('employee'));
    }

    public function payslip(){
        $id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $employee = Employee::findOrFail($id);
        $basic_salary = EmployeePayslip::where('employee_id',$id)->where('type','basic_salary')->first();
        $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
        
        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('companies.staff.payslip.payslip',compact('basic_salary','employee','allowance','benefit','non_statutoryded','statutoryDed'));
    }

    public function leaves()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $leave_types = LeaveType::where('tenant_id', $tenant_id)->get();
        $supervisors = Employee::where('tenant_id', $tenant_id)->where('is_admin_configured', 1)->get();
        if (request()->ajax()) {
            $employee_id = optional(auth()->guard('employee')->user())->id;
            $leaves = Leave::join('employees','employees.id','=','leaves.employee_id')
                            ->join('leave_types','leave_types.id','leaves.type')
                            ->where('leaves.employee_id', $employee_id)
                            ->select([
                                'employees.name as employeeName',
                                'leaves.*',
                                'leave_types.type_name as type'
                            ]);
                            
                            if(!empty(request()->date_from) && !empty(request()->date_to))
                            {
                                $leaves->whereDate('leaves.date_from','>=',request()->date_from);
                                $leaves->whereDate('leaves.date_to','<=',request()->date_to);
                            }
                            
                            if(request()->status != ''){
                                $leaves->where('leaves.status','=',request()->status);
                            }
                
                        if(!empty(request()->type)){
                            $leaves->where('leaves.type','=',request()->type);
                        }

                        if(session('is_admin') == 1)
                        {
                            $employee_id = optional(auth()->guard('employee')->user())->id;
                            $leaves->where('leaves.supervisor_id', $employee_id);
                        }
                            
                            
            return DataTables::of($leaves->latest()->get())  
                ->editColumn('date_from', function ($row) {
                    $html = format_date($row->date_from);
                    return $html;
                })  
                ->editColumn('date_to', function ($row) {
                    $html = format_date($row->date_to);
                    return $html;
                })            
                ->addColumn(
                    'status', 
                function ($row) {
                    $html = '';
                    if ($row->status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                    } elseif ($row->status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                    }
                    return $html;
                })

                ->editColumn(
                    'type', 
                    function ($row) {
                    $html = str_replace('_', ' ', ucfirst($row->type));
                    return $html;
                })
                
            ->rawColumns(['status'])
            ->make(true);
        }
        return view('companies.staff.leaves.index', compact('leave_types', 'supervisors'));
    }

    public function allLeaves()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;;
            $leaves = Leave::leftJoin('employees', 'employees.id', '=', 'leaves.employee_id')
                ->join('leave_types', 'leave_types.id', '=', 'leaves.type')
                ->where('leaves.tenant_id', $tenant_id)
                ->select([
                    'employees.name as employeeName',
                    'leaves.*',
                    'leave_types.type_name as type'
                ])->get();

            return DataTables::of($leaves)
            ->addColumn(
                'action',
                function ($row) {
                    $statusHtml = '';
                    if ($row->status == '0') {
                        $statusHtml = '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>
                                        <a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                    } elseif ($row->status == '1') {
                        $statusHtml = '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                    } else {
                        $statusHtml = '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                    }
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ' . $statusHtml . '
                                    <a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-eye m-r-5"></i> View</a>
                                    <a class="dropdown-item delete-button" data-action="' . url('leaves/delete', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>';
                    
                    return $html;
                })
                ->editColumn('date_from', function ($row) {
                    $html = format_date($row->date_from);
                    return $html;
                })
                ->editColumn('date_to', function ($row) {
                    $html = format_date($row->date_to);
                    return $html;
                })

                ->editColumn(
                    'type', 
                    function ($row) {
                    $html = str_replace('_', ' ', ucfirst($row->type));
                    return $html;
                })                
                
                ->editColumn(
                    'status', 
                function ($row) {
                    $html = '';
                    if ($row->status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                    } elseif ($row->status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                    }
                    return $html;
                })
                
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        $leave_types = LeaveType::where('tenant_id',$tenant_id)->get();
        return view('companies.staff.leaves.all_staff_leaves', compact('employees','leave_types'));
    }

    public function storeLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required',
            'type'     => 'required',
            'date_from'     => 'required',
            'date_to'   => 'required',
            'remaining_days' => 'required',
            'supervisor_id' => 'required',
            'reasons'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        
        Leave::create([
            'tenant_id'     =>  optional(auth()->guard('employee')->user())->tenant_id,
            'employee_id'    => $request->employee_id,
            'type'          => $request->type,
            'date_from'     => $request->date_from,
            'date_to'       => $request->date_to, 
            'remaining_days' => $request->remaining_days, 
            'supervisor_id' => $request->supervisor_id, 
            'reasons'         => $request->reasons, 
        ]);
        

        DB::commit();
        
        // Notify: 
        $userdata = \App\Models\Employee::findOrFail(auth()->guard('employee')->user()->id);
        $tenant_id = $userdata['tenant_id'];
        $company = \App\Models\CompanyProfile::where('tenant_id', $tenant_id)->first();
        
        
        $supervisor = Employee::where('id', $request->supervisor_id)->first();
        $employee = Employee::where('id', $request->employee_id)->first();
        $leave = LeaveType::where('id', $request->type)->first();
        $company = \App\Models\CompanyProfile::where('tenant_id', $tenant_id)->first();
        if ($supervisor) {
            //To Supervisor
            $build_data = ['leave_type' =>str_replace('_', ' ', ucfirst($leave->type_name)) ,'supervisor' => $supervisor->name, 'employee' => $employee->name,'start_date' => format_date($request->date_from),'end_date' =>format_date($request->date_to), 'to_email' => $supervisor->email,'to_phone' => $supervisor->phone_no, 'company' => $company['name']];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('leave_requested', $build_data);
            //To Employee
            $build_data1 = ['leave_type' =>str_replace('_', ' ', ucfirst($leave->type_name)) ,'name' => $employee->name,'start_date' => format_date($request->date_from),'end_date' =>format_date($request->date_to), 'to_email' => $employee->email,'to_phone' => $userdata->phone_no, 'company' => $company['name']];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('leave_applied', $build_data1);
        } else {
            $build_data = ['leave_type' =>str_replace('_', ' ', ucfirst($request->type)) ,'name' => $userdata['name'],'start_date' => format_date($request->date_from),'end_date' =>format_date($request->date_to), 'to_email' => $userdata->email,'to_phone' => $userdata->phone_no, 'company' => $company['name']];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('leave_applied',$build_data);
        }
        return response()->json(['message' => 'Leave Request Sent Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function login()
    {
        return view('companies.staff.employeeLogin');
    }

    public function forgot_password()
    {
        return view('companies.staff.forgot_password');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
    ]);
    
    $email = $request->email;
    $password = $request->password;
    
    if (Auth::guard('employee')->attempt(['email' => $email, 'password' => $password])) {
        // Retrieve the authenticated user
        $user = Auth::guard('employee')->user();
        auth()->login($user);            
        return redirect()->intended('staff/index');
    } else {
        return redirect('staff/login')->withErrors(['error' => 'Invalid credentials']);
    }
    
    }

    public function logout(){
        auth()->guard('employee')->logout();
        return redirect('/staff/login');
    }

    public function paye(Request $request){
        if (request()->ajax()) {
            $employee_id = optional(auth()->guard('employee')->user())->id;
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            
            $report = PaySlips::where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period', 'LIKE', $pay_period.'-%')
                        ->where('employee_id',$employee_id)
                        ->select([                            
                            'pay_slips.*'                        
                        ])->get();

            
            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('staff/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('staff/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn(
                'pay_period',
                function ($row) {
                    return date('M, Y',strtotime($row->pay_period));
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        return view('companies.staff.reports.paye');
    }

    public function printPayslip(Request $request, $id, $action)
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $pay_period = $request->input('pay_period');
        $payslip = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                    ->where('pay_slips.id', $id)
                    ->select([
                        'employees.name',
                        'employees.staff_no',
                        'employees.ssn',
                        'employees.account_no',
                        'employees.bank_name',
                        'employees.position',
                        'pay_slips.*'                        
                    ])
                    ->first();


        $emp_name = optional(auth()->guard('employee')->user())->name;
        //$pay_period = date('M,Y', strtotime($pay_period));
        
        $nethistory = PaySlips::where('employee_id',$payslip->employee_id)
                                ->where('pay_period', 'LIKE', date('Y', strtotime($payslip->pay_period)) . '-%')
                                ->sum('net_pay');

        $company = company()->mycompany();
        $data = [
            'payslip' => $payslip,
            'company' => $company,
            'pay_period' => $pay_period,
            'nethistory' => $nethistory
        ];
 
        if ($action === 'download') {
            $pdf = PDF::loadView('companies.staff.reports.print_payslip', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $payslip->id."#".$emp_name.date('MY',strtotime($payslip->pay_period)) . " Payslip.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return response()->json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {           
            return view('companies.staff.reports.print_payslip', compact('payslip', 'pay_period', 'company','action'));
        }
    }


}
