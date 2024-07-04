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

class MilkCollectionController extends Controller
{
    public function index()
    {
        return view('companies.milkcollection.index');
    }

    public function all_milk_collection()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $milk = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                    ->where('milk_collections.tenant_id', $tenant_id)
                    ->select([
                        'milk_collections.*',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                    ])->get();

            return DataTables::of($milk)
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

    public function add_collection(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        return view('companies.milkcollection.addcollection', compact('centers', 'farmers'));
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
                                'farmers.farmerID as farmerCode',	
                                'collection_centers.center_name',
                                'collection_centers.tenant_id',
                            ])->get();

        $response = array('training' => $data,'parts' => $farmers);
        
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
        $tenant_id = auth()->user()->id;
        $farmer = $milk['farmer_id'];
        $date = $milk['collection_date'];
        $morning = $milk['morning'];
        $evening = $milk['evening'];
        $rejected = $milk['rejected'];
        $total = $milk['total'];
        $userID = '180';

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
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }

}
