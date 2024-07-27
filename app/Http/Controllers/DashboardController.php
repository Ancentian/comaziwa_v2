<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Package;
use App\Models\MilkCollection;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    
    public function index(){
        $data = array();
        $company = company()->mycompany();
        if(empty($company)){
            return redirect('company/profile');
        }
        return view('dashboard.index', compact('data'));
    }

    public function milk_analysis()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(4);

        $milkData = DB::table('milk_collections')
            ->select([DB::raw("MONTH(collection_date) as month"), 
                    DB::raw("SUM(morning) as total_morning"),
                    DB::raw("SUM(evening) as total_evening"),
                    DB::raw("SUM(rejected) as total_rejected"),
                    DB::raw("SUM(total) as total_milk")])
            ->whereBetween('collection_date', [$startDate, $endDate])
            ->groupBy(DB::raw("MONTH(collection_date)"))
            ->get();
        return response()->json($milkData);
    }

    //Pie Chart & Line Chart
    public function monthly_milk_analysis()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(4);

        $milkData = DB::table('milk_collections')
            ->select(DB::raw("MONTH(collection_date) as month"),
                    DB::raw("SUM(morning) as total_morning"),
                    DB::raw("SUM(evening) as total_evening"),
                    DB::raw("SUM(rejected) as total_rejected"), 
                    DB::raw("SUM(total) as total_milk"))
            ->whereBetween('collection_date', [$startDate, $endDate])
            ->groupBy(DB::raw("MONTH(collection_date)"))
            ->get();
        return response()->json($milkData);
    }

    public function collection_center_analysis()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(4);
        $tenant_id = auth()->user()->id;
        $milkData = DB::table('milk_collections')
            ->join('collection_centers', 'collection_centers.id', 'milk_collections.center_id')
            ->where('milk_collections.tenant_id', $tenant_id)
            ->select(
                DB::raw("MONTH(milk_collections.collection_date) as month"),
                DB::raw("SUM(milk_collections.total) as total_milk"),
                DB::raw("collection_centers.center_name")
            )
            ->whereBetween('milk_collections.collection_date', [$startDate, $endDate])
            ->groupBy(DB::raw("MONTH(milk_collections.collection_date)"), 'collection_centers.center_name')
            ->get();
        return response()->json($milkData);
    }

    public function monthly_sales_analysis()
{
    $endDate = Carbon::now();
    $startDate = $endDate->copy()->subMonths(4);
    $start = $startDate->format('Y-m-d');
    $end = $endDate->format('Y-m-d');

    $tenant_id = auth()->user()->id;

    // Ensure proper joining of tables and grouping by month
    $milkData = DB::table('payments')
        ->where('payments.tenant_id', $tenant_id)
        ->whereBetween('payments.pay_period', [$start, $end])
        ->select(
            DB::raw("DATE_FORMAT(payments.pay_period, '%Y-%m') as month"),
            DB::raw("SUM(payments.gross_pay) as total_gross")
        )
        ->groupBy(DB::raw("DATE_FORMAT(payments.pay_period, '%Y-%m')"))
        ->orderBy(DB::raw("DATE_FORMAT(payments.pay_period, '%Y-%m')"))
        ->get();
            logger($milkData);
    return response()->json($milkData);
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

    public function center_statistics()
    {
        if (request()->ajax()) {

            $tenant_id = auth()->user()->id;
            $milk = MilkCollection::join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                    ->where('milk_collections.tenant_id', $tenant_id)
                    ->groupBy('collection_centers.center_name')
                    ->select([
                        DB::raw('SUM(milk_collections.total) as total_milk'),
                        'collection_centers.center_name',
                    ])
                    ->orderBy('total_milk', 'desc')
                    ->limit(5)
                    ->get();
                  
            return DataTables::of($milk)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<a class="btn btn-success " href="'.url('milkCollection/edit-milk-collection',[$row->id]).'" ><i class="fa fa-eye m-r-5"></i></a>';
                        return $html;
                    }
                )
                ->editColumn('total_milk', function ($row) {
                    $html = num_format($row->total_milk);
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function farmer_statistics()
    {
        if (request()->ajax()) {

            $tenant_id = auth()->user()->id;
            $farmer = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
                    ->where('milk_collections.tenant_id', $tenant_id)
                    ->groupBy('milk_collections.farmer_id')
                    ->select([
                        DB::raw('SUM(milk_collections.total) as total_milk'),
                        'farmers.fname',
                        'farmers.lname',
                        'farmers.farmerID'
                    ])
                    ->groupBy('fname', 'lname', 'farmerID')
                    ->orderBy('total_milk', 'desc')
                    ->limit(5)
                    ->get();
                    
            return DataTables::of($farmer)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<a class="btn btn-success " href="'.url('milkCollection/edit-milk-collection',[$row->id]).'" ><i class="fa fa-eye m-r-5"></i></a>';
                        return $html;
                    }
                )
                ->editColumn('fullname', function ($row) {
                    $html = $row->fname.' '.$row->lname.' '.$row->farmerID;
                    return $html;
                })
                ->editColumn('total_milk', function ($row) {
                    $html = num_format($row->total_milk);
                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
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
