<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Package;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StatutoryDeduction;

class DashboardController extends Controller
{
    //
    public function index(){
        $data = array();
        $company = company()->mycompany();
        if(empty($company)){
            return redirect('company/profile');
        }
        
        // create SSF if not existing
        StatutoryDeduction::updateOrCreate(['tenant_id' => auth()->user()->id,'name' => 'SSF - Employee'],['tenant_id' => auth()->user()->id,'name' => 'SSF - Employee','type' => 'percentage','value' => 5.50]);
        return view('dashboard.index', compact('data'));
    }

    public function tryPlan($plan_id){
        
        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->package_id = $plan_id;
            $user->expiry_date = date('Y-m-d',(time()+env('TRIAL_PERIOD')*86400));
            $user->save();

            return response()->json(['message' => 'Success']);
        } catch (\Exception $e) {
            
            return response()->json(['message' => 'Failed.Please try again.'], 500);
        }
    }

    public function confirmPayment($ref,$plan){
                
        try {
            
            $curl = curl_init();  
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/verify/$ref",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".env('PAYSTACK_SECRET'),
                "Cache-Control: no-cache",
                ),
            ));
            
            $response = curl_exec($curl);
            
            $err = curl_error($curl);

            curl_close($curl);
            
            if ($err) {
                return response()->json(['message' => 'Failed.Please try again.'], 500);
            } else {
                $response = json_decode($response,true);
                if($response['data']['status'] == 'success'){
                    $amount = $response['data']['amount']/100;
                    
                    $user = User::findOrFail(auth()->user()->id);

                    $start = strtotime($user->expiry_date) > time() ? strtotime($user->expiry_date) : time();
                    
                    if(request()->type == 'annual'){
                        $end_date = date('Y-m-d',($start+(365*86400)));
                    }else{
                        $end_date = date('Y-m-d',($start+(30*86400)));
                    }
                    
                    

                    $user->package_id = $plan;
                    $user->expiry_date = $end_date;
                    $user->save();
                    Subscription::create(['tenant_id' => auth()->user()->id,'package_id' => $plan, 'type' => request()->type,'start_date' => date('Y-m-d H:i',$start),'end_date' => $end_date,'amount_paid' => $amount]);
                    
                    $package = Package::findOrFail($plan);
                    $build_data = ['subscription' => $package->name,'name' => $user->name, 'amount' => $amount,'date' => $end_date,'to_email' => $user->email,'to_phone' => $user->phone_no];
                    $emaildata = \App\Models\TransactionalEmails::buildMsg('subscription_paid',$build_data);
                    
                    
                    return response()->json(['message' => 'Success']);

                }else{
                    return response()->json(['message' => 'Failed.Please try again.'], 500);
                }
            }
            
        } catch (\Exception $e) {
            logger($e);
            return response()->json(['message' => 'Failed.Please try again.'], 500);
        }

    }

    public function subscriptions(){
        
        if (request()->ajax()) {
        $subscription = Subscription::join('packages', 'packages.id', '=', 'subscriptions.package_id')
                        ->join('users', 'users.id', '=', 'subscriptions.tenant_id')
                        ->where('subscriptions.tenant_id',auth()->user()->id)
                        ->select([
                            'packages.name as packageName',
                            'users.name as tenantName',
                            'subscriptions.*'
                        ])->get();

            return DataTables::of($subscription)
            ->editColumn(
                'created_at',
                function ($row) {
                    return date('d/m/Y H:i',strtotime($row->created_at));
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        $is_sub = true;
        $packages = Package::find(auth()->user()->package_id);
        return view('dashboard.subscriptions', compact('packages','is_sub'));
    }
}
