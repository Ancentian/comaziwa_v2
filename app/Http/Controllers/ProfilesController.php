<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\CompanyProfile;
use Hash;
use DB;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
{
    public function myProfile()
    {
        if(session('is_admin') == 1)
        {
            $user_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $user_id = auth()->user()->id;
        }
        $user = User::findorFail($user_id);
        return view('companies.profiles.index', compact('user'));
    }

    public function staffProfile()
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $employee = Employee::findorFail($employee_id);
        return view('companies.staff.profiles.index', compact('employee'));
    }

    public function updateProfile(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $user_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $user_id = auth()->user()->id;
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user_id,
            'phone_number' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password',
        ]);        

        $user= User::findOrFail($user_id);
        $company = CompanyProfile::where('tenant_id', $user_id)->first();
        $company_name = !empty($company) ? $company->name : '';

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->save();
        
        if($request->password != ""){
            $build_data = ['name' => $request->name,  'company' => $company_name, 'email' => $request->email, 'to_phone' => $request->phone_number, 'to_email' => $request->email];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('password_change', $build_data);
        }

        return redirect()->back();
    }

    public function update_staffProfile(Request $request)
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,'.$employee_id,
            'phone_no' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable|required_with:password',
        ]);        

        $user= Employee::findOrFail($employee_id);
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $company = CompanyProfile::where('tenant_id', $tenant_id)->first();
        $company_name = !empty($company) ? $company->name : '';

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->password = Hash::make($request->password);
        $user->save();
        
        if($request->password != ""){
            $build_data = ['name' => $request->name,  'company' => $company_name, 'email' => $request->email, 'to_phone' => $request->phone_number, 'to_email' => $request->email];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('password_change', $build_data);
        }

        return redirect()->back();
    }
}
