<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Package;
use DB;
use Hash;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Models\CompanyProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Agent;
use App\Models\AgentPayment;
use App\Models\Subscription;

class SuperAdminUsersController extends Controller
{
    public function index(){
        $packages = Package::all();
        if (request()->ajax()) {

            //$users = User::all();
            $users = User::leftJoin('company_profiles', 'company_profiles.tenant_id', '=', 'users.id')
                    ->leftJoin('roles','roles.id','users.role_id')
                    ->where('type','!=', 'client')
                    ->leftJoin('packages', 'packages.id', '=', 'users.package_id')
            ->select([
                'company_profiles.name as companyName',
                'packages.name as packageName',
                'users.*',
                'roles.name as type',
                DB::raw('(SELECT COUNT(*) FROM users WHERE users.type = "client") as clientCount')
                ])
                ->get();
            

            return DataTables::of($users)
            ->addColumn(
                'action',
                function ($row) {

                    if($row->is_system == 1){
                        $html = "<span class='badge btn-danger'>Super Admin</span>";
                    }elseif(auth()->user()->id == $row->id){
                        $html = "<span class='badge btn-danger'>You</span>";
                    }else{
                        $html = '<div class="btn-group">
                            <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Action</button>
                            <div class="dropdown-menu dropdown-menu-right">';

                            if(usercan('edit.system.admin')){
                                $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-admin',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                            }

                            if(usercan('edit.system.admin')){
                                $html .= '<a class="dropdown-item delete-button" data-action="'.url('superadmin/delete-admin',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                            }
                            $html .= '</div>
                        </div>';
                    }

                    

                  return $html;
                }
            )
            ->editColumn(
                'type',
                function ($row) {

                    if($row->is_system == 1){
                        $html = "<span class='badge btn-danger'>Super Admin</span>";
                    }else{
                        $html = $row->type;
                    }                  

                  return $html;
                }
            )
            ->rawColumns(['action','type'])
            ->make(true);
        }
        $roles = Role::all();
        return view('superadmin.users.index', compact('packages','roles'));
    }

    public function roles(){
        if (request()->ajax()) {

            //$users = User::all();
            $users = Role::all();
            
            return DataTables::of($users)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';

                    if(usercan('assign.role')){
                        $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-role',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item edit-button" data-action="'.url('superadmin/assign-permissions',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Permissions</a>
                        <a class="dropdown-item delete-button" data-action="'.url('superadmin/delete-role',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                      
                    $html .= '</div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('superadmin.roles.roles');
    }

    public function clients(){
        $packages = Package::all();
        if (request()->ajax()) {

            //$users = User::all();
            $users = User::leftJoin('company_profiles', 'company_profiles.tenant_id', '=', 'users.id')
                    ->where('type','!=', 'superadmin')
                    ->leftJoin('packages', 'packages.id', '=', 'users.package_id')
            ->select([
                'company_profiles.name as companyName',
                'packages.name as packageName',
                'users.*',
                DB::raw('(SELECT COUNT(*) FROM employees WHERE employees.tenant_id = users.id) as employeeCount')
                ])
                ->get();
            

            return DataTables::of($users)
            ->editColumn('expiry_date', function ($row) {
                $html = format_date($row->expiry_date);
                return $html;
            })
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
                        if(usercan('assign.agent')){
                            $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/assign-agent',[$row->id]).'" href="#" ><i class="fa fa-user m-r-5"></i> Assign Agent</a>';
                        }
                        if(usercan('edit.client')){
                            $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-client',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit Client</a>';
                        }

                        if(usercan('extend.expiry.dates')){
                            $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/extend-date',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Extend Expiry Dates</a>';
                        }

                        if(usercan('edit.user.package')){
                            $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-user-package',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit User Package</a>';
                        }

                        if(usercan('delete.client')){
                            $html .= '<a class="dropdown-item delete-button" data-action="'.url('superadmin/delete-client',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete Client</a>';
                        }
                        $html .= '
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('superadmin.users.clients', compact('packages'));
    }

    public function agents()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $agent = Agent::all();

            return DataTables::of($agent)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';

                    if(usercan('assign.agents')){
                        $html .= '<a class="dropdown-item edit-button" data-action="'.url('superadmin/add-payment',[$row->id]).'" href="#" ><i class="fa fa-dollar m-r-5"></i> Pay</a>
                        <a class="dropdown-item edit-button" data-action="'.url('superadmin/assigned-users',[$row->id]).'" href="#" ><i class="fa fa-users m-r-5"></i> Assigned Users</a>
                        <a class="dropdown-item" href="'.url('superadmin/agent-payments',[$row->id]).'" ><i class="fa fa-money m-r-5"></i> Payments</a>
                        <a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-agent',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('superadmin/delete-agent',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                    }
                    $html .= '    
                    </div>
                  </div>';

                  return $html;
                }
            )

            
            ->editColumn(
                'total_income', 
                function ($row) {
                    $html = num_format(Agent::calculateIncome($row->id));
                    return $html;
                })
            ->editColumn(
                'total_commission', 
                function ($row) {
                    $html = num_format(Agent::calculatecommission($row->id));
                    
                    return $html;
                })
            ->editColumn(
                'total_paid', 
                function ($row) {
                    $html = num_format(Agent::calculatePaid($row->id));                    
                    return $html;
                })
            ->editColumn(
                'balance', 
                function ($row) {
                    $html = num_format(Agent::calculateBalance($row->id));
                    return $html;
                })
            ->rawColumns(['action','total_income', 'total_commission', 'total_paid', 'balance'])
            ->make(true);
        }
        return view('superadmin.users.agents');
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'phone_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'package_id' => 'required|string',
            // 'expiry_date' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();

        $expiry = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
    
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'type' => $request->type,
                'package_id' => $request->package_id,
                'expiry_date' => $expiry
            ]);


            $data = [
                'tenant_id' => $user->id,
                'name' => $request->company_name,
                'ssni_est' => $request->company_ssni_est,
                'tin' => $request->company_tin,
                'address' => $request->company_address,
                'email' => $request->company_email,
                'secondary_email' => $request->secondary_email,
                'tel_no' => $request->company_tel_no,
                'land_line' => $request->company_land_line
            ];

            if ($request->logo) {
                $logo = rand() . '.' . $request->logo->extension();
                $moved = $request->logo->move(storage_path('app/public/logos/'), $logo);
                $data['logo'] = $logo;
            } else {
                $data['logo'] = "";
            }

            CompanyProfile::create($data);
            
            $build_data = ['name' => $user['name'], 'email' => $user['email'], 'password' => $request['password'], 'to_phone' => $user['phone_number'], 'to_email' => $user['email']];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('new_signup', $build_data);
    
            DB::commit();
            return response()->json(['message' => 'User Added Successfully', 'id' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add user. Please try again.'], 500);
        }
    }

    public function storeAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'phone_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();

        //$expiry = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
    
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'type' => $request->type,
                'role_id' => $request->role_id
            ]);
    
            DB::commit();
            return response()->json(['message' => 'User Added Successfully', 'id' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add user. Please try again.'], 500);
        }
    }

    public function storeAgent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_no' => 'required|string|max:255',
            'address' =>  'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
    
        try {
            $agent = Agent::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'address' => $request->address,
            ]);
    
            DB::commit();
            return response()->json(['message' => 'Agent Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add user. Please try again.'], 500);
        }
    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();

        //$expiry = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
    
        try {
            $user = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
    
            DB::commit();
            return response()->json(['message' => 'Role Added Successfully', 'id' => $user->id]);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add role. Please try again.'], 500);
        }
    }

    public function extend_expiry_date($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.users.extend_date', compact('user'));
    }

    public function assign_permissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name')->toArray();     
        
        return view('superadmin.roles.assign_permissions', compact('role','permissions'));
    }

    public function extend_userDates(Request $request, $id)
    {
        $request->validate([
            'expiry_date'    => 'required',
        ]);

        DB::beginTransaction();
        try {

        $user = User::findOrFail($id);
        $user->expiry_date = $request->expiry_date;
        $user->save();

        DB::commit();
        return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_userPackage($id)
    {
        $user = User::findOrFail($id);
        $packages = Package::all();
        return view('superadmin.users.edit_user_package', compact('user', 'packages'));
    }

    public function edit_client($id)
    {
        $client = User::findOrFail($id);
        $company = CompanyProfile::where('tenant_id',$id)->first();
        $packages = Package::all();
        return view('superadmin.users.edit_client', compact('client', 'packages','company'));
    }

    public function edit_admin($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $packages = Package::all();
        return view('superadmin.users.edit_admin', compact('user', 'packages','roles'));
    }

    public function edit_role($id)
    {
        $role = Role::findOrFail($id);
        return view('superadmin.roles.edit_role', compact('role'));
    }

    public function edit_agent($id)
    {
        $agent = Agent::findOrFail($id);
        return view('superadmin.users.edit_agent', compact('agent'));
    }

    public function add_payment($id)
    {
        $agent = Agent::findOrFail($id);
        return view('superadmin.users.add_payment', compact('agent'));
    }

    public function edit_payment($id)
    {
        $payment = AgentPayment::findOrFail($id);
        return view('superadmin.users.edit_payment', compact('payment'));
    }

    public function assign_agent($id)
    {
        $agents = Agent::all();
        $user = User::findorFail($id);
        return view('superadmin.users.assign_agent', compact('agents', 'user'));
    }

    public function assigned_users($id)
    {
        $users = User::where('agent_id', $id)->get();
        return view('superadmin.users.assigned_users', compact('users'));
    }

    public function update_userPackage(Request $request, $id)
    {
        $request->validate([
            'package_id'    => 'required',
        ]);

        DB::beginTransaction();
        try {

        $user = User::findOrFail($id);
        $user->package_id = $request->package_id;
        $user->save();

        DB::commit();
        return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_client(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password',
            'package_id' => 'required',
        ]);
    
        try {
            DB::beginTransaction();
    
            $user = User::findOrFail($id);
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
    
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
    
            $user->package_id = $request->package_id;
            $user->save();


            $data = [
                'tenant_id' => $user->id,
                'name' => $request->company_name,
                'ssni_est' => $request->company_ssni_est,
                'tin' => $request->company_tin,
                'address' => $request->company_address,
                'email' => $request->company_email,
                'secondary_email' => $request->secondary_email,
                'tel_no' => $request->company_tel_no,
                'land_line' => $request->company_land_line
            ];

            if ($request->logo) {
                $logo = rand() . '.' . $request->logo->extension();
                $moved = $request->logo->move(storage_path('app/public/logos/'), $logo);
                $data['logo'] = $logo;
            } else {
                $data['logo'] = "";
            }

            $company = CompanyProfile::where('tenant_id',$id)->first();
            if (empty($company)) {
                CompanyProfile::create($data);
            } else {
                $company->update($data);
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function update_admin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password',
        ]);
    
        try {
            DB::beginTransaction();
    
            $user = User::findOrFail($id);
    
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->role_id = $request->role_id;
    
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function update_role(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
    
        try {
            DB::beginTransaction();
    
            $role = Role::findOrFail($id);
    
            $role->name = $request->name;
    
            $role->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function post_assign_permissions(Request $request, $id)
    {
        $data = $request->except('_token');
    
        try {
            DB::beginTransaction();
    
            $permissions = [];
            foreach($data as $key => $one){
                $permissions[] = str_replace('_','.',$key);
            }

            $role = Role::findOrFail($id);
            $role->syncPermissions($permissions);

            DB::commit();
    
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function update_agent(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_no' => 'required|string|max:255',
            'address' => 'string|max:255',
        ]);

    
        try {
            DB::beginTransaction();
    
            $agent = Agent::findOrFail($id);
    
            $agent->name = $request->name;
            $agent->email = $request->email;
            $agent->phone_no = $request->phone_no;
            $agent->address = $request->address;
    
            $agent->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Agent Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function update_payment(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|string',
            'amount' => 'required|string|max:255',
        ]);
    
        try {
            DB::beginTransaction();
    
            $payment = AgentPayment::findOrFail($id);
    
            $payment->date = $request->date;
            $payment->amount = $request->amount;
    
            $payment->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Payment Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'An error occurred while updating the data'], 500);
        }
    }

    public function store_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|string',
            'date' => 'required|string',
            'amount' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();

        //$expiry = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
    
        try {
            $payment = AgentPayment::create([
                'agent_id' => $request->agent_id,
                'date' => $request->date,
                'amount' => $request->amount,
            ]);
    
            DB::commit();
            return response()->json(['message' => 'Payment Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to add user. Please try again.'], 500);
        }
    }

    
    public function agent_payments($id)
    {    
        
        if (request()->ajax()) {
            $payments = AgentPayment::where('agent_id', $id)->get();
    
            return DataTables::of($payments)
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item edit-button" data-action="'.url('superadmin/edit-payment', [$row->id]).'" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                          <a class="dropdown-item delete-button" data-action="'.url('superadmin/delete-payment', [$row->id]).'" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                      </div>';
    
                    return $html;
                })
                ->editColumn('amount', function ($row) {
                    $html = num_format($row->amount);
                    return $html;
                })
                ->editColumn('date', function ($row) {
                    $html = format_date($row->date);
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('superadmin.users.agent_payments');
    }
    

    public function update_userAgent(Request $request, $id)
    {
        $request->validate([
            'agent_id'    => 'required',
        ]);

        DB::beginTransaction();
        try {

        $user = User::findOrFail($id);
        $user->agent_id = $request->agent_id;
        $user->save();

        DB::commit();
        return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_client($id)
    {
        DB::beginTransaction();
        try {
        $user = User::findOrFail($id);
        $user->delete();

        DB::commit();
            return response()->json(['message' => 'Client Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_role($id)
    {
        DB::beginTransaction();
        try {
        $role = Role::findOrFail($id);
        $role->delete();

        DB::commit();
            return response()->json(['message' => 'Client Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_admin($id)
    {
        DB::beginTransaction();
        try {
        $user = User::findOrFail($id);
        $user->delete();

        DB::commit();
            return response()->json(['message' => 'Admin Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_agent($id)
    {
        DB::beginTransaction();
        try {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        DB::commit();
            return response()->json(['message' => 'Agent Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_payment($id)
    {
        DB::beginTransaction();
        try {
        $payment = AgentPayment::findOrFail($id);
        $payment->delete();

        DB::commit();
            return response()->json(['message' => 'Payment Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }
    
}
