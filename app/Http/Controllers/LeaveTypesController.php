<?php

namespace App\Http\Controllers;

use DB;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LeaveTypesController extends Controller
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
            $benefit = LeaveType::where('tenant_id',$tenant_id)->get();

            return DataTables::of($benefit)
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
    
    public function show($id){
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_name'       => 'required',
            'leave_days'       => 'required'
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
        LeaveType::create([
            'tenant_id'  => $tenant_id,
            'type_name'       => $request->type_name,
            'leave_days'       => $request->leave_days
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit($id){
        $benefit = LeaveType::findOrFail($id);
        return view('companies.partials.leave_types.edit',compact('benefit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type_name' => 'required|string|min:3|max:100',
            'leave_days' => 'required'
        ]);

        DB::beginTransaction();
        try {
        $benefit = LeaveType::findOrFail($id);
        $benefit->type_name = $request->type_name;
        $benefit->leave_days = $request->leave_days;

        $benefit->save();
        DB::commit();
        return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }    
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
        $benefit = LeaveType::findOrFail($id);
        $benefit->delete();

        DB::commit();
            return response()->json(['message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
        
    }
}
