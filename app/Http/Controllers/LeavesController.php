<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\LeaveDaysCalculator;
use App\Models\TransactionalEmails;
use DB;
use App\Models\LeaveType;
class LeavesController extends Controller
{
    public function index()
    { 
        
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employees = Employee::where('tenant_id', $tenant_id)->get();
            $leave_types = LeaveType::where('tenant_id',$tenant_id)->get();     

            return DataTables::of($employees)
            ->addColumn(
                'action',
                function ($row) {
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="'.url('leaves/employeeLeaves', [$row->id]).'"><i class="fa fa-eye m-r-5"></i> View</a>
                                </div>
                            </div>';
                    
                    return $html;
                })   
                
                ->addColumn(
                    'total', 
                    function ($row) use($leave_types) {
                        $html = "";
                        foreach($leave_types as $one){
                            $html .= "<strong>".$one->type_name."</strong>: ".LeaveDaysCalculator::calculateLeaveDays($row->id,$one->id)['total']."<br>";
                        }
                        return $html;
                })
                ->addColumn(
                    'taken', 
                    function ($row) use($leave_types) {
                        $html = "";
                        foreach($leave_types as $one){
                            $html .= "<strong>".$one->type_name."</strong>: ".LeaveDaysCalculator::calculateLeaveDays($row->id,$one->id)['taken']."<br>";
                        }
                        return $html;
                })

                ->addColumn(
                    'balance', 
                    function ($row) use($leave_types) {
                        $html = "";
                        foreach($leave_types as $one){
                            $html .= "<strong>".$one->type_name."</strong>: ".LeaveDaysCalculator::calculateLeaveDays($row->id,$one->id)['balance']."<br>";
                        }
                        return $html;
                })
            
                
            ->rawColumns(['action','balance','taken','total'])
            ->make(true);
        }
        return view('employees.leaves.index');
    }

    public function allLeaves()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $leaves = Leave::leftJoin('employees', 'employees.id', '=', 'leaves.employee_id')
                ->join('leave_types','leave_types.id','leaves.type')
                ->where('leaves.tenant_id', $tenant_id)
                ->select([
                    'employees.name as employeeName',
                    'leaves.*',
                    'leave_types.type_name as type'
                ]);

                if(session('is_admin') == 1)
                {
                    $employee_id = optional(auth()->guard('employee')->user())->id;
                    $leaves->where('leaves.supervisor_id', $employee_id);
                }
                
                if(!empty(request()->date_from) && !empty(request()->date_to)){
                    $leaves->whereDate('leaves.date_from','>=',request()->date_from);
                    $leaves->whereDate('leaves.date_to','<=',request()->date_to);
                }

                if(!empty(request()->type)){
                    $leaves->where('leaves.type','=',request()->type);
                }

                if(request()->status != ''){
                    $leaves->where('leaves.status','=',request()->status);
                }
                
                if(!empty(request()->applicant)){
                    $leaves->where('leaves.employee_id','=',request()->applicant);
                }

            return DataTables::of($leaves->get())
            ->addColumn(
                'action',
                function ($row) {
                    $statusHtml = '';
                    if ($row->status == '0' ) {
                        
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                        if(staffCan('decline.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                        }
                        
                    } elseif ($row->status == '1' && staffCan('decline.leave')) {
                        $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                    } else {
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                    }
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ' . $statusHtml;
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-eye m-r-5"></i> View</a>';
                                    }
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item delete-button" data-action="' . url('leaves/delete', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                                    }
                                    
                                    $html .= '
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
        return view('employees.leaves.all_leaves', compact('employees','leave_types'));
    }

    public function pendingLeaves()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $leave_types = LeaveType::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            logger(request()->applicant);
            $leaves = Leave::join('employees', 'employees.id', '=', 'leaves.employee_id')
                    ->join('leave_types','leave_types.id','leaves.type')
                    ->where('leaves.tenant_id', $tenant_id)
                    ->where('leaves.status', 0)
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
                
                if(!empty(request()->type)){
                    $leaves->where('leaves.type','=',request()->type);
                }
                
                if(!empty(request()->applicant)){
                    $leaves->where('leaves.employee_id','=',request()->applicant);
                }

                if(session('is_admin') == 1)
                {
                    $employee_id = optional(auth()->guard('employee')->user())->id;
                    $leaves->where('leaves.supervisor_id', $employee_id);
                }

            return DataTables::of($leaves->get())
            ->addColumn(
                'action',
                function ($row) {
                    $statusHtml = '';
                    if ($row->status == '0' ) {
                        
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                        if(staffCan('decline.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                        }
                        
                    } elseif ($row->status == '1' && staffCan('decline.leave')) {
                        $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                    } else {
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                    }
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ' . $statusHtml;
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-eye m-r-5"></i> View</a>';
                                    }
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item delete-button" data-action="' . url('leaves/delete', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                                    }
                                    
                                    $html .= '
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
        return view('employees.leaves.pending_leaves', compact('employees', 'leave_types'));
    }

    public function employeeLeaves($employee_id)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $leaves = Leave::join('employees', 'employees.id', '=', 'leaves.employee_id')
                    ->join('leave_types','leave_types.id','leaves.type')
                    ->where('leaves.tenant_id', $tenant_id)
                    ->where('leaves.employee_id', $employee_id)
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
                    if ($row->status == '0' ) {
                        
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                        if(staffCan('decline.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                        }
                        
                    } elseif ($row->status == '1' && staffCan('decline.leave')) {
                        $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="2" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-times m-r-5" style="color: red;"></i>Decline</a>';
                    } else {
                        if(staffCan('approve.leave')){
                            $statusHtml .= '<a class="dropdown-item leave-edit-button" data-id="1" data-action="' . url('leaves/approve', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5" style="color: green;"></i>Approve</a>';
                        }
                        
                    }
                    
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    ' . $statusHtml;
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item edit-button" data-action="' . url('leaves/edit', [$row->id]) . '" href="#"><i class="fa fa-eye m-r-5"></i> View</a>';
                                    }
                                    
                                    if(staffCan('view.leave')){
                                        $html .= '<a class="dropdown-item delete-button" data-action="' . url('leaves/delete', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                                    }
                                    
                                    $html .= '
                                </div>
                            </div>';
                    
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
        return view('employees.leaves.employee_leaves', compact('employee_id','leave_types'));
    }

    public function remaining_leave_days($id)
    {
        //LeaveDaysCalculator::calculateLeaveDays($id)['balance'];
        try {
            $type = request()->leave_type;
            
            $remaining_days = LeaveDaysCalculator::calculateLeaveDays($id,$type)['balance'];  
            return response()->json(['message' => $remaining_days ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required',
            'type'     => 'required',
            'date_from'     => 'required',
            'date_to'   => 'required',
            'remaining_days' => 'required',
            'reasons'    => 'required',
            
        ]);
        
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $remaining_days = LeaveDaysCalculator::calculateLeaveDays($request->employee_id,$request->type)['balance'];
        $dateFrom = strtotime($request->date_from);
        $dateTo = strtotime($request->date_to);
        $interval = $dateTo - $dateFrom;
        $numberOfDays = $interval / 86400;
        
        if($remaining_days < $numberOfDays){
            return response()->json(['errors' => ["leave_days" => ["Only $remaining_days days are remaining for this selection"]]], 422);
        }

        DB::beginTransaction();
        try {
        
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        Leave::create([
            'tenant_id'     =>  $tenant_id,
            'employee_id'    => $request->employee_id,
            'type'          => $request->type,
            'date_from'     => $request->date_from,
            'date_to'       => $request->date_to, 
            'remaining_days' => $request->remaining_days,  
            'reasons'         => $request->reasons, 
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Leave Request Sent Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
 
    }

    public function store_staffLeave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id'    => 'required',
            'type'     => 'required',
            'date_from'     => 'required',
            'date_to'   => 'required',
            'remaining_days' => 'required',
            'reasons'    => 'required',
            
        ]);
        
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $remaining_days = LeaveDaysCalculator::calculateLeaveDays($request->employee_id,$request->type)['balance'];
        $dateFrom = strtotime($request->date_from);
        $dateTo = strtotime($request->date_to);
        $interval = $dateTo - $dateFrom;
        $numberOfDays = $interval / 86400;
        
        if($remaining_days < $numberOfDays){
            return response()->json(['errors' => ["leave_days" => ["Only $remaining_days days are remaining for this selection"]]], 422);
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
            'reasons'         => $request->reasons, 
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Leave Request Sent Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
 
    }

    public function edit($id){
        $leave = Leave::findOrFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $leave_types = LeaveType::where('tenant_id', $tenant_id)->get();
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('employees.leaves.edit',compact('leave', 'employees', 'leave_types'));
    }

    public function approve($id){
        $leave = Leave::findOrFail($id);
        $tenant_id = auth()->user()->id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('employees.leaves.approve',compact('leave', 'employees'));
    }

    public function decline($id){
        $leave = Leave::findOrFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        return view('employees.leaves.decline',compact('leave', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_id'    => 'required',
            'type'     => 'required',
            'date_from'     => 'required',
            'date_to'   => 'required',
            'reasons'    => 'required',
        ]);

        DB::beginTransaction();
        try {

        $leave = Leave::findOrFail($id);
        $leave->employee_id = $request->employee_id;
        $leave->type = $request->type;
        $leave->date_from = $request->date_from;
        $leave->date_to = $request->date_to;
        $leave->reasons = $request->reasons;
        $leave->save();

        DB::commit();
            return response()->json(['message' => 'Leave Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        DB::beginTransaction();
        try {

        $leave = Leave::findOrFail($id);
        $leave->status = $request->status;
        $leave->save();
        
        $userdata = \App\Models\Employee::where('id', $leave['employee_id'])->first();
        $company = \App\Models\CompanyProfile::where('tenant_id', $leave['tenant_id'])->first();
        
        if($request->status  == 1){
            $type = "Approved";
            $build_data = ['name' => $userdata['name'], 'company'=> $company['name'], 'leave_type' => LeaveType::findOrFail($leave['type'])->type_name,'to_email' => $userdata['email'],'to_phone' => $userdata['phone_no'], 'start_date' => format_date($leave['date_from']),'end_date' =>format_date($leave['date_to'])];
            $emaildata = TransactionalEmails::buildMsg('leave_approved',$build_data);
        }elseif($request->status == 2){
            $type = "Declined";
            $build_data = ['name' => $userdata['name'], 'company'=> $company['name'], 'leave_type' => LeaveType::findOrFail($leave['type'])->type_name,'to_email' => $userdata['email'],'to_phone' => $userdata['phone_no'], 'start_date' => format_date($leave['date_from']),'end_date' =>format_date($leave['date_to'])];
            $emaildata = TransactionalEmails::buildMsg('leave_declined',$build_data);
        }
        
        
        if(!empty($type)){
            $employee = Employee::findOrFail($leave->employee_id);
            $build_data = ['response_type' => $type,'name' => $employee->name, 'leave_type' => LeaveType::findOrFail($leave->type)->type_name,'to_email' => $employee->email,'to_phone' => $employee->phone_no];
            $emaildata = TransactionalEmails::buildMsg('leave_response',$build_data);
        
        }
        

        DB::commit();
            return response()->json(['success' => 'Leave Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            logger($e);
            return response()->json(['error' => 'Data saving failed. Please try again.'], 500);
        }

        return response()->json(['success' => 'Leave Approve successfully']);
    }

    public function declineLeave(Request $request, $id)
    {
        $request->validate([
            'status' => "2",
        ]);

        DB::beginTransaction();
        try {
        $leave = Leave::findOrFail($id);

        $leave->status = $request->status;
        $leave->save();
        
        $type = 'Declined';
        
        if(!empty($type)){
            $employee = Employee::findOrFail($leave->employee_id);
            $build_data = ['response_type' => $type,'name' => $employee->name, 'leave_type' => LeaveType::findOrFail($leave->type)->type_name,'to_email' => $employee->email,'to_phone' => $employee->phone_no];
            $emaildata = TransactionalEmails::buildMsg('leave_response',$build_data);
        
        }

        DB::commit();
            return response()->json(['message' => 'Leave Declined successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
        $leave = Leave::findOrFail($id);
        $leave->delete();

        DB::commit();
            return response()->json(['message' => 'Leave Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }
}
