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

class InventoryController extends Controller
{
    public function index()
    {
        //Sales
        return view('companies.inventory.index');
    }

    public function all_inventory()
    {
        $tenant_id = auth()->user()->id;
        $categories = Category::where('tenant_id', auth()->user()->id)->get();
        $units = ProductUnit::where('tenant_id', auth()->user()->id)->get();
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $inventories = Inventory::join('categories', 'categories.id', '=', 'inventories.category_id')
                ->leftJoin('product_units', 'product_units.id', '=', 'inventories.unit_id')
                ->where('inventories.tenant_id', $tenant_id)
                ->select([
                    'inventories.*',
                    'categories.cat_name',
                    'product_units.unit_name'
                ])->get();


            return DataTables::of($inventories)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('inventory/edit-inventory',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item edit-button" data-action="'.url('inventory/add-stock',[$row->id]).'" href="#" ><i class="fa fa-plus m-r-5"></i> Add Stock</a>
                        <a class="dropdown-item delete-button" data-action="'.url('inventory/delete-inventory',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == "0") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> In Active</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                    } 
                    return $html;
                })
                ->editColumn('quantity', function ($row) {
                    $html = $row->quantity;
                
                    if ($row->quantity <= $row->alert_quantity) {
                        $html .= ' <a class="edit-button" data-action="'.url('inventory/add-stock',[$row->id]).'" href="#" >
                                    <span class="badge badge-danger">
                                        <i class="fa fa-dot-circle-o"></i> Out of Stock
                                    </span></a>';
                    }
                
                    return $html;
                })                
                ->editColumn('buying_price', function ($row) {
                    $html = num_format($row->buying_price);
                    return $html;
                }) 
                ->editColumn('selling_price', function ($row) {
                    $html = num_format($row->selling_price);
                    return $html;
                }) 
                ->rawColumns(['action', 'status', 'buying_price', 'selling_price', 'quantity'])
                ->make(true);
        }
        return view('companies.inventory.all_inventory', compact('categories', 'units'));
    }

    public function categories()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $categories = Category::where('tenant_id', $tenant_id)->get();

            return DataTables::of($categories)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('inventory/edit-category',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('inventory/delete-category',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('companies.inventory.categories.index');
    }

    public function units()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $units = ProductUnit::where('tenant_id', $tenant_id)->get();

            return DataTables::of($units)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('inventory/edit-unit',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('inventory/delete-unit',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('companies.inventory.units.index');
    }

    public function add_sales()
    {
        return view('companies.inventory.add-sales');
    }

    public function store_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name'    => 'required|unique:categories,cat_name',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            Category::create([
                'tenant_id'  => $tenant_id,
                'cat_name'    => $request->cat_name, 
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Category Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_unit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name'    => 'required|unique:product_units,unit_name',
            'unit_code'    => 'required',	
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            ProductUnit::create([
                'tenant_id'  => $tenant_id,
                'unit_name'    => $request->unit_name,
                'unit_code'    => $request->unit_code, 
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Unit Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_inventory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'unit_id'    => 'required',
            'name'    => 'required|unique:inventories,name',
            'quantity'    => 'required',
            'alert_quantity'    => 'required',
            'buying_price'    => 'required',
            'selling_price'    => 'required',
            'status' => 'required',	
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            Inventory::create([
                'tenant_id'  => $tenant_id,
                'category_id'    => $request->category_id,
                'unit_id'    => $request->unit_id,
                'name'    => $request->name,
                'quantity'    => $request->quantity,
                'alert_quantity'    => $request->alert_quantity,
                'buying_price'    => $request->buying_price,
                'selling_price'    => $request->selling_price,
                'status' => $request->status,
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Inventory Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_category($id)
    {
        $category = Category::findorFail($id);
        return view('companies.inventory.categories.edit', compact('category'));
    }

    public function edit_unit($id)
    {
        $unit = ProductUnit::findorFail($id);
        return view('companies.inventory.units.edit', compact('unit'));
    }

    public function edit_inventory($id)
    {
        $inventory = Inventory::findorFail($id);
        $tenant_id = $inventory['tenant_id'];
        $categories = Category::where('tenant_id', $tenant_id)->get();
        $units = ProductUnit::where('tenant_id', $tenant_id)->get();
        return view('companies.inventory.edit-inventory', compact('inventory', 'categories', 'units'));
    }

    public function add_stock($id)
    {
        $inventory = Inventory::findorFail($id);
        return view('companies.inventory.add_stock', compact('inventory'));
    }

    public function update_category($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $category = Category::findOrFail($id);

            $category->cat_name = $request->cat_name;
            $category->save();

            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_unit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_name' => 'required',
            'unit_code' => 'required',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $unit = ProductUnit::findOrFail($id);

            $unit->unit_name = $request->unit_name;
            $unit->unit_code = $request->unit_code;
            $unit->description = $request->description;
            $unit->save();

            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_inventory($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'unit_id'    => 'required',
            'name'           => ['required', Rule::unique('inventories')->ignore($request->id),],
            'quantity'    => 'required',
            'alert_quantity'    => 'required',
            'buying_price'    => 'required',
            'selling_price'    => 'required',
            'status' => 'required',	
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {

            $inventory = Inventory::findOrFail($id);

            $inventory->category_id = $request->category_id;
            $inventory->unit_id = $request->unit_id;
            $inventory->name = $request->name;
            $inventory->quantity = $request->quantity;
            $inventory->alert_quantity = $request->alert_quantity;
            $inventory->buying_price = $request->buying_price;
            $inventory->selling_price = $request->selling_price;
            $inventory->status = $request->status;
            $inventory->description = $request->description;
            $inventory->save();

            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function update_inventory_stock($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->quantity = $inventory->quantity + $request->quantity;
            $inventory->save();
            DB::commit();
            return response()->json(['message' => 'Data Updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function delete_category($id)
    {
        DB::beginTransaction();
        try {
        $category = Category::findOrFail($id);
        $category->delete();

        DB::commit();
            return response()->json(['message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }

    public function delete_unit($id)
    {
        DB::beginTransaction();
        try {
        $unit = ProductUnit::findOrFail($id);
        $unit->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }

    public function delete_inventory($id)
    {
        DB::beginTransaction();
        try {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        DB::commit();
            return response()->json(['message' => 'Data Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Benefits of Kind. Please try again.'], 500);
        }
    }
}
