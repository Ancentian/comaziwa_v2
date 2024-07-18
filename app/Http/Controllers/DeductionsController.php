<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Models\DeductionType;
use App\Models\Farmer;
use App\Models\CollectionCenter;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeductionsController extends Controller
{
    public function index()
    {
        $tenant_id = Auth::user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = Auth::user()->id;
            $deduction = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
                    ->leftJoin('farmers', 'farmers.id', '=', 'deductions.farmer_id')
                    ->leftJoin('collection_centers', 'collection_centers.id', '=', 'deductions.center_id')
                    ->where('deductions.tenant_id', $tenant_id)
                    ->select([
                        'deductions.*',
                        'farmers.fname', 
                        'farmers.lname', 
                        'farmers.farmerID',
                        'collection_centers.center_name',
                        'deduction_types.name as deduction_name'
                    ]);

                if(!empty($start_date) && !empty($end_date)){
                    $deduction->whereDate('deductions.date','>=',$start_date);
                    $deduction->whereDate('deductions.date','<=',$end_date);
                }
    
                if(!empty(request()->center_id)){
                    $deduction->where('deductions.center_id','=',request()->center_id);
                }
    
                if(!empty(request()->farmer_id)){
                    $deduction->where('deductions.farmer_id','=',request()->farmer_id);
                }

            return DataTables::of($deduction->get())
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('deductions/edit-deduction',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('deductions/delete-deduction',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('fullname', function ($row) {
                if ($row->farmer_id == '') {	
                    $html = "All Farmers";
                }else{
                    $html = $row->farmerID.' - '.$row->fname.' '.$row->lname;
                }
                return $html;
            })
            ->editColumn('date', function ($row) {
                $html = format_date($row->date);
                return $html;
            })
            ->editColumn('amount', function ($row) {
                $html = num_format($row->amount);
                return $html;
            })
            
            ->editColumn('center_name', function ($row) {
                if ($row->center_id == null) {	
                    $html = "All Centers";
                }else{
                    $html = $row->center_name;
                }
                return $html;
            })
            ->editColumn('created_on', function ($row) {
                $html = format_date($row->created_at);
                return $html;
            })
            ->rawColumns(['action', 'fullname', 'date', 'amount', 'created_on', 'center_name'])
            ->make(true);
        }
        return view('companies.deductions.index', compact('centers'));
    }

    public function deduction_types()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $type = DeductionType::where('tenant_id',$tenant_id)->get();

            return DataTables::of($type)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('deductions/edit-deduction-type',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('deductions/delete-deduction-type',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->addColumn('type', function ($row) {
                if($row->type == 'individual'){
                    return 'Individual';
                }else{
                    return 'General';
                }
            })
            ->editColumn('amount', function ($row) {
                return num_format($row->amount);
            })
            ->rawColumns(['action', 'type', 'amount'])
            ->make(true);
        }
        return view('companies.deductions.deduction_types');
    }

    public function add_deduction()
    {
        $tenant_id = auth()->user()->id;
        $individual_deductions = DeductionType::where('tenant_id', $tenant_id)->where('type', 'individual')->get();
        $general_deductions = DeductionType::where('tenant_id', $tenant_id)->where('type', 'general')->get();
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        return view('companies.deductions.add-deduction', compact('individual_deductions', 'general_deductions', 'centers', 'farmers'));
    }

    public function getFarmersByCenter($centerId)
    {
        $center = CollectionCenter::findorFail($centerId);
        $tenant_id = $center->tenant_id;
        $farmers = Farmer::where('center_id', $centerId)
                        ->where('tenant_id', $tenant_id)
                        ->get();
        return response()->json($farmers);
    }

    public function getFarmerDetails($farmerId)
    {
        $farmer = Farmer::findorFail($farmerId);
        return response()->json($farmer);
    }

    public function getProductsByCategory($categoryId)
    {
        $category = Category::findorFail($categoryId);
        $tenant_id = $category->tenant_id;
        $products = Inventory::where('category_id', $categoryId)
                        ->where('tenant_id', $tenant_id)
                        ->get();
        return response()->json($products);
    }

    public function getdeductiondetails($dedId)
    {
        $deduction = DeductionType::findorFail($dedId);
        return response()->json($deduction);
    }

    public function store_deduction_type(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:deduction_types,name',
            'type'       => 'required',
            'amount'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
        DeductionType::create([
            'tenant_id' => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type,
            'amount'     => $request->amount,    
        ]);

        DB::commit();
        return response()->json(['message' => 'Deduction Type Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_deduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farmer_id'  => 'required',
            'deduction_id'  => 'required',
            'center_id'  => 'required',
            'deduction_type'  => 'required',
            'amount'     => 'required',
            'date'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
        $user_id = auth()->user()->id;
        foreach($request->deduction_id as $key => $ded)
        {
            $deduction['tenant_id'] = $tenant_id;
            $deduction['farmer_id'] = $request->farmer_id;
            $deduction['center_id'] = $request->center_id;	
            $deduction['deduction_id'] = $ded;
            $deduction['deduction_type'] = $request->deduction_type;
            $deduction['amount'] = $request->amount[$key];
            $deduction['date'] = $request->date;
            $deduction['user_id'] = $user_id;
            //$deduction['user_role'] = $request->user_role;
            Deduction::create($deduction);
        }

        DB::commit();
        return response()->json(['message' => 'Deduction Added Successfully']);
        return redirect()->route('deductions.index');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    // public function store_general_deduction(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'farmer_id'  => '',
    //         'deduction_id'  => 'required',
    //         'center_id'  => '',
    //         'deduction_type'  => 'required',
    //         'amount'     => 'required',
    //         'date'       => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }
    //     logger($request->all());
    //     DB::beginTransaction();
    //     try {
    //     $tenant_id = auth()->user()->id;
    //     $user_id = auth()->user()->id;
        
    //     foreach($request->deduction_id as $key => $ded) {
    //         if ($request->check_box[$key] == 1) {
    //             $deduction['tenant_id'] = $tenant_id;
    //             $deduction['farmer_id'] = $request->farmer_id;
    //             $deduction['center_id'] = $request->center_id;	
    //             $deduction['deduction_id'] = $ded;
    //             $deduction['deduction_type'] = $request->deduction_type;
    //             $deduction['amount'] = $request->amount[$key];
    //             $deduction['date'] = $request->date;
    //             $deduction['user_id'] = $user_id;
    //             //$deduction['user_role'] = $request->user_role;
    //             Deduction::create($deduction);
    //         }
    //     }

    //     DB::commit();
    //     return response()->json(['message' => 'Deduction Added Successfully']);
    //     } catch (\Exception $e) {
    //         logger($e);
    //         DB::rollback();
    //         return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
    //     }
    // }
    public function store_general_deduction(Request $request)
{
    $validator = Validator::make($request->all(), [
        'farmer_id'  => '',
        'deduction_id'  => 'required',
        'center_id'  => '',
        'deduction_type'  => 'required',
        'amount'     => 'required',
        'date'       => 'required',
    ]);

    // Custom validation to ensure at least one checkbox is checked
    $validator->after(function ($validator) use ($request) {
        if (!isset($request->check_box_value) || !in_array('1', $request->check_box_value)) {
            $validator->errors()->add('check_box_value', 'At least one deduction must be selected.');
        }
    });

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    logger($request->all());
    DB::beginTransaction();
    try {
        $tenant_id = auth()->user()->id;
        $user_id = auth()->user()->id;

        foreach ($request->deduction_id as $key => $ded) {
            if ($request->check_box_value[$key] == '1') {
                $deduction = [
                    'tenant_id' => $tenant_id,
                    'farmer_id' => $request->farmer_id,
                    'center_id' => $request->center_id,
                    'deduction_id' => $ded,
                    'deduction_type' => $request->deduction_type,
                    'amount' => $request->amount[$key],
                    'date' => $request->date,
                    'user_id' => $user_id,
                ];
                Deduction::create($deduction);
            }
        }

        DB::commit();
        return response()->json(['message' => 'Deduction Added Successfully']);
    } catch (\Exception $e) {
        logger($e);
        DB::rollback();
        return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
    }
}



    public function edit_deduction($id){
        $deduction = Deduction::findOrFail($id);
        return view('companies.deductions.edit-deduction',compact('deduction'));
    } 
    
    public function edit_deduction_type($id){
        $deduction = DeductionType::findOrFail($id);
        return view('companies.deductions.edit_type',compact('deduction'));
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'type' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
        try {
            $deduction = Deduction::findOrFail($id);
            $deduction->name = $request->name;
            $deduction->type = $request->type;
            $deduction->value = $request->value;
            $deduction->save();
    
            DB::commit();
            return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
    
            return response()->json(['message' => 'Failed to update data. Please try again.'], 500);
        }
    }

    public function update_deduction_type(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:deduction_types,name,' . $id,
            'type' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $deduction = DeductionType::findOrFail($id);
            $deduction->name = $request->name;
            $deduction->type = $request->type;
            $deduction->amount = $request->amount;
            $deduction->save();

            DB::commit();
            return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update data. Please try again.'], 500);
        }
    }

    public function delete_deduction($id)
    {
        DB::beginTransaction();
        try {
            $deduction = Deduction::findOrFail($id);
            $deduction->delete();

            DB::commit();
            return response()->json(['message' => 'Deduction Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete deduction. Please try again.'], 500);
        }
    }

    public function delete_deduction_type($id)
    {
        DB::beginTransaction();
        try {
            $deduction = DeductionType::findOrFail($id);
            $deduction->delete();

            DB::commit();
            return response()->json(['message' => 'Deduction Type Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete deduction. Please try again.'], 500);
        }
    }

}
