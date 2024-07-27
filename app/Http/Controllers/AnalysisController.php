<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkCollection;
use App\Models\Bank;
use App\Models\Farmer;
use App\Models\CollectionCenter;
use App\Models\StoreSale;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\ShareContribution;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Excel;

class AnalysisController extends Controller
{

    public function index()
    {
        return view('analysis.index');
    }

    public function collection_center_monthly_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $milk = MilkCollection::join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                ->where('milk_collections.tenant_id', $tenant_id)
                ->select([
                    'collection_centers.id as center_id',
                    'collection_centers.center_name',
                    DB::raw('YEAR(collection_date) as year'),
                    DB::raw('MONTH(collection_date) as month'),
                    DB::raw('SUM(milk_collections.morning) as total_morning'),
                    DB::raw('SUM(milk_collections.evening) as total_evening'),
                    DB::raw('SUM(milk_collections.rejected) as total_rejected'),
                    DB::raw('SUM(milk_collections.total) as total_milk')
                ])
                ->groupBy('year', 'month', 'collection_centers.center_name')
                ->orderBy('year')
                ->orderBy('month');


                if(!empty($start_date) && !empty($end_date)){
                    $milk->whereDate('milk_collections.collection_date','>=',$start_date);
                    $milk->whereDate('milk_collections.collection_date','<=',$end_date);
                }

            if(!empty(request()->center_id)){
                $milk->where('milk_collections.center_id','=',request()->center_id);
            }

            return DataTables::of($milk->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<a class="btn btn-success" href="'.url('analysis/collection-center-report',[$row->center_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
                        return $html;
                    }
                )
                
                ->editColumn('total_milk', function ($row) {
                    $html = num_format($row->total_milk);
                    return $html;
                })
                ->editColumn('total_morning', function ($row) {
                    $html = num_format($row->total_morning);
                    return $html;
                })
                ->editColumn('total_evening', function ($row) {
                    $html = num_format($row->total_evening);
                    return $html;
                })
                ->editColumn('total_rejected', function ($row) {
                    $html = num_format($row->total_rejected);
                    return $html;
                })
                ->editColumn('collection_month', function ($row) {
                    $html = Carbon::createFromFormat('Y-m', $row->year . '-' . $row->month)->format('F, Y');
                    return $html;
                })
                
                ->rawColumns(['action', 'total_milk', 'total_morning', 'total_evening', 'total_rejected', 'collection_month'])
                ->make(true);
        }
        return view('companies.reports.collection-center-monthly-report', compact('centers'));
    }

    public function report_by_center($id)
    {
        $tenant_id = auth()->user()->id;
        $farmers = Farmer::where('tenant_id', $tenant_id)
                        ->where('center_id', $id)
                        ->get();

        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;      // Debugging

            $milk = MilkCollection::join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
                                ->join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                                ->where('milk_collections.tenant_id', $tenant_id)
                                ->where('milk_collections.center_id', $id)
                                ->select([
                                    'milk_collections.*',
                                    'collection_centers.center_name',
                                    'farmers.farmerID',
                                    'farmers.fname',
                                    'farmers.lname',
                                ]);

            if (!empty($start_date) && !empty($end_date)) {
                $milk->whereDate('milk_collections.collection_date', '>=', $start_date);
                $milk->whereDate('milk_collections.collection_date', '<=', $end_date);
            }

            if (!empty(request()->farmer_id)) {
                $milk->where('milk_collections.farmer_id', '=', request()->farmer_id);
            }

            return DataTables::of($milk->get())
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-group">
                                <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item edit-button" data-action="' . url('milkCollection/edit-milk-collection', [$row->id]) . '" href="#"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                    <a class="dropdown-item delete-button" data-action="' . url('milkCollection/delete-milk-collection', [$row->id]) . '" href="#"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                </div>
                            </div>';
                    return $html;
                })
                ->addColumn('fullname', function ($row) {
                    return $row->farmerID . ' - ' . $row->fname . ' ' . $row->lname;
                })
                ->editColumn('collection_date', function ($row) {
                    return format_date($row->collection_date);
                })
                ->editColumn('created_on', function ($row) {
                    return format_date($row->created_at);
                })
                ->rawColumns(['action', 'fullname'])
                ->make(true);
        }

        return view('companies.reports.collection-center-report', compact('farmers'));
    }

    public function farmers_monthly_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $milk = MilkCollection::join('collection_centers', 'collection_centers.id', '=', 'milk_collections.center_id')
                    ->join('farmers', 'farmers.id', '=', 'milk_collections.farmer_id')
                    ->where('milk_collections.tenant_id', $tenant_id)
                    ->select([
                        'collection_centers.id as center_id',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'farmers.id as farmer_id',
                        DB::raw('YEAR(collection_date) as year'),
                        DB::raw('MONTH(collection_date) as month'),
                        DB::raw('SUM(milk_collections.morning) as total_morning'),
                        DB::raw('SUM(milk_collections.evening) as total_evening'),
                        DB::raw('SUM(milk_collections.rejected) as total_rejected'),
                        DB::raw('SUM(milk_collections.total) as total_milk')
                    ])
                    ->groupBy('year', 'month', 'collection_centers.center_name', 'farmers.farmerID', 'farmers.fname', 'farmers.lname', 'farmers.id')
                    ->orderBy('year')
                    ->orderBy('month');


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
                        $html = '<a class="btn btn-success btn-sm" href="'.url('analysis/farmer-report',[$row->farmer_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
                        return $html;
                    }
                )
                ->addColumn('fullname', function ($row) {
                    return $row->farmerID . ' - ' . $row->fname . ' ' . $row->lname;
                })
                ->editColumn('total_milk', function ($row) {
                    $html = num_format($row->total_milk);
                    return $html;
                })
                ->editColumn('total_morning', function ($row) {
                    $html = num_format($row->total_morning);
                    return $html;
                })
                ->editColumn('total_evening', function ($row) {
                    $html = num_format($row->total_evening);
                    return $html;
                })
                ->editColumn('total_rejected', function ($row) {
                    $html = num_format($row->total_rejected);
                    return $html;
                })
                ->editColumn('collection_month', function ($row) {
                    $html = Carbon::createFromFormat('Y-m', $row->year . '-' . $row->month)->format('F, Y');
                    return $html;
                })
                
                ->rawColumns(['action', 'fullname', 'total_milk', 'total_morning', 'total_evening', 'total_rejected', 'collection_month'])
                ->make(true);
        }
        return view('companies.reports.farmer-monthly-report', compact('centers', 'banks'));
    }

    public function farmer_report($farmer_id)
    {
        $tenant_id = auth()->user()->id;
        $farmers = Farmer::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        return view('companies.reports.farmer-report', compact('milk', 'farmers', 'banks', 'centers'));
    }

    public function sales_monthly_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();

        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $sales = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
                    ->where('store_sales.tenant_id', $tenant_id)
                    ->select([
                        // 'store_sales.total_cost as total_cost',
                        DB::raw('YEAR(order_date) as year'),
                        DB::raw('MONTH(order_date) as month'),
                        DB::raw('SUM(total_cost) as total_cost'),
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'farmers.id as farmer_id',	
                    ])
                    ->groupBy('year', 'month', 'collection_centers.center_name', 'farmers.farmerID', 'farmers.fname', 'farmers.lname', 'farmers.id')
                    ->orderBy('year')
                    ->orderBy('month');


                if(!empty($start_date) && !empty($end_date)){
                    $sales->whereDate('store_sales.order_date','>=',$start_date);
                    $sales->whereDate('store_sales.order_date','<=',$end_date);
                }
    
                if(!empty(request()->center_id)){
                    $sales->where('store_sales.center_id','=',request()->center_id);
                }
    
                if(!empty(request()->farmer_id)){
                    $sales->where('store_sales.farmer_id','=',request()->farmer_id);
                }

            return DataTables::of($sales->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<a class="btn btn-success btn-sm" href="'.url('analysis/farmer-sales-report',[$row->farmer_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
                        return $html;
                    }
                )
                ->addColumn('fullname', function ($row) {
                    return $row->farmerID.' - '.$row->fname.' '.$row->lname;
                })
                ->editColumn('total_cost', function ($row) {
                    $html = num_format($row->total_cost);
                    return $html;
                })
                ->editColumn('sales_month', function ($row) {
                    $html = Carbon::createFromFormat('Y-m', $row->year . '-' . $row->month)->format('F, Y');
                    return $html;
                })
                ->rawColumns(['action','fullname', 'total_cost'])
                ->make(true);
        }
        return view('companies.reports.sales-monthly-report', compact('centers'));
    }

    public function farmer_sales_report($farmer_id)
    {
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $sales = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
                    ->join('inventories', 'inventories.id', '=', 'store_sales.item_id')
                    ->join('categories', 'categories.id', '=', 'store_sales.category_id')
                    ->where('store_sales.tenant_id', $tenant_id)
                    ->where('store_sales.farmer_id', $farmer_id)
                    ->select([
                        'store_sales.*',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'inventories.name as product_name',
                        'categories.cat_name',	
                    ]);

                if(!empty($start_date) && !empty($end_date)){
                    $sales->whereDate('store_sales.order_date','>=',$start_date);
                    $sales->whereDate('store_sales.order_date','<=',$end_date);
                }
    
                if(!empty(request()->center_id)){
                    $sales->where('store_sales.center_id','=',request()->center_id);
                }
    
                if(!empty(request()->farmer_id)){
                    $sales->where('store_sales.farmer_id','=',request()->farmer_id);
                }

            return DataTables::of($sales->get())
                ->addColumn(
                    'action',
                    function ($row) {
                        $html = '<a class="btn btn-success btn-sm" href="'.url('analysis/farmer-sales-report',[$row->farmer_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
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
        return view('companies.reports.farmer-sales-report');
    }

    public function monthly_deductions_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        
            $tenant_id = Auth::user()->id;
            $deduction = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
                    ->leftJoin('farmers', 'farmers.id', '=', 'deductions.farmer_id')
                    ->leftJoin('collection_centers', 'collection_centers.id', '=', 'deductions.center_id')
                    ->where('deductions.tenant_id', $tenant_id)
                    ->select([
                        DB::raw('YEAR(deductions.date) as year'),
                        DB::raw('MONTH(deductions.date) as month'),
                        DB::raw('SUM(deductions.amount) as total_amount'),
                        'farmers.fname', 
                        'farmers.lname', 
                        'farmers.farmerID',
                        'deductions.farmer_id',
                        'deductions.center_id',
                        'deductions.deduction_type',
                        'collection_centers.center_name',
                        'deduction_types.name as deduction_name',
                        'deduction_types.type as deduction_type'
                    ])
                    ->groupBy('year', 'month', 'collection_centers.center_name','deductions.farmer_id','deductions.center_id',  'deduction_types.name', 'farmers.fname', 'farmers.lname', 'farmers.farmerID', 'deductions.deduction_type')
                    ->orderBy('year')
                    ->orderBy('month');
        
            if (!empty($start_date) && !empty($end_date)) {
                $deduction->whereDate('deductions.date', '>=', $start_date);
                $deduction->whereDate('deductions.date', '<=', $end_date);
            }
        
            if (!empty(request()->center_id)) {
                $deduction->where('deductions.center_id', '=', request()->center_id);
            }
        
            if (!empty(request()->farmer_id)) {
                $deduction->where('deductions.farmer_id', '=', request()->farmer_id);
            }
        
            return DataTables::of($deduction->get())
                ->addColumn('action', function ($row) {
                    $html = '<a class="btn btn-success btn-sm" href="'.url('analysis/farmers-deductions-report',[$row->farmer_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
                    return $html;
                })
                ->editColumn('fullname', function ($row) {
                    if ($row->farmer_id == null || $row->center_id == null) {  
                        return "All Farmers";
                    } else {
                        return $row->farmerID . ' - ' . $row->fname . ' ' . $row->lname;
                    }
                })
                ->editColumn('month', function ($row) {
                    return Carbon::createFromFormat('Y-m', $row->year . '-' . $row->month)->format('F, Y');
                })
                ->editColumn('total_amount', function ($row) {
                    return num_format($row->total_amount);
                })
                ->editColumn('center_name', function ($row) {
                    if ($row->center_id == null || $row->farmer_id == null) {
                        return "All Centers";
                    } else {
                        return $row->center_name;
                    }
                })
                ->rawColumns(['action', 'fullname', 'month', 'center_name'])
                ->make(true);
        }
        
        return view('companies.reports.monthly-deductions-report', compact('centers'));
    }

    public function farmers_deductions_report($id)
    {
        $tenant_id = auth()->user()->id;
        $farmer = Farmer::find($id);
        $farmers = Farmer::where('tenant_id', $tenant_id)->where('id', $farmer->center_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        
            $tenant_id = Auth::user()->id;
            $deduction = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
                    ->leftJoin('farmers', 'farmers.id', '=', 'deductions.farmer_id')
                    ->leftJoin('collection_centers', 'collection_centers.id', '=', 'deductions.center_id')
                    ->where('deductions.tenant_id', $tenant_id)
                    ->where('deductions.farmer_id', $id)
                    ->select([
                        DB::raw('YEAR(deductions.date) as year'),
                        DB::raw('MONTH(deductions.date) as month'),
                        DB::raw('SUM(deductions.amount) as total_amount'),
                        'farmers.fname', 
                        'farmers.lname', 
                        'farmers.farmerID',
                        'deductions.farmer_id',
                        'deductions.center_id',
                        'deductions.deduction_type',
                        'deductions.date',
                        'deductions.created_at',
                        'deductions.amount',
                        'collection_centers.center_name',
                        'deduction_types.name as deduction_name',
                        'deduction_types.type as deduction_type'
                    ])
                    ->groupBy('year', 'month', 'collection_centers.center_name','deductions.farmer_id','deductions.center_id', 'deductions.date',  'deduction_types.name', 'farmers.fname', 'farmers.lname', 'farmers.farmerID', 'deductions.deduction_type', 'deductions.created_at', 'deductions.amount')
                    ->orderBy('year')
                    ->orderBy('month');
        
            if (!empty($start_date) && !empty($end_date)) {
                $deduction->whereDate('deductions.date', '>=', $start_date);
                $deduction->whereDate('deductions.date', '<=', $end_date);
            }
        
            return DataTables::of($deduction->get())
                ->addColumn('action', function ($row) {
                    $html = '<a class="btn btn-success btn-sm" href="'.url('analysis/farmers-deductions-report',[$row->farmer_id]).'" ><i class="fa fa-eye m-r-5"></i> View</a>';
                    return $html;
                })
                ->editColumn('fullname', function ($row) {
                    return $row->farmerID . ' - ' . $row->fname . ' ' . $row->lname;
                })
                ->editColumn('date', function ($row) {
                    $html = format_date($row->date);
                    return $html;
                })
                ->editColumn('amount', function ($row) {
                    return num_format($row->amount);
                })
                ->editColumn('center_name', function ($row) {
                    return $row->center_name;
                })
                ->editColumn('created_on', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->rawColumns(['action', 'fullname', 'month', 'center_name'])
                ->make(true);
        }
        return view('companies.reports.farmer-deduction-report', compact('farmers'));
    }

    public function payments_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $tenant_id = auth()->user()->id;
            $payments = Payment::join('farmers', 'farmers.id', '=', 'payments.farmer_id')
                    ->join('collection_centers', 'collection_centers.id', '=', 'payments.center_id')
                    ->where('payments.tenant_id', $tenant_id)
                    ->select([
                        'payments.*',
                        'collection_centers.center_name',
                        'farmers.farmerID',
                        'farmers.fname',
                        'farmers.lname',
                        'farmers.bank_id',
                    ]);

            // if(!empty($start_date) && !empty($end_date)){
            //     $payments->whereDate('payments.collection_date','>=',$start_date);
            //     $payments->whereDate('payments.collection_date','<=',$end_date);
            // }

            if(!empty(request()->pay_period)){
                $payments->where('payments.pay_period','=',request()->pay_period);
            }

            if(!empty(request()->center_id)){
                $payments->where('payments.center_id','=',request()->center_id);
            }

            if(!empty(request()->farmer_id)){
                $payments->where('payments.farmer_id','=',request()->farmer_id);
            }

            return DataTables::of($payments->get())
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
                ->addColumn('bank', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                
                    $bank = DB::table('farmers')
                              ->join('banks', 'farmers.bank_id', '=', 'banks.id')
                              ->where('farmers.id', $farmer_id)
                              ->where('farmers.tenant_id', $tenant_id)
                              ->select('banks.bank_name')
                              ->first();
                
                    return $bank ? $bank->bank_name : 'N/A';
                })
                
                ->editColumn('total_milk', function ($row) {
                    $html = num_format($row->total_milk);
                    return $html;
                })
                ->editColumn('milk_rate', function ($row) {
                    $html = num_format($row->milk_rate);
                    return $html;
                })
                ->editColumn('store_deductions', function ($row) {
                    $html = num_format($row->store_deductions);
                    return $html;
                })
                ->editColumn('individual_deductions', function ($row) {
                    $html = num_format($row->individual_deductions);
                    return $html;
                })
                ->editColumn('general_deductions', function ($row) {
                    $html = num_format($row->general_deductions);
                    return $html;
                })
                ->editColumn('shares_contribution', function ($row) {
                    $html = num_format($row->shares_contribution);
                    return $html;
                })
                ->editColumn('total_deductions', function ($row) {
                    $total = $row->store_deductions + $row->individual_deductions + $row->general_deductions + $row->shares_contribution;
                    $html = num_format($total);
                    return $html;
                })
                 
                ->editColumn('previous_dues', function ($row) {
                    $html = num_format($row->previous_dues);
                    return $html;
                })
                ->editColumn('gross_pay', function ($row) {
                    $gross = $row->total_milk * $row->milk_rate;
                    $html = num_format($gross);
                    return $html;
                })
                
                ->editColumn('net_pay', function ($row) {
                    $gross = $row->total_milk * $row->milk_rate;
                    $total_deductions = $row->store_deductions + $row->individual_deductions + $row->general_deductions + $row->shares_contribution + $row->previous_dues;
                    $net_pay = $gross - $total_deductions;
                    $html = num_format($net_pay);
                    return $html;
                })
                ->editColumn('created_on', function ($row) {
                    $html = format_date($row->created_at);
                    return $html;
                })
                ->rawColumns(['action','fullname', 'total_milk'])
                ->make(true);
        }
        return view('companies.reports.payment-report', compact('centers'));
    }

    public function shares_contribution_report()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $tenant_id = Auth::user()->id;
            $shares = ShareContribution::join('farmers', 'farmers.id', '=', 'share_contributions.farmer_id')
                    ->leftJoin('collection_centers', 'collection_centers.id', '=', 'share_contributions.center_id')
                    ->where('share_contributions.tenant_id', $tenant_id)
                    ->select([
                        'share_contributions.farmer_id',
                        'share_contributions.center_id',
                        'farmers.fname', 
                        'farmers.lname', 
                        'farmers.farmerID',
                        'collection_centers.center_name',
                        DB::raw('SUM(share_contributions.share_value) as total_shares'),
                    ])
                    ->groupBy('share_contributions.farmer_id', 'share_contributions.center_id', 'farmers.fname', 'farmers.lname', 'farmers.farmerID', 'collection_centers.center_name');

                    if (!empty(request()->center_id)) {
                        $shares->where('share_contributions.center_id', '=', request()->center_id);
                    }
                
                    if (!empty(request()->farmer_id)) {
                        $shares->where('share_contributions.farmer_id', '=', request()->farmer_id);
                    }

            return DataTables::of($shares->get())
            ->addColumn(
                'action',
                function ($row) {
                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item edit-button" data-action="'.url('shares/edit-shares',[$row->id]).'" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a>
                      <a class="dropdown-item delete-button" data-action="'.url('shares/delete-shares',[$row->id]).'" href="#" ><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('fullname', function ($row) {
                $html = $row->farmerID.' - '.$row->fname.' '.$row->lname;
                return $html;
            })
            ->editColumn('total_shares', function ($row) {
                $html = num_format($row->total_shares);
                return $html;
            })
            ->editColumn('center_name', function ($row) {
                $html = $row->center_name;
                return $html;
            })
            ->rawColumns(['action', 'fullname'])
            ->make(true);
        }
        return view('companies.reports.shares-contribution-report', compact('centers'));
    }
}
