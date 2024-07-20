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
use App\Models\ShareSetting;
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
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
        return view('companies.payments.index', compact('centers', 'banks'));
    }

    public function all_payments()
    {
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
                 
                ->editColumn('total_deductions', function ($row) {
                    $total = $row->store_deductions + $row->individual_deductions + $row->general_deductions;
                    $html = num_format($total);
                    return $html;
                })
                ->editColumn('shares_contribution', function ($row) {
                    $html = num_format($row->shares_contribution);
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
    }

    public function generate_payments(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $tenant_id = auth()->user()->id;
            //Selected Center
            $center_id = request()->center_id;

            $farmers = Farmer::join('collection_centers', 'collection_centers.id', '=', 'farmers.center_id')
                    ->join('banks', 'banks.id', '=', 'farmers.bank_id')
                    ->where('farmers.tenant_id', $tenant_id)
                    ->where('farmers.center_id', $center_id)
                    ->select([
                        'collection_centers.center_name',
                        'banks.bank_name',
                        'farmers.id as farmer_id',
                        'farmers.fname',
                        'farmers.lname',
                        'farmers.farmerID',
                        'farmers.center_id',
                    ])->get();
            return DataTables::of($farmers)
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

                ->addColumn('fullname', function ($row) {
                    return $row->fname.' '.$row->lname.' - '.$row->farmerID;
                })

                ->addColumn('farmer_id', function ($row) {
                    $farmer_id = $row->farmer_id;
                    return  $farmer_id;
                })

                ->addColumn('center_id', function ($row) {
                    $center_id = $row->center_id;
                    return  $center_id;
                })
                
                ->addColumn('total_milk', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                    $pay_period = request()->pay_period;
                    
                    list($year, $month) = explode('-', $pay_period);

                    $total_milk = DB::table('milk_collections')
                                ->where('farmer_id', $farmer_id)
                                ->where('tenant_id', $tenant_id)
                                ->whereYear('collection_date', $year)
                                ->whereMonth('collection_date', $month)
                                ->sum('total') ?? 0;
                               logger($total_milk);
                    return $total_milk;
                })

                ->editColumn('total_store_deductions', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                    $pay_period = request()->pay_period;
                    
                    list($year, $month) = explode('-', $pay_period);
                    $total_sales = DB::table('store_sales')
                                ->where('farmer_id', $farmer_id)
                                ->where('tenant_id', $tenant_id)
                                //1 => milk mode 2 => cash mode
                                ->where('payment_mode', 1)
                                ->whereYear('order_date', $year)
                                ->whereMonth('order_date', $month)
                                ->sum('total_cost') ?? 0;
                    return $total_sales;
    
                })
                ->editColumn('total_individual_deductions', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                    $pay_period = request()->pay_period;
                    
                    list($year, $month) = explode('-', $pay_period);
                
                    $individualDeductions = DB::table('deductions')
                        ->where('tenant_id', $tenant_id)
                        ->where('farmer_id', $farmer_id)
                        ->where('deduction_type', 'individual')
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->sum('amount') ?? 0;
                    return $individualDeductions;
                })                
                ->editColumn('total_general_deductions', function ($row) {
                    $tenant_id = auth()->user()->id;

                    $pay_period = request()->pay_period;
                    
                    list($year, $month) = explode('-', $pay_period);
                
                    $generalDeductions = DB::table('deductions')
                        ->where('tenant_id', $tenant_id)
                        ->where('deduction_type', 'general')
                        ->whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->sum('amount') ?? 0;
                    return $generalDeductions;
                })
                ->editColumn('total_shares', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                
                    // Retrieve the accumulative_amount from share_settings
                    $shareSettings = DB::table('share_settings')
                        ->where([
                            ['tenant_id', '=', $tenant_id],
                            ['is_active', '=', 1],
                        ])
                        ->select('accumulative_amount')
                        ->first();
                
                    // Ensure shareSettings is not null and get the accumulative_amount
                    $accumulativeAmount = $shareSettings ? $shareSettings->accumulative_amount : 0;

                    $totalShares = DB::table('share_contributions')
                        ->where([
                            ['tenant_id', '=', $tenant_id],
                            ['farmer_id', '=', $farmer_id],
                        ])
                        ->sum('share_value') ?? 0;

                    return $totalShares;
                })
                ->editColumn('previous_dues', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
                
                    $total_dues = "0.00";
                    return $total_dues;
                })
                
                         
                ->rawColumns(['action', 'fullname','farmer_id', 'total_milk', 'total_store_deductions', 'total_individual_deductions', 'total_general_deductions', 'total_shares', 'previous_dues'])
                ->make(true);
        }
        return view('companies.payments.generate-payments', compact('centers'));
    }

    public function store_payments(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'center_id' => 'required|integer',
            'milk_rate' => 'required|numeric',
            'bonus_rate' => 'nullable|numeric',
            'pay_period' => 'required|date_format:Y-m',
            'payments' => 'required|array',
            'payments.*.farmer_id' => 'required|integer',
            'payments.*.total_milk' => 'required|numeric',
            'payments.*.store_deductions' => 'required|numeric',
            'payments.*.individual_deductions' => 'required|numeric',
            'payments.*.general_deductions' => 'required|numeric',
            'payments.*.shares_contribution' => 'required|numeric',
            'payments.*.previous_dues' => 'nullable|numeric',
        ]);
    
        if ($validator->fails()) {
            // Log validation errors for debugging
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
        try {
            $tenant_id = auth()->user()->id;
            $user_id = auth()->user()->id;
    
            foreach ($request->payments as $paymentData) {
                $payment = [
                    'tenant_id' => $tenant_id,
                    'farmer_id' => $paymentData['farmer_id'],
                    'center_id' => $request->center_id,
                    'total_milk' => $paymentData['total_milk'],
                    'milk_rate' => $request->milk_rate,
                    'bonus_rate' => $request->bonus_rate,
                    'store_deductions' => $paymentData['store_deductions'],
                    'individual_deductions' => $paymentData['individual_deductions'],
                    'general_deductions' => $paymentData['general_deductions'],
                    'shares_contribution' => $paymentData['shares_contribution'],
                    'previous_dues' => $paymentData['previous_dues'],
                    'generated_by' => $user_id,
                    'pay_period' => $request->pay_period,
                ];
                Payment::create($payment);
            }
    
            DB::commit();
            return response()->json(['message' => 'Payment Generated Added Successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }
    
}
