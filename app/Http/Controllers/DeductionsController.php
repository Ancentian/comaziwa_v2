<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Models\DeductionType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DeductionsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            
            $deduction = Deduction::where('tenant_id',$tenant_id)->get();

            return DataTables::of($deduction)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('deductions/editDeduction',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('deductions/delete_deduction',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('companies.deductions.index',  compact('data'));
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

    public function store_deduction_type(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:deduction_types,name',
            'type'       => 'required',
            'amount'     => 'required',
        ]);
        logger($request);
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
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_deduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:deductions,name',
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
        ]);

        DB::commit();
        return response()->json(['message' => 'Deduction Type Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function editDeduction($id){
        $deduction = Deduction::findOrFail($id);
        return view('companies.partials.deductions.edit',compact('deduction'));
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
            'name' => 'required||unique:deduction_types,name,' . $id,
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



    public function deleteDeduction($id)
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
