<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use DB;

class SuperAdminSubscriptionPlansController extends Controller
{
    //
    public function index(){
        $data = array();
        $tenants = User::where('type', 'client')->get();
        $packages = Package::all();
        if (request()->ajax()) {
        $subscription = Subscription::join('packages', 'packages.id', '=', 'subscriptions.package_id')
                        ->join('users', 'users.id', '=', 'subscriptions.tenant_id')
                        ->select([
                            'packages.name as packageName',
                            'users.name as tenantName',
                            'subscriptions.*'
                        ])->get();
            return DataTables::of($subscription)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('superadmin/editSubscription',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('superadmin/delete',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('amount_paid', function ($row) {
                $html = num_format($row->amount_paid);
                return $html;
            })
            ->editColumn('end_date', function ($row) {
                $html = format_date($row->end_date);
                return $html;
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return date('d/m/Y H:i',strtotime($row->created_at));
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('superadmin.subscription_plans.index', compact('data','tenants', 'packages'));
    }

    public function editPlans(){
        $data = array();
        return view('superadmin.subscription_plans.edit', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required',
            'package_id' => 'required',
            'amount_paid' => 'required',
            'start_date'  =>  '',
            'end_date'  =>  'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

        Subscription::create([
            'tenant_id' => $request->tenant_id,
            'package_id' => $request->package_id,
            'amount_paid' => $request->amount_paid,
            'start_date'  =>  $request->start_date,
            'end_date'  =>  $request->end_date,     
        ]);
        $tenant_id = $request->tenant_id;
        $expiry_date = $request->end_date;

        $user = User::findorFail($tenant_id);
        $user->expiry_date = $expiry_date;
        $user->save();

        DB::commit();
        return response()->json(['message' => 'Subscription Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function editSubscription($id){
        $subscription = Subscription::findOrFail($id);
        return view('superadmin.subscription_plans.editSubscription',compact('subscription'));
    }

    public function updateSubscription(Request $request, $id)
    {
        $request->validate([
            'end_date' => 'required',
        ]);

        DB::beginTransaction();
        try {
        $subscription = Subscription::findOrFail($id);

        $subscription->end_date = $request->end_date;
        $subscription->save();

        DB::commit();
        return response()->json(['message' => 'Subscription Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        DB::commit();
        return response()->json(['message' => 'Subscription Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }
}
