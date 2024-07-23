<?php

namespace App\Http\Controllers;
use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\MilkCollection;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;


class StaffMilkController extends Controller
{
    public function index()
    {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.milk-collection.index', compact('centers', 'farmers'));;
    }

    public function all_milk_collection()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $milk = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                    ->leftJoin('employees', 'employees.id', '=', 'milk_collections.user_id')
                    ->where('milk_collections.tenant_id', $tenant_id)
                    ->select([
                        'milk_collections.*',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'employees.name as staff_name',
                    ]);

            if(!empty($start_date) && !empty($end_date)){
                $milk->whereDate('milk_collections.collection_date','>=',$start_date);
                $milk->whereDate('milk_collections.collection_date','<=',$end_date);
            }

            if(!empty(request()->center_id)){
                $milk->where('milk_collections.center_id','=',request()->center_id);
            }

            if(!empty(request()->farmer_id)){
                $milk->where('milk_collections.farmer_id','=',request()->farmer_id);
            }

            return DataTables::of($milk->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('milkCollection/edit-milk-collection',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('milkCollection/delete-milk-collection',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->addColumn('fullname', function ($row) {
                    return $row->farmerID.' - '.$row->fname.' '.$row->lname;
                })
                ->editColumn('collection_date', function ($row) {
                    $html = format_date($row->collection_date);
                    return $html;
                })
                ->editColumn('created_on', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->rawColumns(['action','fullname'])
                ->make(true);
        }
    }

    public function add_milk_collection()
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        return view('companies.staff.milk-collection.add-collection', compact('centers', 'farmers'));
    }

    public function center_farmers($id)
    {
        $data = CollectionCenter::findorFail($id);
        $tenant_id = $data->tenant_id;

        $farmers = Farmer::leftJoin('collection_centers', 'collection_centers.id', 'farmers.center_id')
                            ->where('farmers.center_id', $id)
                            ->where('collection_centers.tenant_id', $tenant_id)
                            ->select([
                                'farmers.fname',
                                'farmers.lname',
                                'farmers.id as farmer_id',
                                'farmers.center_id',
                                'farmers.farmerID as farmerCode',	
                                'collection_centers.center_name',
                                'collection_centers.tenant_id',
                            ])->get();

        $response = array('center' => $data,'parts' => $farmers);
        
        echo json_encode($response);
    }

    public function store_milkCollection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farmer_id' => 'required|array',
            'collection_date' => 'required|date',
            'morning' => 'required|array',
            'evening' => 'required|array',
            'rejected' => 'required|array',
            'total' => 'required|array',
            'center_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $milk = $request->all();
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        $farmer = $milk['farmer_id'];
        $date = $milk['collection_date'];
        $morning = $milk['morning'];
        $evening = $milk['evening'];
        $rejected = $milk['rejected'];
        $total = $milk['total'];
        $userID = optional(auth()->guard('employee')->user())->id;

        $milkCollections = [];
        foreach ($farmer as $index => $key) {
            $mrg = $morning[$index];
            $evng = $evening[$index];
            $reject = $rejected[$index];
            $tot = $total[$index];

            // Only add to the collection if the total is greater than 0
            if ($tot > 0) {
                $milkCollections[] = [
                    'tenant_id' => $tenant_id,
                    'user_id' => $userID,
                    'center_id' => $milk['center_id'],
                    'collection_date' => $date,
                    'farmer_id' => $key,
                    'morning' => $mrg,
                    'evening' => $evng,
                    'rejected' => $reject,
                    'total' => $tot,
                ];
            }
        }

        try {
            foreach ($milkCollections as $milkCollection) {
                MilkCollection::create($milkCollection);
            }

            return redirect()->back()->with('message', 'Milk Added Successfully');
        } catch (\Exception $e) {
            logger($e);
            return redirect()->back()->with('message', 'Err! Failed Try Again');
        }
    }

    public function store_import_milk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|mimes:csv,txt,xls,xlsx',
        ]);
        
        $file = $request->file('csv_file');
        
        $parsed_array = Excel::toArray([], $file);

        // Remove header row
        $csvData = array_splice($parsed_array[0], 1);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
    
        try {
            
            foreach ($csvData as $key => $row) {
                $farmer_id = $row[0];
                $center_id = $row[1]; 
                $farmer_code = $row[2]; 
                $farmer_name = $row[3];
                $morning = $row[4];
                $evening = $row[5];
                $rejected = $row[6];
                
                // if(empty($name)){
                //     DB::rollback();
                //     return response()->json(['errors' => 'Please enter name for row '.($key+1)], 422);
                // }
                
                // if(empty($phone_no)){
                    
                //     DB::rollback();
                //     return response()->json(['errors' => 'Please enter Phone No. for row '.($key+1)], 422);
                    
                // }else{
                //     $exists = Employee::where('phone_no',$phone_no)->count();
                //     if($exists > 0){
                //         DB::rollback();
                //         return response()->json(['errors' => 'A user with the Phone No '.$phone_no.' already exists on row '.($key+1)], 422);
                //     }
                // }
                
                // if(empty($staff_no)){
                    
                //     DB::rollback();
                //     return response()->json(['errors' => 'Please enter Staff No. for row '.($key+1)], 422);
                    
                // }else{
                //     $exists = Employee::where('staff_no',$staff_no)->count();
                //     if($exists > 0){
                //         DB::rollback();
                //         return response()->json(['errors' => 'A user with the Staff No '.$staff_no.' already exists on row '.($key+1)], 422);
                //     }
                // }
                
                // if(empty($ssn)){
                    
                //     DB::rollback();
                //     return response()->json(['errors' => 'Please enter SSN for row '.($key+1)], 422);
                    
                // }else{
                //     $exists = Employee::where('ssn',$ssn)->count();
                //     if($exists > 0){
                //         DB::rollback();
                //         return response()->json(['errors' => 'A user with the SSN '.$ssn.' already exists on row '.($key+1)], 422);
                //     }
                // }
                
                // if(empty($account_no)){
                    
                //     DB::rollback();
                //     return response()->json(['errors' => 'Please enter Account No for row '.($key+1)], 422);
                    
                // }else{
                //     $exists = Employee::where('account_no',$account_no)->count();
                //     if($exists > 0){
                //         DB::rollback();
                //         return response()->json(['errors' => 'A user with the Account No '.$account_no.' already exists on row '.($key+1)], 422);
                //     }
                // }
                
                $total_milk = $morning + $evening - $rejected;
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
                $data = [
                    'tenant_id' => $tenant_id,
                    'farmer_id' => $farmer_id,	
                    'farmer_code' => $farmer_code,
                    'center_id' => $center_id,
                    'name' => $farmer_name,
                    'morning' => $morning,
                    'evening' => $evening,
                    'rejected' => $rejected,
                    'total' => $total_milk,
                    'collection_date' => date('Y-m-d'),
                    'user_id' => "180"
                    

                ];
                logger($data);
                $milk = MilkCollection::create($data);               
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Milk imported Successfully']);
        } catch (\Exception $e) {
            logger($e);
            // DB::rollback();
    
            return response()->json(['message' => 'Failed to Import Milk. Please try again.'], 500);
        }
    }

    public function edit_milkCollection($id)
    {
        $milk = MilkCollection::findOrFail($id);
        $farmer_code = $milk->farmer_id;
        $farmer = Farmer::where('id', $farmer_code)->first();
        return view('companies.milkcollection.editcollection', compact('milk', 'farmer'));
    }

    public function update_milkCollection($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collection_date' => 'required|date',
            'morning' => '',
            'evening' => '',
            'rejected' => '',
            'total' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $milk = MilkCollection::findOrFail($id);

            $milk->collection_date = $request->collection_date;
            $milk->morning = $request->morning;
            $milk->evening = $request->evening;
            $milk->rejected = $request->rejected;
            $milk->total = $request->total;
            $milk->save();

            DB::commit();
            return response()->json(['success' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_milkCollection($id)
    {
        DB::beginTransaction();
        try {
        $milk = MilkCollection::findOrFail($id);
        $milk->delete();

        DB::commit();
            return response()->json(['message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Collection. Please try again.'], 500);
        }
    }
}
