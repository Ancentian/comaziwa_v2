<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalaryType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SalariesController extends Controller
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
            $salary = SalaryType::where('tenant_id',$tenant_id)->get();

            return DataTables::of($salary)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('salaries/editSalary',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('salaries/delete_salaryType',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('salaries.index');
    }

    public function store_salaryType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        SalaryType::create([
            'tenant_id' => auth()->user()->id,
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Data saved successfully']);
    }

    public function edit($id){
        $salary = SalaryType::findOrFail($id);
        return view('companies.partials.salaries.edit',compact('salary'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
        ]);

        $salary = SalaryType::findOrFail($id);

        $salary->name = $request->name;
        $salary->save();

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function delete_salaryType($id)
    {
        $salary = SalaryType::findOrFail($id);
        $salary->delete();

        return response()->json(['message' => 'Salary Type Deleted Successfully']);
    }
}
