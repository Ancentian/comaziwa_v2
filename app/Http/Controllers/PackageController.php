<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use DB;

class PackageController extends Controller
{
    public function index()
    {
        $package = Package::all();
        return view('superadmin.packages.index', compact('package'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'price'  => 'required',
            'module' => 'required|array', 
            'staff_no' => 'required',
            'is_hidden' => ''
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $selectedModules = $request->input('module');
    
        // Convert the selected modules array to a string if desired
        $modulesString = implode(',', $selectedModules);
        
        DB::beginTransaction();
        try {
            
        $is_hidden = ($request->is_hidden == "") ? 0 : 1;
        
        Package::create([
            'name'   => $request->name,
            'staff_no' => $request->staff_no,
            'price'  => $request->price,
            'annual_price'  => $request->annual_price,
            'module' => $modulesString,
            'is_hidden' => $is_hidden,
        ]);

        DB::commit();
            return response()->json(['message' => 'Package Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('database')->error('Database Error: ' . $e->getMessage());
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    
    }

    public function edit($id){
        $package = Package::findOrFail($id);
        return view('superadmin.packages.edit',compact('package'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'price'  => 'required',
            'staff_no' => 'required',
            'module' => 'required|array', // Ensure modules is an array
            'is_hidden' => ''
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $selectedModules = $request->input('module');

        // Convert the selected modules array to a string if desired
        $modulesString = implode(',', $selectedModules);

        DB::beginTransaction();
        try {
        $is_hidden = ($request->is_hidden == "") ? 0 : 1;
        $package = Package::findOrFail($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->annual_price = $request->annual_price;
        $package->module = $modulesString;
        $package->staff_no = $request->staff_no;
        $package->is_hidden = $is_hidden;
        $package->save();

        DB::commit();
            return response()->json(['message' => 'Package Updated Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }

    }


    public function delete($id)
    {
        DB::beginTransaction();
        try {

        $package = Package::findOrFail($id);
        $package->delete();

        DB::commit();
            return response()->json(['message' => 'Package Deleted Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
   
    }
}
 