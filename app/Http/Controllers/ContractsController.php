<?php

namespace App\Http\Controllers;

use App\Models\ContractType;
use App\Models\Contract;
use App\Models\Employee;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function index()
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $contracts = Contract::where('tenant_id', $tenant_id)->get();
        return view('employees.contracts.index', compact('employees', 'contracts'));
    }

    public function staff_contracts()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        $contracts = Contract::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.contracts.index', compact('employees', 'contracts'));
    }

    public function indexContractType()
    {
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $contracts = ContractType::where('tenant_id',$tenant_id)->get();

            return DataTables::of($contracts)
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('departments/edit',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('departments/delete',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('contracts.index');
    }

    public function storeContract(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg,xls,xlsx',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee_id = $request->employee_id;
        $employee_name = Employee::where('id', $employee_id)->first()->name;
        $name = ucfirst(str_replace(' ', '-', strtolower($employee_name)));

        $upload_file = "$name-" . '.' . $request->file->extension();
        DB::beginTransaction();
        try {
            $request->file->move(storage_path('app/public/contracts/'), $upload_file);

            Contract::create([
                'tenant_id'   => auth()->user()->id,
                'employee_id' => $employee_id,
                'file'        => $upload_file,
            ]);

            DB::commit();

            return response()->json(['message' => 'Contract saved successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to save data. Please try again.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            ContractType::create([
                'tenant_id'   => $tenant_id,
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json(['message' => 'Saved successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to save data. Please try again.'], 500);
        }
    }


    public function edit($id){
        $contract = ContractType::findOrFail($id);
        return view('companies.partials.contracts.edit',compact('contract'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:100',
        ]);

        $contract = ContractType::findOrFail($id);

        $contract->name = $request->name;
        $contract->save();

        return response()->json(['message' => 'Data updated successfully']);
    }


    public function deleteContract($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        return response()->json(['message' => 'Contract Deleted Successfully']);
    }

    public function delete($id)
    {
        $contract = ContractType::findOrFail($id);
        $contract->delete();

        return response()->json(['message' => 'Deleted Successfully']);
    }

    
}
