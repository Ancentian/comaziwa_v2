<?php

namespace App\Http\Controllers;

use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\MilkCollection;
use App\Models\Deduction;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\ProductUnit;
use App\Models\StoreSale;
use App\Models\ShareContribution;
use App\Models\Payment;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Excel;

class PaymentsController extends Controller
{
    public function index()
    {
        return view('companies.payments.index');
    }

    // public function generate_payments()
    // {
    //     if (request()->ajax()) {
    //         $start_date = request()->start_date;
    //         $end_date = request()->end_date;

    //         $tenant_id = auth()->user()->id;

    //         // Fetch milk collections
    //         $milk = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
    //                 ->join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
    //                 ->where('milk_collections.tenant_id', $tenant_id)
    //                 ->select([
    //                     'farmers.id as farmer_id',
    //                     DB::raw('SUM(milk_collections.total) as milk_total')
    //                 ]);

    //         if (!empty($start_date) && !empty($end_date)) {
    //             $milk->whereDate('milk_collections.collection_date', '>=', $start_date)
    //                 ->whereDate('milk_collections.collection_date', '<=', $end_date);
    //         }

    //         if (!empty(request()->center_id)) {
    //             $milk->where('milk_collections.center_id', '=', request()->center_id);
    //         }

    //         if (!empty(request()->farmer_id)) {
    //             $milk->where('milk_collections.farmer_id', '=', request()->farmer_id);
    //         }

    //         $milk = $milk->groupBy('farmers.id')->get();
    //         logger($milk);

    //         // Fetch store sales
    //         $sales = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
    //                 ->where('store_sales.tenant_id', $tenant_id)
    //                 ->select([
    //                     'farmers.id as farmer_id',
    //                     DB::raw('SUM(store_sales.total_cost) as sales_total')
    //                 ]);

    //         if (!empty($start_date) && !empty($end_date)) {
    //             $sales->whereDate('store_sales.sale_date', '>=', $start_date)
    //                 ->whereDate('store_sales.sale_date', '<=', $end_date);
    //         }

    //         if (!empty(request()->farmer_id)) {
    //             $sales->where('store_sales.farmer_id', '=', request()->farmer_id);
    //         }

    //         $sales = $sales->groupBy('farmers.id')->get();

    //         // Fetch deductions (individual)
    //         $deductions = Deduction::join('farmers', 'farmers.id', '=', 'deductions.farmer_id')
    //                 ->where('deductions.tenant_id', $tenant_id)
    //                 ->where('deductions.deduction_type', 'individual')
    //                 ->select([
    //                     'farmers.id as farmer_id',
    //                     DB::raw('SUM(deductions.amount) as deduction_total')
    //                 ]);

    //         if (!empty($start_date) && !empty($end_date)) {
    //             $deductions->whereDate('deductions.deduction_date', '>=', $start_date)
    //                     ->whereDate('deductions.deduction_date', '<=', $end_date);
    //         }

    //         if (!empty(request()->farmer_id)) {
    //             $deductions->where('deductions.farmer_id', '=', request()->farmer_id);
    //         }

    //         $deductions = $deductions->groupBy('farmers.id')->get();

    //         // Combine results
    //         $results = $milk->merge($sales)->merge($deductions);
    //         logger($sales);
    //         logger($results);
    //         return DataTables::of($results)
    //             ->addColumn('action', function ($row) {
    //                 $html = '<div class="btn-group">
    //                     <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
    //                     <div class="dropdown-menu dropdown-menu-right">
    //                     <a class="dropdown-item edit-button" data-action="'.url('milkCollection/edit-milk-collection',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
    //                     <a class="dropdown-item delete-button" data-action="'.url('milkCollection/delete-milk-collection',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
    //                     </div>
    //                 </div>';
    //                 return $html;
    //             })
    //             ->addColumn('fullname', function ($row) {
    //                 return $row->farmerID.' - '.$row->fname.' '.$row->lname;
    //             })
    //             ->editColumn('collection_date', function ($row) {
    //                 $html = format_date($row->collection_date);
    //                 return $html;
    //             })
    //             ->editColumn('created_on', function ($row) {
    //                 $html = format_date($row->created_at);
    //                 return $html;
    //             })
    //             ->rawColumns(['action', 'fullname'])
    //             ->make(true);
    //     }

    //     return view('companies.payments.generate-payments');
    // }

    public function generate_payments()
{
    if (request()->ajax()) {
        $start_date = request()->start_date;
        $end_date = request()->end_date;

        $tenant_id = auth()->user()->id;

        // Fetch milk collections
        $milk = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
            ->where('milk_collections.tenant_id', $tenant_id)
            ->select([
                'farmers.id as farmer_id',
                'farmers.fname',
                'farmers.lname',
                'farmers.farmerID',
                DB::raw('SUM(milk_collections.total) as total_milk')
            ]);

        if (!empty($start_date) && !empty($end_date)) {
            $milk->whereDate('milk_collections.collection_date', '>=', $start_date)
                 ->whereDate('milk_collections.collection_date', '<=', $end_date);
        }

        $milk = $milk->groupBy('farmers.id')->get();
        logger($milk);
        // Fetch store deductions
        $storeDeductions = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
            ->where('store_sales.tenant_id', $tenant_id)
            ->select([
                'farmers.id as farmer_id',
                DB::raw('SUM(store_sales.total_cost) as total_store_deductions')
            ]);

        if (!empty($start_date) && !empty($end_date)) {
            $storeDeductions->whereDate('store_sales.order_date', '>=', $start_date)
                            ->whereDate('store_sales.order_date', '<=', $end_date);
        }

        $storeDeductions = $storeDeductions->groupBy('farmers.id')->get();
        logger($storeDeductions);
        // Fetch individual deductions
        $individualDeductions = Deduction::join('farmers', 'farmers.id', '=', 'deductions.farmer_id')
            ->where('deductions.tenant_id', $tenant_id)
            ->where('deductions.deduction_type', 'individual')
            ->select([
                'farmers.id as farmer_id',
                DB::raw('SUM(deductions.amount) as total_individual_deductions')
            ]);

        if (!empty($start_date) && !empty($end_date)) {
            $individualDeductions->whereDate('deductions.date', '>=', $start_date)
                                 ->whereDate('deductions.date', '<=', $end_date);
        }

        $individualDeductions = $individualDeductions->groupBy('farmers.id')->get();

        // Fetch general deductions
        $generalDeductions = Deduction::where('deductions.tenant_id', $tenant_id)
            ->where('deductions.deduction_type', 'general')
            ->select([
                DB::raw('SUM(deductions.amount) as total_general_deductions')
            ]);

        if (!empty($start_date) && !empty($end_date)) {
            $generalDeductions->whereDate('deductions.date', '>=', $start_date)
                            ->whereDate('deductions.date', '<=', $end_date);
        }

        $generalDeductions = $generalDeductions->get();
        logger($generalDeductions);
        // Fetch shares
        $shares = ShareContribution::join('farmers', 'farmers.id', '=', 'share_contributions.farmer_id')
            ->where('share_contributions.tenant_id', $tenant_id)
            ->select([
                'farmers.id as farmer_id',
                DB::raw('SUM(share_contributions.share_value) as total_shares')
            ]);

        if (!empty($start_date) && !empty($end_date)) {
            $shares->whereDate('share_contributions.issue_date', '>=', $start_date)
                   ->whereDate('share_contributions.issue_date', '<=', $end_date);
        }

        $shares = $shares->groupBy('farmers.id')->get();
        logger($shares);
        // Fetch previous dues
        // $previousDues = PreviousDue::join('farmers', 'farmers.id', '=', 'previous_dues.farmer_id')
        //     ->where('previous_dues.tenant_id', $tenant_id)
        //     ->select([
        //         'farmers.id as farmer_id',
        //         DB::raw('SUM(previous_dues.amount) as total_previous_dues')
        //     ]);

        // if (!empty($start_date) && !empty($end_date)) {
        //     $previousDues->whereDate('previous_dues.due_date', '>=', $start_date)
        //                  ->whereDate('previous_dues.due_date', '<=', $end_date);
        // }

        // $previousDues = $previousDues->groupBy('farmers.id')->get();

        // Combine results
        $results = $milk->map(function ($milk) use ($storeDeductions, $individualDeductions, $generalDeductions, $shares) {
            $farmer_id = $milk->farmer_id;
            $store_deduction = $storeDeductions->firstWhere('farmer_id', $farmer_id);
            $individual_deduction = $individualDeductions->firstWhere('farmer_id', $farmer_id);
            $general_deduction = $generalDeductions->first();
            $share = $shares->firstWhere('farmer_id', $farmer_id);
            //$previous_due = $previousDues->firstWhere('farmer_id', $farmer_id);

            return [
                'farmer_id' => $farmer_id,
                'fullname' => $milk->farmerID . ' - ' . $milk->fname . ' ' . $milk->lname,
                'total_milk' => $milk->total_milk,
                'total_store_deductions' => $store_deduction->total_store_deductions ?? 0,
                'total_individual_deductions' => $individual_deduction->total_individual_deductions ?? 0,
                'total_general_deductions' => $general_deduction->total_general_deductions ?? 0,
                'total_shares' => $share->total_shares ?? 0,
                // 'total_previous_dues' => $previous_due->total_previous_dues ?? 0,
            ];
        });

        return DataTables::of($results)
            ->addColumn('action', function ($row) {
                $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item edit-button" data-action="'.url('milkCollection/edit-milk-collection',[$row['farmer_id']]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                    <a class="dropdown-item delete-button" data-action="'.url('milkCollection/delete-milk-collection',[$row['farmer_id']]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('companies.payments.generate-payments');
}


}
