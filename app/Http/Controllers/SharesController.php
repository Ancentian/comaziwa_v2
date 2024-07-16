<?php

namespace App\Http\Controllers;
use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\MilkCollection;
use App\Models\ShareContribution;


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
                    ])->get();

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

    public function edit_shares($id)
    {
        $share = ShareContribution::findorFail($id);
        $tenant_id = auth()->user()->id;
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.shares.edit', compact('share', 'farmers', 'centers'));
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
        logger($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
            $tenant_id = auth()->user()->id;
            $share = ShareContribution::findOrFail($id);
            $share->tenant_id = $tenant_id;
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
}
