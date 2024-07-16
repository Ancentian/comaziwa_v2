<?php

namespace App\Http\Controllers;
use App\Models\Asset;
use App\Models\AssetCategory;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
{
    public function index()
    {
        $tenant_id = auth()->user()->id;
        $categories = AssetCategory::where('tenant_id', $tenant_id)->get();
        return view('companies.assets.index', compact('categories'));
    }

    public function categories()
    {
        return view('companies.assets.categories.index');
    }

    public function asset_categories()
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $assets = AssetCategory::where('tenant_id', $tenant_id)->get();
            return DataTables::of($assets)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('assets/edit-asset-category',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('assets/delete-asset-category',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                )
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function all_assets()
    {
        $tenant_id = auth()->user()->id;
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $assets = Asset::join('asset_categories', 'asset_categories.id', '=', 'assets.category_id')
                    ->where('assets.tenant_id', $tenant_id)
                    ->select([
                        'assets.*',
                        'asset_categories.category_name',
                    ])->get();
            return DataTables::of($assets)
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<div class="btn-group">
                        <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item edit-button" data-action="'.url('assets/edit-asset',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item delete-button" data-action="'.url('assets/delete-asset',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                        </div>
                    </div>';
                        return $html;
                    }
                ) 
                ->editColumn('purchase_price', function ($row) {
                    $html = num_format($row->purchase_price);
                    return $html;
                }) 
                ->editColumn('current_value', function ($row) {
                    $html = num_format($row->current_value);
                    return $html;
                })
                ->editColumn('purchase_date', function ($row) {
                    $html = format_date($row->purchase_date);
                    return $html;
                })
                ->editColumn('created_at', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == "2") {
                        $html = '<span><i class="fa fa-dot-circle-o text-danger"></i> Sold</span>';
                    } elseif ($row->status == "1") {
                        $html = "<span><i class='fa fa-dot-circle-o text-success'></i> Active</span>";
                    } elseif ($row->status == "0") {
                        $html = "<span><i class='fa fa-dot-circle-o text-warning'></i> Inactive</span>";
                    }
                    return $html;
                })
                ->rawColumns(['action', 'purchase_price', 'current_value', 'purchase_date', 'created_at', 'status'])
                ->make(true);
        }
    }

    public function store_asset_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name'    => 'required|unique:asset_categories,category_name',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        $tenant_id = auth()->user()->id;
            AssetCategory::create([
                'tenant_id'  => $tenant_id,
                'category_name'    => $request->category_name, 
                'description' => $request->description
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Category Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function store_assets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'asset_name'    => 'required|unique:assets,asset_name',
            'purchase_date'    => 'required',
            'purchase_price'    => 'required',
            'current_value'    => 'required',
            'location'    => '',
            'status'    => '',
            'description' => '',
            'file.*'    => 'required|mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx|max:5120',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        DB::beginTransaction();
        try {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/cooperative_documents/'), $filename);
        }
        $tenant_id = auth()->user()->id;
            Asset::create([
                'tenant_id'  => $tenant_id,
                'category_id'    => $request->category_id,
                'asset_name'    => $request->asset_name,
                'purchase_date'    => $request->purchase_date,
                'purchase_price'    => $request->purchase_price,
                'current_value'    => $request->current_value,
                'location'    => $request->location,
                'status'    => $request->status,
                'description' => $request->description,  
                'file' => $filename
            ]);
        
        DB::commit();
        return response()->json(['message' => 'Asset Added Successfully']);
        } catch (\Exception $e) {
            logger($e);
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    public function edit_asset_category($id)
    {
        $category = AssetCategory::findorFail($id);
        return view('companies.assets.categories.edit',compact('category'));
    }

    public function edit_asset($id)
    {
        $asset = Asset::findorFail($id);
        $tenant_id = auth()->user()->id;
        $categories = AssetCategory::where('tenant_id', $tenant_id)->get();
        return view('companies.assets.edit',compact('asset','categories'));
    }

    public function update_asset_category(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:asset_categories,category_name,' . $id,
            'description' => '',
        ]);
        logger($request);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $asset = AssetCategory::findOrFail($id);
            $asset->category_name = $request->category_name;
            $asset->description = $request->description;
            $asset->save();

            DB::commit();
            return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update data. Please try again.'], 500);
        }
    }

    public function update_assets(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id'    => 'required',
            'asset_name'    => 'required|unique:assets,asset_name,'. $id,
            'purchase_date'    => 'required',
            'purchase_price'    => 'required',
            'current_value'    => 'required',
            'location'    => '',
            'status'    => '',
            'description' => '',
        ]);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $asset = Asset::findOrFail($id);
            $asset->category_id = $request->category_id;
            $asset->asset_name = $request->asset_name;
            $asset->purchase_date = $request->purchase_date;
            $asset->purchase_price = $request->purchase_price;
            $asset->current_value = $request->current_value;
            $asset->location = $request->location;
            $asset->status = $request->status;
            $asset->save();

            DB::commit();
            return response()->json(['message' => 'Data updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => 'Failed to update data. Please try again.'], 500);
        }
    }

    public function delete_asset_category($id)
    {
        DB::beginTransaction();
        try {
            $asset = AssetCategory::findOrFail($id);
            $asset->delete();

            DB::commit();
            return response()->json(['message' => 'Category Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Asset. Please try again.'], 500);
        }
    }

    public function delete_asset($id)
    {
        DB::beginTransaction();
        try {
            $asset = Asset::findOrFail($id);
            $asset->delete();

            DB::commit();
            return response()->json(['message' => 'Asset Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to delete Asset. Please try again.'], 500);
        }
    }

}
