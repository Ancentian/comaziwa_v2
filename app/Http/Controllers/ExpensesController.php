<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;

class ExpensesController extends Controller
{
    public function index()
    {
        $expense_types = ExpenseType::all();
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $is_admin_configured = optional(auth()->guard('employee')->user())->is_admin_configured;
            $expenses = Expense::join('expense_types', 'expense_types.id', '=', 'expenses.type_id')
                    ->join('employees', 'employees.id', '=', 'expenses.employee_id')
                    ->where('expenses.tenant_id', $tenant_id)
                    ->select([
                        'expense_types.name as expenseName',
                        'employees.name as employeeName',
                        'employees.is_admin_configured',
                        'expenses.*'
                    ])->orderByDesc('expenses.created_at');
                    
                    if(session('is_admin') == 1)
                    {
                        $employee_id = optional(auth()->guard('employee')->user())->id;
                        $expenses->where('expenses.supervisor', $employee_id);
                    }

            return DataTables::of($expenses )
            ->editColumn('purpose', function ($row) {
                return '<a class="badge btn-success edit-button" data-action="'.url('expenses/view-purpose', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
            })
            ->editColumn('date', function ($row) {
                $html = format_date($row->date);
                return $html;
            })
            ->editColumn('amount', function ($row) {
                $html = num_format($row->amount);
                return $html;
            })            
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if ($row->approval_status == 0 && $row->payment_status == 0 && staffCan('approve.expense')) {  
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('expenses/approve-request', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Approve</a>';
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('expenses/approve-request',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                    }elseif ($row->approval_status == 1 && staffCan('approve.expense')) {
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('expenses/approve-request',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                        
                        if($row->payment_status == 0 && $row->is_admin_configured == 1){
                            $html .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="'.url('expenses/edit-payment-status',[$row->id]).'" href="#" ><i class="fa fa-usd m-r-5"></i> Mark as Paid</a>';
                        }else{
                            $html .= '<a class="dropdown-item expense-edit-button" data-id="0" data-action="'.url('expenses/edit-payment-status',[$row->id]).'" href="#" ><i class="fa fa-usd m-r-5 text-danger"></i> Mark as UnPaid</a>';
                        }
                        
                    }elseif($row->approval_status == 2 && staffCan('approve.expense')){
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="1"  data-action="'.url('expenses/approve-request',[$row->id]).'" href="#"><i class="fa fa-check m-r-5 text-success"></i> Approve </a>';
                    }
                    
                    if(staffCan('delete.expense')){
                        $html .= '<a class="dropdown-item delete-button" data-action="'.url('expenses/delete-expense', [$row->id]).'" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                    
                    $html .='
                    </div>
                </div>';
            
                return $html;
            })
    

            ->editColumn(
                'approval_status', 
            function ($row) {
                $html = '';
                if ($row->approval_status == "2") {
                    $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                } elseif ($row->approval_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                } elseif ($row->approval_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })

            ->editColumn(
                'payment_status', 
            function ($row) {
                $html = '';
                if ($row->payment_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Paid</span>";
                } elseif ($row->payment_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })
            ->rawColumns(['action','approval_status','payment_status', 'purpose', 'amount','date'])
            ->make(true);
        }
        return view('companies.expenses.index', compact('expense_types'));
    }

    public function expense_types()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $expense_types = ExpenseType::where('tenant_id', $tenant_id)->get();

            return DataTables::of($expense_types )
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('expenses/edit_expense-type',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('expenses/delete-expense-type',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('companies.staff.expenses.index', compact('expense_types'));
    }

    public function staff_expenses()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $expense_types = ExpenseType::where('tenant_id', $tenant_id)->get();
        $supervisors = Employee::where('tenant_id', $tenant_id)->where('is_admin_configured', 1)->get();
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $employee_id = optional(auth()->guard('employee')->user())->id;
            $expenses = Expense::join('expense_types', 'expense_types.id', '=', 'expenses.type_id')
                ->join('employees', 'employees.id', '=', 'expenses.employee_id')
                ->where('expenses.tenant_id', $tenant_id)
                ->where('expenses.employee_id', $employee_id)
                ->select([
                    'expense_types.name as expenseName',
                    'employees.name as employeeName',
                    'expenses.*'
                ])
                ->orderByDesc('expenses.created_at')
                ->get();

            return DataTables::of($expenses )
            ->editColumn('purpose', function ($row) {
                return '<a class="badge btn-success edit-button" data-action="'.url('expenses/view-purpose', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
            })
            ->editColumn('date', function ($row) {
                $html = format_date($row->date);
                return $html;
            })
            ->editColumn('amount', function ($row) {
                $html = num_format($row->amount);
                return $html;
            })
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';  
                    if ($row->approval_status == 0 ) {  
                        $html .= '<a class="dropdown-item edit-button" data-action="'.url('expenses/edit-staff-expense',[$row->id]).'" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                        $html .= '<a class="dropdown-item delete-button" data-action="'.url('expenses/delete-staff-expense',[$row->id]).'" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                $html .= '
                    </div>
                </div>';
                
                return $html;
            })                      
  
            ->editColumn(
                'approval_status', 
            function ($row) {
                $html = '';
                if ($row->approval_status == "2") {
                    $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                } elseif ($row->approval_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                } elseif ($row->approval_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })

            ->editColumn(
                'payment_status', 
            function ($row) {
                $html = '';
                if ($row->payment_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Paid</span>";
                } elseif ($row->payment_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })
            ->rawColumns(['action', 'approval_status', 'payment_status', 'purpose'])
            ->make(true);
        }
        return view('companies.staff.expenses.index', compact('expense_types', 'supervisors'));	
    }

    public function all_staff_expenses()
    {
        $expense_types = ExpenseType::all();
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $expenses = Expense::join('expense_types', 'expense_types.id', '=', 'expenses.type_id')
                    ->join('employees', 'employees.tenant_id', '=', 'expenses.tenant_id')
                    ->where('expenses.tenant_id', $tenant_id)
                    ->select([
                        'expense_types.name as expenseName',
                        'employees.name as employeeName',
                        'expenses.*'
                    ])->orderByDesc('expenses.created_at')
                    ->get();

            return DataTables::of($expenses )
            ->editColumn('purpose', function ($row) {
                return '<a class="badge btn-success edit-button" data-action="'.url('expenses/view-purpose', [$row->id]).'" <i class="fa fa-trash-o m-r-5"></i> View</a>'; 
            })
            ->editColumn('date', function ($row) {
                $html = format_date($row->date);
                return $html;
            })
            ->editColumn('amount', function ($row) {
                $html = num_format($row->amount);
                return $html;
            })            
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                    if ($row->approval_status == 0 && $row->payment_status == 0 && staffCan('approve.expense')) {  
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="' . url('expenses/approve-request', [$row->id]) . '" href="#"><i class="fa fa-check m-r-5 text-success" ></i>Approve</a>';
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('expenses/approve-request',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                    }elseif ($row->approval_status == 1  && staffCan('approve.expense')) {
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="2" data-action="'.url('expenses/approve-request',[$row->id]).'" href="#" ><i class="fa fa-times m-r-5 text-danger"></i> Decline</a>';
                        
                        if($row->payment_status == 0){
                            $html .= '<a class="dropdown-item expense-edit-button" data-id="1" data-action="'.url('expenses/edit-payment-status',[$row->id]).'" href="#" ><i class="fa fa-usd m-r-5"></i> Mark as Paid</a>';
                        }else{
                            $html .= '<a class="dropdown-item expense-edit-button" data-id="0" data-action="'.url('expenses/edit-payment-status',[$row->id]).'" href="#" ><i class="fa fa-usd m-r-5 text-danger"></i> Mark as UnPaid</a>';
                        }
                        
                    }elseif($row->approval_status == 2 && staffCan('approve.expense')){
                        $html .= '<a class="dropdown-item expense-edit-button" data-id="1"  data-action="'.url('expenses/approve-request',[$row->id]).'" href="#"><i class="fa fa-check m-r-5 text-success"></i> Approve </a>';
                    }
                    
                   if(staffCan('delete.expense')){
                        $html .= '<a class="dropdown-item delete-button" data-action="'.url('expenses/delete-expense', [$row->id]).'" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                   }
                   
                   $html .='
                    </div>
                </div>';
            
                return $html;
            })
    

            ->editColumn(
                'approval_status', 
            function ($row) {
                $html = '';
                if ($row->approval_status == "2") {
                    $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Declined</span>';
                } elseif ($row->approval_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Approved</span>";
                } elseif ($row->approval_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })

            ->editColumn(
                'payment_status', 
            function ($row) {
                $html = '';
                if ($row->payment_status == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Paid</span>";
                } elseif ($row->payment_status == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Pending</span>";
                }
                return $html;
            })
            ->rawColumns(['action','approval_status','payment_status', 'purpose', 'amount','date'])
            ->make(true);
        }
        return view('companies.staff.expenses.all_expenses', compact('expense_types'));
    }

    public function store_expenseTypes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        ExpenseType::create([
            'tenant_id'  => $tenant_id,
            'name'       => $request->name,  
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Expense Type Added Successfully']);
        } catch (\Exception $e) {
            
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_expenseRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'date' => 'required',
            'purpose' => 'required',
            'supervisor' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

        Expense::create([
            'tenant_id'     => optional(auth()->guard('employee')->user())->tenant_id,
            'type_id'       => $request->type_id, 
            'employee_id'   => optional(auth()->guard('employee')->user())->id,
            'date'          => $request->date,
            'purpose'       => $request->purpose,
            'supervisor'    => $request->supervisor,	
            'amount'        => $request->amount,
        ]);
        
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        // Notify: 
        $expense_type = ExpenseType::findOrFail($request->type_id);
        $admin = \App\Models\User::findOrFail(auth()->guard('employee')->user()->tenant_id);
        $supervisor = Employee::where('id', $request->supervisor)->first();
        $company = \App\Models\CompanyProfile::where('tenant_id', $tenant_id)->first();
        if ($supervisor) {
            $supervisorName = $supervisor->name;
            $supervisorEmail = $supervisor->email;
            $build_data = ['date' => $request->date,'expense_type' => $expense_type->name,'name' => auth()->guard('employee')->user()->name,'amount' => $request->amount, 'date' => $request->date, 'purpose' => $request->purpose, 'to_email' => $supervisorEmail, 'supervisor' => $supervisorName, 'company'=> $company['name']];	
            $emaildata = \App\Models\TransactionalEmails::buildMsg('expense_requested',$build_data);
        } else {
            $build_data = ['date' => $request->date,'expense_type' => $expense_type->name ,'name' => auth()->guard('employee')->user()->name,'amount' => $request->amount,'reason' => $request->purpose, 'to_email' => $admin->email];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('expense_requested',$build_data);
        }
        
        DB::commit();
        return response()->json(['message' => 'Expenses Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_staff_expense($id)
    {
        $expense_types = ExpenseType::all();
        $expense = Expense::findorFail($id);
        return view('companies.staff.expenses.edit_expense', compact('expense', 'expense_types'));
    }

    public function edit_expense_status($id)
    {
        $expense = Expense::findorFail($id);
        return view('companies.expenses.approve', compact('expense'));
    }

    public function edit_payment_status($id)
    {
        $expense = Expense::findorFail($id);
        return view('companies.expenses.payment', compact('expense'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'approval_status' => 'required',
        ]);

        DB::beginTransaction();
        try {

        $expense = Expense::findOrFail($id);
        $expense->approval_status = $request->approval_status;
        $expense->save();
        
        if($request->approval_status  == 1){
            $type = "Approved";
        }elseif($request->approval_status == 2){
            $type = "Declined";
        }
        
        
        if(!empty($type)){
            $expense_type = ExpenseType::findOrFail($expense->type_id);
            $employee = Employee::findOrFail($expense->employee_id);
            $build_data = ['response_type' => $type,'name' => $employee->name, 'expense_type' => $expense_type->name,'to_email' => $employee->email,'to_phone' => $employee->phone_no];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('expense_response',$build_data);
        
        }

        DB::commit();
            return response()->json(['message' => 'Expense Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

        return response()->json(['message' => 'Leave Approve successfully']);
    }

    public function view_expensePurpose($id)
    {
        $expense = Expense::join('employees', 'expenses.employee_id', '=', 'employees.id')
        ->select([
            'employees.name as employeeName',
            'expenses.*'
        ])->findOrFail($id);
        return view('companies.staff.expenses.view_purpose', compact('expense'));
    
    }

    public function update_paymentStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required',
        ]);

        DB::beginTransaction();
        try {

        $expense = Expense::findOrFail($id);
        $expense->payment_status = $request->payment_status;
        $expense->save();
        
        if($request->payment_status  == 1){
            $type = "Paid";
        }
        
        
        if(!empty($type)){
            $expense_type = ExpenseType::findOrFail($expense->type_id);
            $employee = Employee::findOrFail($expense->employee_id);
            $build_data = ['response_type' => $type,'name' => $employee->name, 'expense_type' => $expense_type->name,'to_email' => $employee->email,'to_phone' => $employee->phone_no];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('expense_response',$build_data);
        
        }
        

        DB::commit();
            return response()->json(['message' => 'Payment Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_staffExpense(Request $request, $id)
    {
        $request->validate([
            'type_id' => 'required',
            'date' => 'required',
            'purpose' => 'required',
            'amount' => 'required',
        ]);
        DB::beginTransaction();
        try {

        $expense = Expense::findOrFail($id);
        $expense->type_id = $request->type_id;
        $expense->date = $request->date;
        $expense->purpose = $request->purpose;
        $expense->amount = $request->amount;
        $expense->save();

        DB::commit();
            return response()->json(['message' => 'Expense Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function delete_expense_type($id)
    {
        DB::beginTransaction();
        try {
        $expense = ExpenseType::findOrFail($id);
        $expense->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_staff_expense($id)
    {
        DB::beginTransaction();
        try {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_expense($id)
    {
        DB::beginTransaction();
        try {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }
}
