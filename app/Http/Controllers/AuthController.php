<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use Flash;
use Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('price', 'asc')->where('is_hidden',0)->get();
        return view('landing_page.index', compact('packages'));
    }

    public function login(){
        $data = array();
        return view('auth.login', compact('data'));
    }

    protected function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->type == "superadmin") {
                return redirect()->intended('/superadmin/dashboard');
            } else {
                return redirect()->intended('/dashboard/index');
            }
        } else {
            //toastr()->error('Invalid credentials');
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }

    }


    public function signup(){
        $data = array();
        
        return view('auth.signup', compact('data'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'phone_number'     => 'required|string|max:255',
            'type'      => 'required|string|max:255'
        ]);
        
        logger($request);
        
        $expiry = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
        
        $free_package = Package::where('is_system','1')->first();
        
        $package_id = !empty($free_package) ? $free_package->id : 0;
        
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'type'  => $request->type,
            'package_id' => $package_id,
            'expiry_date' => $expiry,
        ]);
        
        $build_data = ['name' => $request->name, 'email' => $request->email, 'password' => $request->password, 'to_phone' => $request->phone_number, 'to_email' => $request->email];
        $emaildata = \App\Models\TransactionalEmails::buildMsg('new_signup', $build_data);
    
        
        return redirect('auth/login')->with('success', 'Registered Success');
    }

    public function pass_reset(){
        $data = array();
        return view('auth.pass_reset', compact('data'));
    }

    public function set_as_admin(Request $request){
        session([
            'is_admin' => 1, 
            'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id
        ]);
        
        return redirect('/dashboard/index');
      
    }

    public function set_as_staff(Request $request){
        session([
            'is_admin' => 0, 
            'tenant_id' => optional(auth()->guard('employee')->user())->tenant_id
        ]);
        return redirect('/staff/index');
    }

    public function logout(){
        Auth::logout();
        return redirect('/auth/login');
    }
}
