<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Allowance;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AllowancesController extends Controller
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
            $allowance = Allowance::where('tenant_id',$tenant_id)->get();

            return DataTables::of($allowance)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('allowances/editAllowance',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('allowances/delete_allowance',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('allowances.index');
    }

    public function storeAllowance(Request $request)
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
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            Allowance::create([
                'tenant_id' => $tenant_id,
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
            ]);

            DB::commit();

            return response()->json(['message' => 'Data saved successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit($id){
        $allowance = Allowance::findOrFail($id);
        return view('companies.partials.allowances.edit',compact('allowance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
            'type' => 'required',
            'value' => 'required',
        ]);

        DB::beginTransaction();
        try {
            
        $allowance = Allowance::findOrFail($id);

        $allowance->name = $request->name;
        $allowance->type = $request->type;
        $allowance->value = $request->value;

        $allowance->save();

        DB::commit();
        return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
  
    }

    public function delete_allowance($id)
    {
        DB::beginTransaction();
        try {

        $allowance = Allowance::findOrFail($id);
        $allowance->delete();

        DB::commit();
        return response()->json(['message' => 'Allowance Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }
}
