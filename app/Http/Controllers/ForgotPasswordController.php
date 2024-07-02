<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use App\Models\Employee;
use App\Models\CompanyProfile;
use Mail; 
use Hash;
use Illuminate\Support\Str;
use App\Mail\resetPassword;

class ForgotPasswordController extends Controller
{
    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);        

        $token = Str::random(64);
        
        // delete existing tokenz
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

            $resetLink = route('password.reset', ['token' => $token]);
            $user = User::where('email', $request->email)->first();
            $user_id = $user->id;
            $company = CompanyProfile::where('tenant_id', $user_id)->first();
          
            $data = ['name' => $user->name, 'company' => !empty($company) ? $company->name : ""];

            Mail::to($request->email)->send(new resetPassword($resetLink, $data));

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function staff_forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employees',
        ]);        

        $token = Str::random(64);

        // delete existing token
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
        
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

          $resetLink = route('staff.password.reset', ['token' => $token]);
          $employee = Employee::where('email', $request->email)->first();
          $tenant_id = $employee->tenant_id;
        $company = CompanyProfile::where('tenant_id', $tenant_id)->first();
          
          $data = ['name' => $employee->name, 'company' => !empty($company) ? $company->name : ""];

          Mail::to($request->email)->send(new resetPassword($resetLink, $data));

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function resetPasswordForm($token) 
    { 
        return view('auth.reset_password', ['token' => $token]);
    }

    public function staff_resetPasswordForm($token) 
    { 
        return view('auth.staff_reset_password', ['token' => $token]);
    }

    public function updatePasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
          $userdata = User::where('email', $request->email)->first();
            $user_id = $userdata->id;
            $company = CompanyProfile::where('tenant_id', $user_id)->first();
          
            $build_data = ['name' => $userdata->name, 'company' => !empty($company) ? $company->name : "",'to_email' => $userdata->email,'to_phone' => $userdata->phone_number];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('password_change', $build_data);
  
          return view('auth.login')->with('message', 'Your password has been changed!');
      }

      public function update_staffPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:employees',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = Employee::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
            $employee = Employee::where('email', $request->email)->first();
            $tenant_id = $employee->tenant_id;
            $company = CompanyProfile::where('tenant_id', $tenant_id)->first();
          
            $build_data = ['name' => $employee->name, 'company' => !empty($company) ? $company->name : "",'to_email' => $employee->email,'to_phone' => $employee->phone_no];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('password_change', $build_data);
  
          return view('companies.staff.employeeLogin')->with('message', 'Your password has been changed!');
      }
}


