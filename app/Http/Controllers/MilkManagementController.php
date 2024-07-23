<?php

namespace App\Http\Controllers;

use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Farmer;
use App\Models\MilkCollection;
use App\Models\MilkSpillage;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;

class MilkManagementController extends Controller
{
    public function index()
    {
        return view('companies.milk_management.index');
    }

    public function spillages()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.milk_management.spillages.index', compact('centers'));
    }

    public function milk_analysis()
    {
        
    }

    public function milk_spillages()
    {
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $spillages = MilkSpillage::leftJoin('collection_centers', 'collection_centers.id', '=', 'milk_spillages.center_id')
                    ->where('milk_spillages.tenant_id', $tenant_id)
                    ->select([
                        'milk_spillages.*',
                        'collection_centers.center_name',
                    ]);

            if(!empty($start_date) && !empty($end_date)){
                $spillages->whereDate('milk_spillages.date','>=',$start_date);
                $spillages->whereDate('milk_spillages.date','<=',$end_date);
            }

            if(!empty(request()->center_id)){
                $spillages->where('milk_spillages.center_id','=',request()->center_id);
            }
            
            return DataTables::of($spillages->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('milk-management/edit-spillage',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('milk-management/delete-spillage',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                ) 
                ->editColumn('quantity', function ($row) {
                    $html = num_format($row->quantity);
                    return $html;
                }) 
                ->editColumn('responsible', function ($row) {
                    if($row->center_id != null){
                        $html = $row->center_name;
                    }else{
                        $html = "All Members";
                    }
                    return $html;
                })
                
                ->editColumn('date', function ($row) {
                    $html = format_date($row->date);
                    return $html;
                })
                ->editColumn('created_at', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->editColumn('comments', function ($row) {
                    $html = '<a class="edit-button" data-action="' . url('milk-management/view-comment', [$row->id]) . '" href="#"><button class="btn btn-success btn-sm"><i class="fa fa-eye m-r-5"></i> View</button></a>';
                    return $html;
                })                
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Sold</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                    } elseif ($row->status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Inactive</span>";
                    }
                    return $html;
                })
                ->rawColumns(['action', 'date', 'created_at', 'status', 'comments'])
                ->make(true);
        }
    }

    public function store_spillages(Request $request)
    {
        $request->merge(['is_cooperative' => $request->has('is_cooperative') ? 1 : 0]);
        $validator = Validator::make($request->all(), [
            'center_id' => '',
            'is_cooperative' => '',
            'quantity' => 'required',
            'date' => 'required',
            'comments' => '',
        ], [
            'center_id.required_without' => 'The Collection Center field is required when Is cooperative is not present.',
            'is_cooperative.required_without' => 'The Is cooperative field is required when Collection Center is not present.',
            'center_id.required_with' => 'The Collection Center field must be empty when Is cooperative is present.',
            'is_cooperative.required_with' => 'The Is cooperative field must be empty when Collection Center is present.',
        ]);
        logger($request->all());
        $validator->after(function ($validator) use ($request) {
            if (empty($request->center_id) && empty($request->is_cooperative)) {
                $validator->errors()->add('center_id', 'Either Collection Center or Is cooperative must be present.');
                $validator->errors()->add('is_cooperative', 'Either Collection Center or Is cooperative must be present.');
            }
        
            if (!empty($request->center_id) && !empty($request->is_cooperative)) {
                $validator->errors()->add('center_id', 'Both Collection Center and Is cooperative cannot have values at the same time.');
                $validator->errors()->add('is_cooperative', 'Both Collection Center and Is cooperative cannot have values at the same time.');
            }
        });

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
        $user_id = auth()->user()->id;

        MilkSpillage::create([
            'tenant_id'  => $tenant_id,
            'user_id'    => $user_id,
            'is_cooperative'  => $request->is_cooperative,
            'center_id'  => $request->center_id,
            'quantity'  => $request->quantity,
            'date'       => $request->date,
            'comments'   => $request->comments,
        ]);

        DB::commit();
        return response()->json(['message' => 'Milk Spillage Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function view_comments($id)
    {
        $tenant_id = auth()->user()->id;
        $comment = MilkSpillage::where('id', $id)
                ->where('tenant_id', $tenant_id)
                ->pluck('comments')
                ->first();
        return view('companies.milk_management.spillages.view-comment', compact('comment'));
    }

    public function edit_spillage($id)
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $spill = MilkSpillage::findorFail($id);
        return view('companies.milk_management.spillages.edit', compact('spill', 'centers'));
    }

    public function update_spillage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'quantity' => 'required',
            'comments' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $spill = MilkSpillage::findOrFail($id);
            $spill->date = $request->date;
            $spill->quantity = $request->quantity;
            $spill->comments = $request->comments;
            $spill->save();

            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_spillage($id)
    {
        DB::beginTransaction();
        try {
        $spillage = MilkSpillage::findOrFail($id);
        $spillage->delete();

        DB::commit();
            return response()->json(['message' => 'Spillage Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Spillage. Please try again.'], 500);
        }
    }
}
