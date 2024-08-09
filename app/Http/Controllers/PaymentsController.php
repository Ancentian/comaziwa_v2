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
use Illuminate\Support\Facades\Auth;
use Excel;
use PDF;

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
                    ])->orderBy('payments.id', 'desc');

            if(!empty(request()->pay_period)){
                $payments->where('payments.pay_period','=',request()->pay_period);
            }

            if(!empty(request()->center_id)){
                $payments->where('payments.center_id','=',request()->center_id);
            }

            if(!empty(request()->farmer_id)){
                $payments->where('payments.farmer_id','=',request()->farmer_id);
            }

            if(!empty(request()->bank_id)){
                $payments->where('farmers.bank_id','=',request()->bank_id);
            }

            return DataTables::of($payments->get())
                ->addColumn('action', function ($row) {
                    $html = '<button type="button" class="btn btn-info print-payslip " data-farmer-id="' . $row->farmer_id . '" data-record-id="' . $row->id . '" title="Print Invoice"> <i><i class="fa fa-print"></i></i></button>';
                    return $html;
                })

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
    }

    public function bank_list()
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        $banks = Bank::where('tenant_id', $tenant_id)->get();
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
                    DB::raw('((payments.total_milk * payments.milk_rate) - (payments.store_deductions + payments.individual_deductions + payments.general_deductions + payments.shares_contribution + payments.previous_dues)) as net_pay')
                ])
                ->orderBy('payments.id', 'desc');
        
            if(!empty(request()->pay_period)){
                $payments->where('payments.pay_period','=',request()->pay_period);
            }
        
            if(!empty(request()->center_id)){
                $payments->where('payments.center_id','=',request()->center_id);
            }
        
            if(!empty(request()->farmer_id)){
                $payments->where('payments.farmer_id','=',request()->farmer_id);
            }
        
            if(!empty(request()->bank_id)){
                $payments->where('farmers.bank_id','=',request()->bank_id);
            }
        
            // Filter payments where net_pay is greater than 0
            $payments->having('net_pay', '>', 0);
        
            return DataTables::of($payments->get())
                ->addColumn('action', function ($row) {
                    $html = '<button type="button" class="btn btn-info btn-sm print-payslip" data-farmer-id="' . $row->farmer_id . '" data-record-id="' . $row->id . '" title="Print Invoice"> <i class="fa fa-print"></i></button>';
                    return $html;
                })
                ->addColumn('code', function ($row) {
                    $html = $row->farmerID;
                    return $html;
                })
                ->addColumn('fullname', function ($row) {
                    return  $row->fname . ' ' . $row->lname;
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

                ->addColumn('account_no', function ($row) {
                    $tenant_id = auth()->user()->id;
                    $farmer_id = $row->farmer_id;
        
                    $bank = DB::table('farmers')
                        ->where('farmers.id', $farmer_id)
                        ->where('farmers.tenant_id', $tenant_id)
                        ->select('acc_number')
                        ->first();
        
                    return $bank ? $bank->acc_number : 'N/A';
                })

                ->editColumn('gross_pay', function ($row) {
                    $gross = $row->total_milk * $row->milk_rate;
                    $html = num_format($gross);
                    return $html;
                })
                ->editColumn('net_pay', function ($row) {
                    $html = num_format($row->net_pay);
                    return $html;
                })
                ->rawColumns(['action', 'fullname', 'total_milk'])
                ->make(true);
        }        
        return view('companies.payments.bank-list', compact('banks', 'centers'));
    }

    public function generate_payments(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $tenant_id = auth()->user()->id;
            // Selected Center
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

            // Add the total_milk calculation for each farmer
            foreach ($farmers as $farmer) {
                $tenant_id = auth()->user()->id;
                $farmer_id = $farmer->farmer_id;
                $pay_period = request()->pay_period;

                list($year, $month) = explode('-', $pay_period);

                $farmer->total_milk = DB::table('milk_collections')
                                    ->where('farmer_id', $farmer_id)
                                    ->where('tenant_id', $tenant_id)
                                    ->whereYear('collection_date', $year)
                                    ->whereMonth('collection_date', $month)
                                    ->where('payment_status', 0)
                                    ->sum('total') ?? 0;
            }

            // Filter farmers with total_milk greater than 0
            $filteredFarmers = $farmers->filter(function ($farmer) {
                return $farmer->total_milk > 0;
            });

            return DataTables::of($filteredFarmers)
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
                    return $row->total_milk;
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
        
            $share_settings = ShareSetting::where('tenant_id', $tenant_id)
                        ->where('is_active', 1)
                        ->select(['deduction_amount', 'accumulative_amount'])
                        ->first();
        
            if (!$share_settings) {
                throw new \Exception('Share settings not found');
            }
        
            foreach ($request->payments as $paymentData) {
                // Fetch total contribution so far for the specific farmer
            $total_contributed = ShareContribution::where('tenant_id', $tenant_id)
                ->where('farmer_id', $paymentData['farmer_id'])
                ->select([
                    DB::raw('SUM(share_value) as total_contributed'),
                ])
                ->first()->total_contributed;

                // Calculate the remaining amount needed to reach the accumulative target
                $remaining_amount = $share_settings->accumulative_amount - $total_contributed;

                // Determine the deduction amount based on conditions
                if ($total_contributed >= $share_settings->accumulative_amount) {
                    $deduction_amount = 0; // No deduction if target is met
                } elseif ($remaining_amount > 0) {
                    $deduction_amount = min($share_settings->deduction_amount, $remaining_amount); // Deduct up to the remaining amount needed
                } else {
                    $deduction_amount = $share_settings->deduction_amount; // Normal deduction if no other conditions are met
                }
        
                $payment = [
                    'tenant_id' => $tenant_id,
                    'farmer_id' => $paymentData['farmer_id'],
                    'center_id' => $request->center_id,
                    'total_milk' => $paymentData['total_milk'],
                    'milk_rate' => $request->milk_rate,
                    'gross_pay' => $paymentData['total_milk'] * $request->milk_rate,
                    'bonus_rate' => $request->bonus_rate,
                    'store_deductions' => $paymentData['store_deductions'],
                    'individual_deductions' => $paymentData['individual_deductions'],
                    'general_deductions' => $paymentData['general_deductions'],
                    'shares_contribution' => $deduction_amount,
                    'previous_dues' => $paymentData['previous_dues'],
                    'generated_by' => $user_id,
                    'pay_period' => $request->pay_period,
                ];
        
                $mode_of_contribution = "milk";
        
                if ($deduction_amount > 0) {
                    $shares_contribution = [
                        'tenant_id' => $tenant_id,
                        'farmer_id' => $paymentData['farmer_id'],
                        'center_id' => $request->center_id,
                        'share_value' => $deduction_amount,
                        'issue_date' => date('Y-m-d'),
                        'mode_of_contribution' => $mode_of_contribution,
                    ];
                ShareContribution::create($shares_contribution);
                }
        
                // Update Milk Payment Status
                $pay_period = $request->pay_period;
                list($year, $month) = explode('-', $pay_period);
                $milkcollection = MilkCollection::where([
                        ['tenant_id', '=', $tenant_id],
                        ['farmer_id', '=', $paymentData['farmer_id']],
                        ['center_id', '=', $request->center_id],
                    ])
                    ->whereYear('collection_date', $year)
                    ->whereMonth('collection_date', $month)
                    ->update(['payment_status' => 1]);
        
                Payment::create($payment);
                //ShareContribution::create($shares_contribution);
            }
        
            DB::commit();
            return response()->json(['message' => 'Payment Generated Added Successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            
            DB::rollback();
            return response()->json(['message' => 'Data saving failed. Please try again.'], 500);
        }
    }

    // public function print_payslip(Request $request)
    // {
    //     $tenant_id = auth()->user()->id;
    //     $pay_period = $request->input('pay_period');
    //     $farmer_id = $request->input('farmer_id');

    //     // Extract year and month from pay period
    //     list($year, $month) = explode('-', $pay_period);

    //     // Retrieve store sale items for the given farmer and pay period
    //     $items = StoreSale::join('inventories', 'inventories.id', '=', 'store_sales.item_id')
    //         ->join('categories', 'categories.id', '=', 'store_sales.category_id')
    //         ->join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
    //         ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
    //         ->where('store_sales.tenant_id', $tenant_id)
    //         ->where('store_sales.farmer_id', $farmer_id)
    //         ->whereYear('store_sales.order_date', $year)
    //         ->whereMonth('store_sales.order_date', $month)
    //         ->select([
    //             'store_sales.*',
    //             'inventories.name as item_name',
    //             'collection_centers.center_name',
    //         ])
    //         ->get();

    //     // Retrieve individual deductions for the given farmer and pay period
    //     $individual_deductions = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
    //         ->join('farmers', 'farmers.id', '=', 'deductions.farmer_id')
    //         ->where('deductions.tenant_id', $tenant_id)
    //         ->where('deductions.farmer_id', $farmer_id)
    //         ->where('deductions.deduction_type', 'individual')
    //         ->whereYear('deductions.date', $year)
    //         ->whereMonth('deductions.date', $month)
    //         ->select([
    //             'deductions.*',
    //             'deduction_types.name as deduction_name',
    //         ])
    //         ->get();

    //     // Retrieve general deductions for the tenant
    //     $general_deductions = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
    //         ->where('deductions.tenant_id', $tenant_id)
    //         ->where('deductions.deduction_type', 'general')
    //         ->whereYear('deductions.date', $year)
    //         ->whereMonth('deductions.date', $month)
    //         ->select([
    //             'deductions.*',
    //             'deduction_types.name as deduction_name',
    //         ])
    //         ->get();

    //     // Retrieve payment information for the given farmer and pay period
    //     $payment = Payment::join('farmers', 'farmers.id', '=', 'payments.farmer_id')
    //         ->join('collection_centers', 'collection_centers.id', '=', 'payments.center_id')
    //         ->where('payments.tenant_id', $tenant_id)
    //         ->where('payments.pay_period', $pay_period)
    //         ->where('payments.farmer_id', $farmer_id)
    //         ->select([
    //             'payments.*',
    //             'farmers.fname',
    //             'farmers.lname',
    //             'farmers.farmerID',
    //             'farmers.contact1',
    //             'collection_centers.center_name',
    //         ])->first();

    //     // Prepare data for the view
    //     $data = [
    //         'items' => $items,
    //         'individuals' => $individual_deductions,
    //         'generals' => $general_deductions,
    //         'payments' => $payment
    //     ];

    //     $company = company()->mycompany();
    //     //logger($payment);
    //     $pdf = PDF::loadView('reports.print_payslip', $data);
    //     $pdf->setPaper('a4', 'portrait');
    //     return Response::json(['pdfUrl' => $pdfUrl]);
    //     //return view('companies.payments.print-payslip', compact('company', 'data'));
    // }

    public function print_payslip(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $pay_period = $request->input('pay_period');
        $farmer_id = $request->input('farmer_id');
        $record_id = $request->input('record_id');

        // Extract year and month from pay period
        list($year, $month) = explode('-', $pay_period);

        // Retrieve store sale items for the given farmer and pay period
        $items = StoreSale::join('inventories', 'inventories.id', '=', 'store_sales.item_id')
            ->join('categories', 'categories.id', '=', 'store_sales.category_id')
            ->join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
            ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
            ->where('store_sales.tenant_id', $tenant_id)
            ->where('store_sales.farmer_id', $farmer_id)
            ->whereYear('store_sales.order_date', $year)
            ->whereMonth('store_sales.order_date', $month)
            ->select([
                'store_sales.*',
                'inventories.name as item_name',
                'collection_centers.center_name',
            ])
            ->get();

        // Retrieve individual deductions for the given farmer and pay period
        $individual_deductions = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
            ->join('farmers', 'farmers.id', '=', 'deductions.farmer_id')
            ->where('deductions.tenant_id', $tenant_id)
            ->where('deductions.farmer_id', $farmer_id)
            ->where('deductions.deduction_type', 'individual')
            ->whereYear('deductions.date', $year)
            ->whereMonth('deductions.date', $month)
            ->select([
                'deductions.*',
                'deduction_types.name as deduction_name',
            ])
            ->get();

        // Retrieve general deductions for the tenant
        $general_deductions = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
            ->where('deductions.tenant_id', $tenant_id)
            ->where('deductions.deduction_type', 'general')
            ->whereYear('deductions.date', $year)
            ->whereMonth('deductions.date', $month)
            ->select([
                'deductions.*',
                'deduction_types.name as deduction_name',
            ])
            ->get();

        // Retrieve payment information for the given farmer and pay period
        $payment = Payment::join('farmers', 'farmers.id', '=', 'payments.farmer_id')
            ->join('collection_centers', 'collection_centers.id', '=', 'payments.center_id')
            ->where('payments.tenant_id', $tenant_id)
            ->where('payments.pay_period', $pay_period)
            ->where('payments.farmer_id', $farmer_id)
            ->where('payments.id', $record_id)
            ->select([
                'payments.*',
                'farmers.fname',
                'farmers.lname',
                'farmers.farmerID',
                'farmers.contact1',
                'collection_centers.center_name',
            ])->first();
        $shares = ShareContribution::join('farmers', 'farmers.id', '=', 'share_contributions.farmer_id')
                ->where('share_contributions.tenant_id', $tenant_id)
                ->where('share_contributions.farmer_id', $farmer_id)
                ->select([
                    DB::raw('SUM(share_contributions.share_value) as total_shares'),
                ])->first();
        $company = company()->mycompany();
        // Prepare data for the view
        $data = [
            'items' => $items,
            'individuals' => $individual_deductions,
            'generals' => $general_deductions,
            'payments' => $payment,
            'company' => $company,
            'shares' => $shares
        ];

        
        try {
        // Ensure the DomPDF public path configuration is correct
        config(['dompdf.public_path' => '/home/cowangoo/public_html/merucomaziwa.co.ke/storage']);
    
        // Load the view into PDF
        $pdf = PDF::loadView('companies.payments.print-payslip', $data);
        $pdf->setPaper([0, 0, 204, 650], 'portrait'); // Adjust size for thermal printer
    
        $uniqueId = time(); 
        $fullname = $payment->fname . "-" . $payment->lname;
        $filename = "{$fullname}-{$pay_period}-{$uniqueId}.pdf";
        $pdfPath = storage_path("app/public/payslips/{$filename}");
    
        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0755, true);
        }
    
            $pdf->save($pdfPath);
            $pdfUrl = asset("storage/payslips/{$filename}");
        
            return response()->json(['pdfUrl' => $pdfUrl]);
        } catch (\Exception $e) {
        return response()->json(['error' => 'Error generating PDF. Please check logs for details.'], 500);
    }
        

    }

    public function printPayslip($id, $action)
    {
        $payslip = PaySlips::join('employees', 'employees.id', '=', 'pay_slips.employee_id')
            ->where('pay_slips.id', $id)
            ->select([
                'employees.*',
                'pay_slips.*',
            ])
            ->first();

        $emp_name = $payslip->name;
        $pay_period = date('M,Y', strtotime($payslip->pay_period));
        
        $nethistory = PaySlips::where('employee_id',$payslip->employee_id)
                                ->where('pay_period', 'LIKE', date('Y', strtotime($payslip->pay_period)) . '-%')
                                ->sum('net_pay');
        
        $company = company()->mycompany();
        $data = [
            'payslip' => $payslip,
            'company' => $company,
            'pay_period' => $pay_period,
            'nethistory' => $nethistory
        ];
 
        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_payslip', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $payslip->id."#".$emp_name.date('MY',strtotime($payslip->pay_period)) . "Payslip.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {       
            return view('reports.print_payslip', compact('payslip', 'pay_period', 'company','action'));
        }
    }

}
