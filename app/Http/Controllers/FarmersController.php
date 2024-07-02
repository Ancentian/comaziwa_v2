<?php

namespace App\Http\Controllers;
use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class FarmersController extends Controller
{
    public function index()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $farmers = Farmer::join('collection_centers', 'collection_centers.id', '=', 'farmers.center_id')
                        ->join('banks', 'banks.id', '=', 'farmers.bank_id')
                        ->where('farmers.tenant_id', $tenant_id)
                        ->select([
                            'collection_centers.center_name',
                            'banks.bank_name',
                            'farmers.*'
                        ])->get();

            return DataTables::of($farmers)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('cooperative/edit-farmer',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('cooperative/delete-farmer',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->addColumn('fullname', function ($row) {
                    return $row->fname.' '.$row->lname;
                })
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Dormant</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                    } elseif ($row->status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Inactive</span>";
                    }
                    return $html;
                })
                ->rawColumns(['action','fullname', 'status'])
                ->make(true);
        }

        return view('companies.cooperatives.index', compact('centers', 'banks'));
    }

    protected function store_cooperativeFarmers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'mname' => '',
            'lname' => 'required|string|max:255',
            'id_number' => 'required|string|max:255|unique:farmers,id_number',
            'farmerID' => 'required|string|max:255|unique:farmers,farmerID',
            'contact1' => 'nullable|string|max:255',
            'contact2' => 'nullable|string|max:255',
            'gender' => 'required|string|max:255',
            'join_date' => 'nullable|date',
            'dob' => 'required|date',
            'center_id' => 'required|integer|exists:collection_centers,id',
            'location' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'bank_id' => 'nullable|integer|exists:banks,id',
            'bank_branch' => 'nullable|string|max:255',
            'acc_name' => 'nullable|string|max:255',
            'acc_number' => 'nullable|string|max:255',
            'mpesa_number' => 'nullable|string|max:255',
            'nok_name' => 'required|string|max:255', // Kin Name
            'nok_phone' => 'nullable|string|max:255', // Kin Phone
            'relationship' => 'nullable|string|max:255' // Kin Relationship
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
        Farmer::create([
            'tenant_id'  => $tenant_id,
            'fname'       => $request->fname,
            'mname'       => $request->mname,
            'lname'       => $request->lname,
            'id_number'       => $request->id_number,
            'farmerID'       => $request->farmerID,
            'contact1'       => $request->contact1,
            'contact2'       => $request->contact2,
            'gender'       => $request->gender,
            'join_date'       => $request->join_date,
            'dob'       => $request->dob,
            'center_id'       => $request->center_id,
            'location'       => $request->location,
            'marital_status'       => $request->marital_status,
            'status'       => $request->status,
            'education_level'       => $request->education_level,
            'bank_id'       => $request->bank_id,
            'bank_branch'       => $request->bank_branch,
            'acc_name'       => $request->acc_name,
            'acc_number'       => $request->acc_number,
            'mpesa_number'       => $request->mpesa_number,
            'nok_name'       => $request->nok_name,
            'nok_phone'       => $request->nok_phone,
            'relationship'       => $request->relationship
        ]);
        
        DB::commit();
        return response()->json(['message' => 'Farmer Added Successfully']);
        } catch (\Exception $e) {
            
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_farmer($id)
    {
        $tenant_id = auth()->user()->id;
        $farmer = Farmer::findorFail($id);
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.cooperatives.edit_farmer', compact('farmer', 'banks', 'centers'));
    }

    public function update_farmer(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'mname' => '',
            'lname' => 'required|string|max:255',
            'id_number' => 'required|string|max:255|unique:farmers,id_number',
            'farmerID' => 'required|string|max:255|unique:farmers,farmerID',
            'contact1' => 'nullable|string|max:255',
            'contact2' => 'nullable|string|max:255',
            'gender' => 'required|string|max:255',
            'join_date' => 'nullable|date',
            'dob' => 'required|date',
            'center_id' => 'required|integer|exists:collection_centers,id',
            'location' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'education_level' => 'nullable|string|max:255',
            'bank_id' => 'nullable|integer|exists:banks,id',
            'bank_branch' => 'nullable|string|max:255',
            'acc_name' => 'nullable|string|max:255',
            'acc_number' => 'nullable|string|max:255',
            'mpesa_number' => 'nullable|string|max:255',
            'nok_name' => 'required|string|max:255', // Kin Name
            'nok_phone' => 'nullable|string|max:255', // Kin Phone
            'relationship' => 'nullable|string|max:255' // Kin Relationship
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $farmer = Farmer::findOrFail($id);
            $farmer->fname       = $request->fname;
            $farmer->mname       = $request->mname;
            $farmer->lname       = $request->lname;
            $farmer->id_number       = $request->id_number;
            $farmer->farmerID       = $request->farmerID;
            $farmer->contact1       = $request->contact1;
            $farmer->contact2       = $request->contact2;
            $farmer->gender       = $request->gender;
            $farmer->join_date       = $request->join_date;
            $farmer->dob       = $request->dob;
            $farmer->center_id       = $request->center_id;
            $farmer->location       = $request->location;
            $farmer->marital_status       = $request->marital_status;
            $farmer->status       = $request->status;
            $farmer->education_level       = $request->education_level;
            $farmer->bank_id       = $request->bank_id;
            $farmer->bank_branch       = $request->bank_branch;
            $farmer->acc_name       = $request->acc_name;
            $farmer->acc_number       = $request->acc_number;
            $farmer->mpesa_number       = $request->mpesa_number;
            $farmer->nok_name       = $request->nok_name;
            $farmer->nok_phone       = $request->nok_phone;
            $farmer->relationship       = $request->relationship;
            $farmer->save();

        DB::commit();
            return response()->json(['message' => 'Farmer Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_farmer($id)
    {
        DB::beginTransaction();
        try {
        $farmer = Farmer::findOrFail($id);
        $farmer->delete();

        DB::commit();
            return response()->json(['message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }
}
