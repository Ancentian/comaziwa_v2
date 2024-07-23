<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CompanyProfile;
use App\Models\ContractType;
use App\Models\CollectionCenter;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CooperativeController extends Controller
{
    public function index()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $farmers = Farmer::where('tenant_id', $tenant_id)->get();

            return DataTables::of($farmers)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('leave-types/edit',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('leave-types/delete',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('companies.cooperatives.index', compact('centers', 'banks'));
    }

    public function collection_centers()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;

            $centers = CollectionCenter::where('collection_centers.tenant_id', $tenant_id)
                ->leftJoin('farmers', 'collection_centers.id', '=', 'farmers.center_id')
                ->select('collection_centers.*', DB::raw('COUNT(farmers.id) as farmer_count'))
                ->groupBy('collection_centers.id')
                ->get();

            return DataTables::of($centers)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('leave-types/edit',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('leave-types/delete',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->addColumn('farmers', function ($row) {
                    return $row->farmer_count;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function cooperative_banks()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $banks = Bank::where('tenant_id', $tenant_id)->get();
            return DataTables::of($banks)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('leave-types/edit',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('leave-types/delete',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';
                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function store_collectionCenter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'center_name'       => 'required|unique:collection_centers,center_name',
            'grader_id'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
        CollectionCenter::create([
            'tenant_id'  => $tenant_id,
            'center_name'       => $request->center_name,
            'grader_id'       => $request->grader_id,  
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Collection Center Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    // public function store_banks(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'bank_name'    => 'required|unique:banks,bank_name',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //     DB::beginTransaction();
    //     try {
    //     $tenant_id = auth()->user()->id;
    //         Bank::create([
    //             'tenant_id'  => $tenant_id,
    //             'bank_name'    => $request->bank_name, 
    //         ]);
        
    //     DB::commit();
    //     return response()->json(['message' => 'Bank Detail Added Successfully']);
    //     } catch (\Exception $e) {
    //         logger($e);
    //         DB::rollback();
    //         return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
    //     }
    // }

    public function store_banks(Request $request)
    {
        $tenant_id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'bank_name' => [
                'required',
                Rule::unique('banks')->where(function ($query) use ($tenant_id) {
                    return $query->where('tenant_id', $tenant_id);
                }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            Bank::create([
                'tenant_id' => $tenant_id,
                'bank_name' => $request->bank_name, 
            ]);
            
            DB::commit();
            return response()->json(['message' => 'Bank Detail Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

}
