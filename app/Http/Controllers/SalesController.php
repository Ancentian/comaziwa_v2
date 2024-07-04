<?php

namespace App\Http\Controllers;

use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\MilkCollection;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\ProductUnit;
use App\Models\StoreSale;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SalesController extends Controller
{
    public function index()
    {
        //Sales
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $sales = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
                    ->join('inventories', 'inventories.id', '=', 'store_sales.item_id')
                    ->join('categories', 'categories.id', '=', 'store_sales.category_id')
                    ->where('store_sales.tenant_id', $tenant_id)
                    ->select([
                        'store_sales.*',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'inventories.name as product_name',
                        'categories.cat_name',	

                    ])->get();

            return DataTables::of($sales)
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
                ->editColumn('order_date', function ($row) {
                    $html = format_date($row->order_date);
                    return $html;
                })
                ->editColumn('unit_cost', function ($row) {
                    $html = num_format($row->unit_cost);
                    return $html;
                })
                ->editColumn('total_cost', function ($row) {
                    $html = num_format($row->total_cost);
                    return $html;
                })
                ->editColumn('created_on', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->rawColumns(['action','fullname', 'order_date', 'created_on', 'unit_cost', 'total_cost'])
                ->make(true);
        }
        return view('companies.sales.index');
    }

    public function add_sales()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        $categories = Category::where('tenant_id', $tenant_id)->get();
        $inventory = Inventory::where('tenant_id', $tenant_id)->get();
        return view('companies.sales.add-sales', compact('centers', 'farmers', 'categories', 'inventory'));
    }

    public function getFarmersByCenter($centerId)
    {
        $center = CollectionCenter::findorFail($centerId);
        $tenant_id = $center->tenant_id;
        $farmers = Farmer::where('center_id', $centerId)
                        ->where('tenant_id', $tenant_id)
                        ->get();
        return response()->json($farmers);
    }

    public function getFarmerDetails($farmerId)
    {
        $farmer = Farmer::findorFail($farmerId);
        return response()->json($farmer);
    }

    public function getProductsByCategory($categoryId)
    {
        $category = Category::findorFail($categoryId);
        $tenant_id = $category->tenant_id;
        $products = Inventory::where('category_id', $categoryId)
                        ->where('tenant_id', $tenant_id)
                        ->get();
        return response()->json($products);
    }

    public function getproductdetails($itemId)
    {
        $product = Inventory::findorFail($itemId);
        return response()->json($product);
    }

    public function store_sales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'farmer_id' => 'required',
            'center_id' => 'required|integer',
            'category_id' => 'required|array',
            'item_id' => 'required|array',
            'order_date' => 'required|date',
            'qty' => 'required|array',
            'unit_cost' => 'required|array',
            'total_cost' => 'required|array',
            'payment_mode' => 'required',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sales = $request->all();
        $tenant_id = auth()->user()->id;
        $user_id = auth()->user()->id;
        $center_id = $sales['center_id'];
        $farmer_id = $sales['farmer_id'];
        $order_date = $sales['order_date'];
        $payment_mode = $sales['payment_mode'];
        $description = $sales['description'];

        foreach ($sales['item_id'] as $key => $item_id) {
            $quantity = $sales['qty'][$key];

            // Create sale record
            StoreSale::create([
                'tenant_id' => $tenant_id,
                'center_id' => $center_id,
                'farmer_id' => $farmer_id,
                'category_id' => $sales['category_id'][$key],
                'item_id' => $item_id,
                'order_date' => $order_date,
                'qty' => $quantity,
                'unit_cost' => $sales['unit_cost'][$key],
                'total_cost' => $sales['total_cost'][$key],
                'payment_mode' => $payment_mode,
                'description' => $description,
                'user_id' => $user_id,
            ]);

            // Update inventory quantity
            $inventory = Inventory::where('id', $item_id)->first();
            if ($inventory) {
                $inventory->quantity -= $quantity;
                $inventory->save();
            }
        }
        return redirect()->back()->with('message', 'Sales added successfully');
    }


}
