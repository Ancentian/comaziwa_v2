<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\Package;
use Flash;
use Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Crons extends Controller
{
    public function checkSubscriptions()
    {
        $users = User::where('type','client')->whereDate('expiry_date' ,'>',date('Y-m-d'))->whereDate('expiry_date' ,'<=' ,date('Y-m-d',(time()+(env('ALERT_DAYS')*86400))))->get();
        
        foreach($users as $one){
            $company = CompanyProfile::where('tenant_id', $one->id)->first();
            
            $build_data = ['name' => $one->name, 'company' => $company->name,'date' => $one['expiry_date'],'to_email' => $one->email,'to_phone' => $one->phone_number];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('subscription_reminder', $build_data);
        }
    }
    
}
