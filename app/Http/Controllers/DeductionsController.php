<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use App\Models\StatutoryDeduction;
use App\Models\NonStatutoryDeduction;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DeductionsController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
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
        return view('deductions.index',  compact('data'));
    }

    public function statutory_deductions()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $statutoryDed = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

            return DataTables::of($statutoryDed)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('deductions/edit_statutoryDeduction',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('deductions/delete_statutoryDeduction',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('deductions.statutoryDeductions',  compact('data'));
    }

    public function non_statutory_deductions()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $non_statutoryded = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();

            return DataTables::of($non_statutoryded)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('deductions/edit_nonStatutoryDeduction',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('deductions/delete_nonStatutoryDeduction',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('deductions.non_statutoryDeductions',  compact('data'));
    }

    public function storeDeduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'type'       => 'required',
            'value'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        Deduction::create([
            'tenant_id' => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,    
        ]);

        DB::commit();
        return response()->json(['message' => 'Deduction Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_statutoryDeduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'type'       => 'required',
            'value'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        StatutoryDeduction::create([
            'tenant_id' => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,    
        ]);

        DB::commit();
        return response()->json(['message' => 'Statutory Deduction Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function store_nonStatutoryDeduction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'type'       => 'required',
            'value'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        NonStatutoryDeduction::create([
            'tenant_id' => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,    
        ]);

        DB::commit();
        return response()->json(['message' => 'Non Statutory Deduction Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }

    public function editDeduction($id){
        $deduction = Deduction::findOrFail($id);
        return view('companies.partials.deductions.edit',compact('deduction'));
    }

    public function editStatutoryDed($id){
        $statutoryDed = StatutoryDeduction::findOrFail($id);
        return view('companies.partials.deductions.editStatutoryDeduction',compact('statutoryDed'));
    }

    public function edit_nonStatutoryDed($id){
        $non_statutoryded = NonStatutoryDeduction::findOrFail($id);
        // dd($non_statutoryded);
        return view('companies.partials.deductions.edit_nonStatutoryDeduction',compact('non_statutoryded'));
    }
    
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'type' => 'required',
            'value' => 'required',
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
    

    //Update Statutory deduction
    public function update_statutoryDeduction(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required',
            'value' => 'required',
        ]);

        DB::beginTransaction();
        try {
        $statutory = StatutoryDeduction::findOrFail($id);
        $statutory->name = $request->name;
        $statutory->type = $request->type;
        $statutory->value = $request->value;
        $statutory->save();

        DB::commit();
        return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update data. Please try again.'], 500);
        }

    }

    //Update Non Statutory
    public function update_nonStatutoryDeduction(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required',
            'value' => 'required',
        ]);

        DB::beginTransaction();
        try {
        $non_statutory = NonStatutoryDeduction::findOrFail($id);
        $non_statutory->name = $request->name;
        $non_statutory->type = $request->type;
        $non_statutory->value = $request->value;

        $non_statutory->save();

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


    public function delete_statutoryDeduction($id)
    {
        DB::beginTransaction();
        try {
        $statutory = StatutoryDeduction::findOrFail($id);
        $statutory->delete();

        DB::commit();
            return response()->json(['message' => 'Statutory Deduction Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete deduction. Please try again.'], 500);
        }

    }

    public function delete_nonStatutoryDeduction($id)
    {
        DB::beginTransaction();
        try {

        $nonStatutory = NonStatutoryDeduction::findOrFail($id);
        $nonStatutory->delete();
        
        DB::commit();
            return response()->json(['message' => 'Non Statutory Deduction Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete deduction. Please try again.'], 500);
        }
    }
}
