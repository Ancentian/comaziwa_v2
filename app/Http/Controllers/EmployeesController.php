<?php

namespace App\Http\Controllers;

use App\Models\EmployeeGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\ContractType;
use App\Models\Employee;
use App\Models\EmployeePayslip;
use App\Models\SalaryType;
use App\Models\StatutoryDeduction;
use App\Models\NonStatutoryDeduction;
use App\Models\Allowance;
use App\Models\BenefitsInKind;
use App\Models\PaySlips;
use App\Models\TaxCalculator;
use App\Models\EmployeePermission;
use App\Models\EmployeeAssignedPermission;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Excel;

class EmployeesController extends Controller
{
    public function index(){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employees = Employee::where('tenant_id', $tenant_id)->get();

            return DataTables::of($employees)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" href="' . url('employees/generatePayslip', [$row->id]) . '">Payslip Settings</a>
                      <a class="dropdown-item edit-button" data-action="' . url('employees/staff-generate-monthly-payslip', [$row->id]) . '" href="#">Generate Payslip</a>
                      <a class="dropdown-item edit-button" data-action="' . url('employees/edit', [$row->id]) . '" href="#">Edit</a>
                      <a class="dropdown-item edit-button" data-action="' . url('employees/assign-permissions', [$row->id]) . '" href="#">Assign Permissions</a>
                      <a class="dropdown-item delete-button" data-action="' . url('employees/delete', [$row->id]) . '" href="#">Delete</a>
                    </div>
                  </div>';
                  return $html;
                }
            )
            ->editColumn('dob', function ($row) {
                $html = format_date($row->dob);
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('employees.index');
    }

    public function all_staff(){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employees = Employee::where('tenant_id', $tenant_id)->get();

            return DataTables::of($employees)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" href="' . url('employees/generatePayslip', [$row->id]) . '">Payslip Settings</a>
                      <a class="dropdown-item edit-button" data-action="' . url('employees/generate-monthly-payslip', [$row->id]) . '" href="#">Generate Payslip</a>
                      <a class="dropdown-item edit-button" data-action="' . url('staff/edit-staff', [$row->id]) . '" href="#">Edit</a>
                      <a class="dropdown-item delete-button" data-action="' . url('employees/delete', [$row->id]) . '" href="#">Delete</a>
                    </div>
                  </div>';
                  return $html;
                }
            )
            ->editColumn('dob', function ($row) {
                $html = format_date($row->dob);
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('companies.staff.all_staff');
    }

    public function generateMonthlyPayslip($id){
        $employee = Employee::findOrFail($id);
        $basic_salary = EmployeePayslip::where('employee_id',$id)->where('type','basic_salary')->first();
        $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();
        return view('employees.generate_monthly_payslip',compact('basic_salary','employee','allowance','benefit','non_statutoryded','statutoryDed'));
    }

    public function staffGenerateMonthlyPayslip($id){
        $employee = Employee::findOrFail($id);
        $basic_salary = EmployeePayslip::where('employee_id',$id)->where('type','basic_salary')->first();
        $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();
        return view('employees.staff_generate_monthly_payslip',compact('basic_salary','employee','allowance','benefit','non_statutoryded','statutoryDed'));
    }
    
    
    public function bulkGenerate(Request $request){
        // Set maximum PHP execution time to unlimited
        ini_set('max_execution_time', 0);
        
        // Set the memory limit to unlimited
        ini_set('memory_limit', -1);


        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id',$tenant_id)->get();
        
        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();
        
        DB::beginTransaction();
    
        try {
            
            foreach($employees as $employee){
                $basic_salary = EmployeePayslip::where('employee_id',$employee->id)->where('type','basic_salary')->first();
                $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
                
                $total_allowance = 0;
                $total_benefit = 0;
                $total_stat = 0;
                $total_nonstat = 0;
                
                $allowance_array = [];
                $benefit_array = [];
                $stat_array = [];
                $nonstat_array = [];
                
                foreach ($allowance as $item){
                    
                        $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                    ->where('type','allowance')
                                                    ->where('source_id',$item->id)->first();
                        if(!empty($itemValue)){
                            $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                            $total_allowance += $itemVal;
                            $allowance_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                        }
                    
                }
                foreach ($benefit as $item){
                            
                                $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                            ->where('type','benefit')
                                                            ->where('source_id',$item->id)->first();
                                if(!empty($itemValue)){
                                    $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                    $total_benefit += $itemVal;
                                    $benefit_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                                }
                            
                        }
                        
                foreach ($statutoryDed as $item){
                    
                        $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                    ->where('type','statutory_ded')
                                                    ->where('source_id',$item->id)->first();
                        if(!empty($itemValue)){
                            $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                            $total_stat += $itemVal;
                            $stat_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                        }
                    
                }
                
                foreach ($non_statutoryded as $item){
                        $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                    ->where('type','nonstatutory_ded')
                                                    ->where('source_id',$item->id)->first();
                        if(!empty($itemValue)){
                            $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                            $total_nonstat += $itemVal;
                            $nonstat_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                        }
                    
                }
                
                $salary = $basic_salary + $total_allowance + $total_benefit - $total_stat; 
                
                $total_tax = TaxCalculator::calculateTax($salary);
                $net_pay = $salary-$total_tax-$total_nonstat;
                
                $allowances = json_encode($allowance_array);
                $benefits = json_encode($benefit_array);
                $stats = json_encode($stat_array);
                $nonstats = json_encode($nonstat_array);
                
                
                $input = ['employee_id' => $employee->id,'basic_salary' => $basic_salary,'paye' => $total_tax,'net_pay' => $net_pay,
                        'pay_period' => $request->pay_period,'allowances' => $allowances,'benefits' => $benefits,'statutory_deductions' => $stats,'nonstatutory_deductions' => $nonstats];
                //$input['tenant_id'] = auth()->user()->id;
                if(session('is_admin') == 1)
                {
                    $input['tenant_id'] = optional(auth()->guard('employee')->user())->tenant_id;
                }else{
                    $input['tenant_id'] = auth()->user()->id;
                }
                
                PaySlips::updateOrCreate(['employee_id' => $input['employee_id'],'pay_period' => $input['pay_period']], $input);
            }
    
            DB::commit();
            return response()->json(['message' => 'Payslips generated successfully']);
            
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Something went wrong. Please try again.'], 500);
        }
        
    }

    public function postMonthlyPayslip(Request $request){
        $input = $request->only(['employee_id','basic_salary','paye','net_pay','pay_period','allowances','benefits','statutory_deductions','nonstatutory_deductions']);
        //$input['tenant_id'] = auth()->user()->id;
        if(session('is_admin') == 1)
        {
            $input['tenant_id'] = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $input['tenant_id'] = auth()->user()->id;
        }
        PaySlips::updateOrCreate(['employee_id' => $input['employee_id'],'pay_period' => $input['pay_period']], $input);
        return response()->json(['message' => 'Successful']);
    }
    
    

    public function indexEmployeeGroup()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $employeeGroup = EmployeeGroup::where('tenant_id',$tenant_id)->get();

            return DataTables::of($employeeGroup)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('employees/edit_employeesGroup',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('employees/delete_employeesGroup',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create()
    {
        $tenant_id = auth()->user()->id;
        $employeeGroup = EmployeeGroup::where('tenant_id',$tenant_id)->get();
        $salary = SalaryType::where('tenant_id',$tenant_id)->get();
        $contracts = ContractType::all();

        return view('employees.create',compact('employeeGroup','salary','contracts'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employeeGroup = EmployeeGroup::where('tenant_id',$tenant_id)->get();
        $salary = SalaryType::where('tenant_id',$tenant_id)->get();
        $contracts = ContractType::where('tenant_id',$tenant_id)->get();

        return view('employees.edit',compact('employeeGroup','salary','contracts','employee'));
    }

    public function edit_staff($id)
    {
        $employee = Employee::findOrFail($id);
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employeeGroup = EmployeeGroup::where('tenant_id',$tenant_id)->get();
        $salary = SalaryType::where('tenant_id',$tenant_id)->get();
        $contracts = ContractType::all();

        return view('employees.edit',compact('employeeGroup','salary','contracts','employee'));
    }
 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:employees',
            'password' => 'required|string|min:6',
            'phone_no' => 'required|string|unique:employees',
            'staff_no' => 'required|string|unique:employees',
            'position' => 'required|string',
            'dob' => 'required|date',
            'bank_name' => 'required|string',
            'account_no' => 'required|string|unique:employees',
            'ssn' => 'required|string|unique:employees',
        ]);

        //Generate Staff Number
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
    
        try {
            $data = $request->only(['branch_name','branch_shortcode','nok_name','nok_phone','address','contract_type','name', 'email', 'password', 'phone_no', 'staff_no', 'position', 'dob', 'bank_name', 'account_no', 'ssn']);
            $data['password'] = Hash::make($data['password']);
            $data['tenant_id'] = auth()->user()->id;
            if(session('is_admin') == 1)
            {
                $data['tenant_id'] = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $data['tenant_id'] = auth()->user()->id;
            }
    
            $employee = Employee::create($data);
            
            $build_data = ['name' => $request->name, 'email' => $request->email, 'password' => $request->password, 'to_phone' => $request->phone_no, 'to_email' => $request->email];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('employee_registration', $build_data);
    
            DB::commit();
    
            return response()->json(['message' => 'Employee Added Successfully', 'id' => $employee->id]);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add employee. Please try again.'], 500);
        }
    }
    
    public function import_employee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt,xls,xlsx',
        ]);
        
        

        $file = $request->file('csv_file');
        
        $parsed_array = Excel::toArray([], $file);

        // Remove header row
        $csvData = array_splice($parsed_array[0], 1);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
    
        try {
            
            foreach ($csvData as $key => $row) {
                $name = $row[0];
                $email = $row[1]; 
                $phone_no = $row[2]; 
                $staff_no = $row[3];
                $ssn = $row[4];
                $position = $row[5];
                $dob = $row[6];
                $bank_name = $row[7];
                $branch_name = $row[8];
                $branch_shortcode = $row[9];
                $account_no = $row[10];
                $nok_name = $row[11];
                $nok_phone = $row[12];
                $address = null;
                
                if(empty($name)){
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter name for row '.($key+1)], 422);
                }
                
                if(empty($email)){
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter email for row '.($key+1)], 422);
                }else{
                    $exists = Employee::where('email',$email)->count();
                    if($exists > 0){
                        DB::rollback();
                        return response()->json(['errors' => 'A user with the email '.$email.'already exists on row '.($key+1)], 422);
                    }
                }
                
                if(empty($phone_no)){
                    
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter Phone No. for row '.($key+1)], 422);
                    
                }else{
                    $exists = Employee::where('phone_no',$phone_no)->count();
                    if($exists > 0){
                        DB::rollback();
                        return response()->json(['errors' => 'A user with the Phone No '.$phone_no.' already exists on row '.($key+1)], 422);
                    }
                }
                
                if(empty($staff_no)){
                    
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter Staff No. for row '.($key+1)], 422);
                    
                }else{
                    $exists = Employee::where('staff_no',$staff_no)->count();
                    if($exists > 0){
                        DB::rollback();
                        return response()->json(['errors' => 'A user with the Staff No '.$staff_no.' already exists on row '.($key+1)], 422);
                    }
                }
                
                if(empty($ssn)){
                    
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter SSN for row '.($key+1)], 422);
                    
                }else{
                    $exists = Employee::where('ssn',$ssn)->count();
                    if($exists > 0){
                        DB::rollback();
                        return response()->json(['errors' => 'A user with the SSN '.$ssn.' already exists on row '.($key+1)], 422);
                    }
                }
                
                if(empty($account_no)){
                    
                    DB::rollback();
                    return response()->json(['errors' => 'Please enter Account No for row '.($key+1)], 422);
                    
                }else{
                    $exists = Employee::where('account_no',$account_no)->count();
                    if($exists > 0){
                        DB::rollback();
                        return response()->json(['errors' => 'A user with the Account No '.$account_no.' already exists on row '.($key+1)], 422);
                    }
                }
                
                
                $data = ['branch_name' => $branch_name,'branch_shortcode' => $branch_shortcode,'nok_name' => $nok_name,'nok_phone' => $nok_name,
                            'address' => $address,'name' => $name, 'email' => $email, 'phone_no' => $phone_no, 'staff_no' => $staff_no, 
                            'position' => $position, 'dob' => '', 'bank_name' => $bank_name, 'account_no' => $account_no, 'ssn' => $ssn];
                $pass = substr(mt_rand(1000000, 9999999), 0, 6);
                $data['password'] = Hash::make($pass);
                $data['tenant_id'] = auth()->user()->id;
                
                $employee = Employee::create($data);
                
                $build_data = ['name' => $data['name'], 'email' => $data['email'], 'password' => $pass, 'to_phone' => $data['phone_no'], 'to_email' => $data['email']];
                
                $emaildata = \App\Models\TransactionalEmails::buildMsg('employee_registration', $build_data);
                
                
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Employees imported Successfully']);
        } catch (\Exception $e) {
            logger($e);
            // DB::rollback();
    
            return response()->json(['message' => 'Failed to add employee. Please try again.'], 500);
        }
    }
    

    public function update(Request $request,$id)
    {
        $data = $request->only(['branch_shortcode','branch_name','nok_name','nok_phone','address','contract_type','name','email','password','phone_no','staff_no','position','dob','bank_name','account_no','ssn']);
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        Employee::where('id',$id)->update($data);
        return response()->json(['message' => 'Employee Updated Successfully']);
    }


    public function employee_groups()
    {
        $data = array();
        return view('employees.employeeGroups', compact('data'));
    }

    public function store_employeesGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'min_salary'       => 'required',
            'max_salary'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        EmployeeGroup::create([
            'tenant_id' => auth()->user()->id,
            'name'       => $request->name,
            'min_salary'       => $request->min_salary,
            'max_salary'       => $request->max_salary,   
        ]);

        return response()->json(['message' => 'Employees Group Added Successfully']);
    }

    public function editEmployeeGroup($id){
        $employeeGroup = EmployeeGroup::findOrFail($id);
        return view('companies.partials.employees.edit',compact('employeeGroup'));
    }

    public function updateEmployeeGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'min_salary' => 'required',
            'max_salary' => 'required',
        ]);

        $empGroup = EmployeeGroup::findOrFail($id);

        $empGroup->name = $request->name;
        $empGroup->min_salary = $request->min_salary;
        $empGroup->max_salary = $request->max_salary;

        $empGroup->save();

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function savePayslip(Request $request){
        $form_data = $request->all();

        // update basic salary
        $basic_salary_data = ['employee_id' => $form_data['employee_id'],'type' => 'basic_salary','value' => $form_data['basic_salary']];
        EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'basic_salary'], $basic_salary_data);

        // insert allowances
        $i=0;
        if(!empty($form_data['allowance_key'])){
            foreach($form_data['allowance_key'] as $one){
                if($form_data['allowance_value'][$i] == 0){
                    
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'allowance','source_id' => $one,'value' => $form_data['allowance_value'][$i],'itemvalue' => $form_data['allowance_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'allowance','source_id' => $one], $allowance_data);
                    
                }else{
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'allowance','source_id' => $one,'value' => $form_data['allowance_value'][$i],'itemvalue' => $form_data['allowance_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'allowance','source_id' => $one], $allowance_data);
                }
                // dd($allowance_data);
                $i++;
            }
        }
        

        // insert benefits
        $i=0;
        if(!empty($form_data['benefit_key'])){
            foreach($form_data['benefit_key'] as $one){
                if($form_data['benefit_value'][$i] == 0){
                
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'benefit','source_id' => $one,'value' => $form_data['benefit_value'][$i],'itemvalue' => $form_data['benefit_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'benefit','source_id' => $one], $allowance_data);
                
                }else{
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'benefit','source_id' => $one,'value' => $form_data['benefit_value'][$i],'itemvalue' => $form_data['benefit_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'benefit','source_id' => $one], $allowance_data);
                }
                $i++;
            }
        }
        

        
        // insert statutorys
        $i=0;
        if(!empty($form_data['statutory_key'])){
            foreach($form_data['statutory_key'] as $one){
                if($form_data['statutory_value'][$i] == 0){
                    
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'statutory_ded','source_id' => $one,'value' => $form_data['statutory_value'][$i], 'itemvalue' => $form_data['statutory_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'statutory_ded','source_id' => $one], $allowance_data);
                    
                }else{
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'statutory_ded','source_id' => $one,'value' => $form_data['statutory_value'][$i], 'itemvalue' => $form_data['statutory_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'statutory_ded','source_id' => $one], $allowance_data);
                }
                $i++;
            }
        }
        

        // insert non statu
        $i=0;
        if(!empty($form_data['nonstatutory_key'])){
            foreach($form_data['nonstatutory_key'] as $one){
                if($form_data['nonstatutory_value'][$i] == 0){
                
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'nonstatutory_ded','source_id' => $one,'value' => $form_data['nonstatutory_value'][$i],'itemvalue' => $form_data['nonstatutory_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'nonstatutory_ded','source_id' => $one], $allowance_data);
                    
                }else{
                        
                    $allowance_data = ['employee_id' => $form_data['employee_id'],'type' => 'nonstatutory_ded','source_id' => $one,'value' => $form_data['nonstatutory_value'][$i],'itemvalue' => $form_data['nonstatutory_itemvalue'][$i]];
                    EmployeePayslip::updateOrCreate(['employee_id' => $form_data['employee_id'],'type' => 'nonstatutory_ded','source_id' => $one], $allowance_data);
                }
                $i++;
            }
        }
        

        return redirect('employees');
    }


    public function generatePayslip($id)
    {
        $action = url('employees/savepayslip');   
        $flash_mesage = '<strong>Note!</strong> Amounts are calculated by adding the values set from <b><a href="'.url('company/settings').'">Settings/Company Settings</a></b> page.
        Updating the values in this page will only save for this specific employee.';

        $employee = Employee::findOrFail($id);
        $basic_salary = EmployeePayslip::where('employee_id',$id)->where('type','basic_salary')->first();
        $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('employees.generatePayslip',compact('flash_mesage','action','basic_salary','employee','allowance','benefit','non_statutoryded','statutoryDed'));
    }

    public function generateInitialPayslip($id)
    {
        $action = url('employees/savepayslip');   
        $flash_mesage = "Please add Payslip details for this employee.";      
        $employee = Employee::findOrFail($id);
        $basic_salary = EmployeePayslip::where('employee_id',$id)->where('type','basic_salary')->first();
        $basic_salary = !empty($basic_salary) ? $basic_salary->value : 0;
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $allowance = Allowance::where('tenant_id',$tenant_id)->get();
        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();
        $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('employees.generatePayslip',compact('flash_mesage','action','basic_salary','employee','allowance','benefit','non_statutoryded','statutoryDed'));
    }

    public function assignPermission($id)
    {
        $employee = Employee::findOrFail($id);
        
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
         
        $permissions = [];
        $perms = EmployeeAssignedPermission::where('employee_id',$id)->join('employee_permissions','employee_permissions.id','employee_assigned_permissions.permission_id')
                                        ->select('employee_permissions.name')->get();
        foreach($perms as $one){
            $permissions[] = $one->name;
        }
        return view('employees.assign_permissions', compact('employee', 'permissions'));
    }

    public function post_assign_permissions(Request $request, $id)
    {
        $data = $request->except('_token');
    
        try {
            DB::beginTransaction();
    
            $permissions = [];
            Employee::where('id',$id)->update(['is_admin_configured'=> 0]);
            EmployeeAssignedPermission::where('employee_id',$id)->delete();
            
            $to_update = 0;
            foreach($data as $key => $one){
                $perm = EmployeePermission::where('name',str_replace('_','.',$key))->first();
                if(!empty($perm)){
                    $to_update = 1;
                    EmployeeAssignedPermission::create(['employee_id' => $id, 'permission_id' => $perm->id]);
                }
            }
            
            if($to_update == 1){
                Employee::where('id',$id)->update(['is_admin_configured'=> 1]);
            }
            


            DB::commit();
    
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }
    

    public function delete_employeesGroup($id)
    {
        DB::beginTransaction();
        try {
        $empGroup = EmployeeGroup::findOrFail($id);
        $empGroup->delete();

        DB::commit();
            return response()->json(['message' => 'Employees Group Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        } 
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
        $empGroup = Employee::findOrFail($id);
        $empGroup->delete();

        DB::commit();
            return response()->json(['message' => 'Employees Group Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }      
    }

}
