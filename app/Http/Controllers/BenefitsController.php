<?php

namespace App\Http\Controllers;

use DB;
use App\Models\BenefitsInKind;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BenefitsController extends Controller
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
            $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();

            return DataTables::of($benefit)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('benefits/edit_benefitsInKind',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('benefits/delete_benefitsInKind',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('benefits.index');
    }

    public function store_BenefitsInKind(Request $request)
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
        BenefitsInKind::create([
            'tenant_id'  => $tenant_id,
            'name'       => $request->name,
            'type'       => $request->type,
            'value'      => $request->value,    
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Benefit In Kind Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit($id){
        $benefit = BenefitsInKind::findOrFail($id);
        return view('companies.partials.benefits.edit',compact('benefit'));
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
        $benefit = BenefitsInKind::findOrFail($id);
        $benefit->name = $request->name;
        $benefit->type = $request->type;
        $benefit->value = $request->value;

        $benefit->save();
        DB::commit();
        return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }    
    }

    public function delete_benefitsInKind($id)
    {
        DB::beginTransaction();
        try {
        $benefit = BenefitsInKind::findOrFail($id);
        $benefit->delete();

        DB::commit();
            return response()->json(['message' => 'Benefit In Kind Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
        
    }
}
