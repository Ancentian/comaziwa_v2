<?php

namespace App\Http\Controllers;
use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\MilkCollection;
use App\Models\ShareContribution;
use App\Models\ShareSetting;


use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Excel;

class SharesController extends Controller
{
    public function index()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.shares.index', compact('centers'));
    }

    public function all_shares()
    {
        if (request()->ajax()) {
            $tenant_id = Auth::user()->id;
            $shares = ShareContribution::join('farmers', 'farmers.id', '=', 'share_contributions.farmer_id')
                    ->leftJoin('collection_centers', 'collection_centers.id', '=', 'share_contributions.center_id')
                    ->where('share_contributions.tenant_id', $tenant_id)
                    ->select([
                        'share_contributions.*',
                        'farmers.fname', 
                        'farmers.lname', 
                        'farmers.farmerID',
                        'collection_centers.center_name',
                    ])
                    ->orderBy('share_contributions.id', 'desc')
                    ->get();

            return DataTables::of($shares)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('shares/edit-shares',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('shares/delete-shares',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('fullname', function ($row) {
                $html = $row->farmerID.' - '.$row->fname.' '.$row->lname;
                return $html;
            })
            ->editColumn('issue_date', function ($row) {
                $html = format_date($row->issue_date);
                return $html;
            })
            ->editColumn('share_value', function ($row) {
                $html = num_format($row->share_value);
                return $html;
            })
            
            ->editColumn('center_name', function ($row) {
                $html = $row->center_name;
                return $html;
            })
            ->editColumn('created_on', function ($row) {
                $html = format_date($row->created_at);
                return $html;
            })
            ->rawColumns(['action', 'fullname', 'issue_date', 'share_value', 'created_on', 'center_name'])
            ->make(true);
        }
    }

    public function shares_settings()
    {
        return view('companies.shares.shares-settings');
    }

    public function all_shares_settings()
    {
        if (request()->ajax()) {
            $tenant_id = Auth::user()->id;
            $shares = ShareSetting::where('share_settings.tenant_id', $tenant_id)->get();

            return DataTables::of($shares)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">';
            
                    if ($row->is_active == 1) {
                        $html .= '<a class="dropdown-item edit-button" data-action="'.url('shares/edit-shares-settings',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>';
                    }
            
                    $html .= '<a class="dropdown-item delete-button" data-action="'.url('shares/delete-shares-settings',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';
                  return $html;
                }
            )            
            ->editColumn('deduction_amount', function ($row) {
                $html = num_format($row->deduction_amount);
                return $html;
            })
            ->editColumn('accumulative_amount', function ($row) {
                $html = num_format($row->accumulative_amount);
                return $html;
            })
    
            ->editColumn('created_on', function ($row) {
                $html = format_date($row->created_at);
                return $html;
            })

            ->editColumn('status', function ($row) {
                $html = '';
                if ($row->is_active == "1") {
                    $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                } elseif ($row->is_active == "0") {
                    $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Inactive</span>";
                }
                return $html;
            })
            ->rawColumns(['action', 'status', 'deduction_amount', 'accumulative_amount', 'created_on'])
            ->make(true);
        }
    }

    public function store_shares(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'center_id'    => 'required',
            'farmer_id'    => 'required',
            'share_value'  => 'required',
            'issue_date'   => 'required',
            'mode_of_contribution' => 'required',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            ShareContribution::create([
                'tenant_id'  => $tenant_id,
                'center_id'  => $request->center_id,
                'farmer_id'  => $request->farmer_id,
                'share_value'  => $request->share_value,
                'issue_date'  => $request->issue_date, 
                'mode_of_contribution' => $request->mode_of_contribution,
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Shares Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_shares_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shares_name'    => 'required|unique:share_settings,shares_name',
            'shares_code'    => 'required',
            'deduction_amount' => 'required',
            'accumulative_amount' => 'required',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            ShareSetting::create([
                'tenant_id'  => $tenant_id,
                'shares_name'  => $request->shares_name,
                'shares_code'  => $request->shares_code,
                'deduction_amount'  => $request->deduction_amount,
                'accumulative_amount'  => $request->accumulative_amount,
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Settings Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_shares($id)
    {
        $share = ShareContribution::findorFail($id);
        $tenant_id = auth()->user()->id;
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.shares.edit', compact('share', 'farmers', 'centers'));
    }

    public function edit_shares_settings($id)
    {
        $setting = ShareSetting::findorFail($id);
        return view('companies.shares.edit-settings', compact('setting'));
    }

    public function update_shares(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'center_id'    => 'required',
            'farmer_id'    => 'required',
            'share_value'  => 'required',
            'issue_date'   => 'required',
            'mode_of_contribution' => 'required',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $share = ShareContribution::findOrFail($id);
            $share->center_id = $request->center_id;
            $share->farmer_id = $request->farmer_id;
            $share->share_value = $request->share_value;
            $share->issue_date = $request->issue_date; 
            $share->mode_of_contribution = $request->mode_of_contribution;
            $share->description = $request->description;
            $share->save();
        
        DB::commit();
        return response()->json(['message' => 'Shares Updated Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_shares_settings(Request $request, $id)
    {
        logger($request);
        $validator = Validator::make($request->all(), [
            'shares_name'    => 'required|unique:share_settings,shares_name,'.$id,
            'deduction_amount' => 'required',
            'accumulative_amount' => 'required',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            // Retrieve the existing setting and set its is_active to 0
            $existingSetting = ShareSetting::findOrFail($id);
            logger($existingSetting);
            $existingSetting->is_active = 0;
            $existingSetting->save();

            $shares_code = substr(mt_rand(1000000, 9999999), 0, 7);
            $tenant_id = auth()->user()->id;
            // Create a new setting record
            $newSetting = new ShareSetting();

            $newSetting->tenant_id = $tenant_id;
            $newSetting->shares_name = $request->shares_name;
            $newSetting->shares_code = $shares_code;
            $newSetting->deduction_amount = $request->deduction_amount;
            $newSetting->accumulative_amount = $request->accumulative_amount;
            $newSetting->description = $request->description;
            $newSetting->is_active = 1; // Set the new record as active
            $newSetting->save();

            DB::commit();
            return response()->json(['message' => 'Shares Updated Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_shares($id)
    {
        DB::beginTransaction();
        try {
        $share = ShareContribution::findOrFail($id);
        $share->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }

    public function delete_shares_settings($id)
    {
        DB::beginTransaction();
        try {
        $setting = ShareSetting::findOrFail($id);
        $setting->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }
}
