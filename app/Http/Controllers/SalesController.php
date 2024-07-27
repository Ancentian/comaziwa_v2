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
use App\Models\StoreCollection;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use PDF;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class SalesController extends Controller
{
    public function index()
    {
        //Sales
        $tenant_id = Auth::user()->id;
        $centers = CollectionCenter::where('tenant_id', $tenant_id)->get();

        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;

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
        return view('companies.sales.index', compact('centers'));
    }

    public function all_transactions()
    {
        $tanant_id = auth()->user()->id;
        $centers = CollectionCenter::where('tenant_id', $tanant_id)->get();
        if (request()->ajax()) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        
            $tenant_id = auth()->user()->id;
            $sales = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
                ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
                ->join('inventories', 'inventories.id', '=', 'store_sales.item_id')
                ->join('categories', 'categories.id', '=', 'store_sales.category_id')
                ->where('store_sales.tenant_id', $tenant_id)
                ->select([
                    'store_sales.transaction_id',
                    'store_sales.order_date',
                    DB::raw('SUM(store_sales.total_cost) as total_cost'),
                    DB::raw('COUNT(store_sales.transaction_id) as item_count'),
                    'collection_centers.center_name',
                    'farmers.farmerID',
                    'farmers.fname',
                    'farmers.lname',
                ])
                ->groupBy('store_sales.transaction_id', 'store_sales.order_date', 'collection_centers.center_name', 'farmers.farmerID', 'farmers.fname', 'farmers.lname');
        
            if (!empty($start_date) && !empty($end_date)) {
                $sales->whereDate('store_sales.order_date', '>=', $start_date);
                $sales->whereDate('store_sales.order_date', '<=', $end_date);
            }
        
            if (!empty(request()->center_id)) {
                $sales->where('store_sales.center_id', '=', request()->center_id);
            }
        
            if (!empty(request()->farmer_id)) {
                $sales->where('store_sales.farmer_id', '=', request()->farmer_id);
            }
        
            return DataTables::of($sales->get())
                ->addColumn('action', function ($row) {
                    $html = '<a class="btn btn-success view-transaction-details" data-transaction-id="' . $row->transaction_id . '" href="#"><i class="fa fa-eye m-r-5"></i></a>
                            <a class="btn btn-info print-invoice" data-transaction-id="' . $row->transaction_id . '">
                                <i class="fa fa-print m-r-5"></i>
                            </a>';
                    return $html;
                })
                ->addColumn('fullname', function ($row) {
                    return $row->farmerID . ' - ' . $row->fname . ' ' . $row->lname;
                })
                ->editColumn('order_date', function ($row) {
                    return format_date($row->order_date);
                })
                ->editColumn('unit_cost', function ($row) {
                    return num_format($row->unit_cost);
                })
                ->editColumn('total_cost', function ($row) {
                    return num_format($row->total_cost);
                })
                ->editColumn('created_on', function ($row) {
                    return format_date($row->created_at);
                })
                ->rawColumns(['action', 'fullname', 'order_date', 'created_on', 'unit_cost', 'total_cost'])
                ->make(true);
        }
        
        return view('companies.sales.all-transactions', compact('centers'));
    }

    public function view_transaction_details($id)
    {
        return view('companies.sales.view-transaction');
    }

    public function transaction_details($id)
    {
        if (request()->ajax()) {
            $tenant_id = auth()->user()->id;
            $details = StoreSale::join('inventories', 'inventories.id', '=', 'store_sales.item_id')
                ->where('store_sales.tenant_id', $tenant_id)
                ->where('store_sales.transaction_id', $id)
                ->select([
                    'store_sales.transaction_id',
                    'store_sales.order_date',
                    'store_sales.unit_cost',
                    'store_sales.qty',
                    'store_sales.total_cost',
                    'inventories.name as item_name',
                ])
                ->get();

            return response()->json($details);
        }

        // If not AJAX request, just return the view
        //return view('companies.sales.view-transaction');
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
            'collected_by' => 'required',
            'collected_on' => '',
            'id_number' => '',
            'phone_number' => '',
            'vehicle_no' => ''
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $transaction_id = substr(mt_rand(1000000, 9999999), 0, 8);
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
                'transaction_id' => $transaction_id
            ]);

            // Update inventory quantity
            $inventory = Inventory::where('id', $item_id)->first();
            if ($inventory) {
                $inventory->quantity -= $quantity;
                $inventory->save();
            }
        }

        $collection = StoreCollection::create([
            'tenant_id' => $tenant_id,
            'transaction_id' => $transaction_id,
            'collected_by' => $request->collected_by,
            'id_number' => $request->id_number,
            'collection_on' => $request->collection_on,
            'vehicle_no' => $request->vehicle_no
        ]);
        return redirect()->back()->with('message', 'Sales added successfully');
    }

    public function print_invoice(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $id = $request->input('transaction_id');
        $items = StoreSale::join('inventories', 'inventories.id', '=', 'store_sales.item_id')
            ->join('categories', 'categories.id', '=', 'store_sales.category_id')
            ->join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
            ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
            ->where('store_sales.transaction_id', $id)
            ->where('store_sales.tenant_id', $tenant_id)
            ->select([
                'store_sales.*',
                'inventories.name as item_name',
                'farmers.fname',
                'farmers.lname',
                'farmers.contact1',
                'collection_centers.center_name',
            ])->get();

        $sale_details = StoreSale::where('transaction_id', $id)
            ->select([
                'store_sales.transaction_id',
                'store_sales.order_date',
            ])->first();

        $farmer = StoreSale::join('farmers', 'farmers.id', '=', 'store_sales.farmer_id')
            ->join('collection_centers', 'collection_centers.id', '=', 'store_sales.center_id')
            ->where('store_sales.transaction_id', $id)
            ->select([
                'farmers.fname',
                'farmers.lname',
                'farmers.contact1',
                'farmers.farmerID',
                'collection_centers.center_name',
            ])->first();
        $company = company()->mycompany();

        $data = [
            'items' => $items,
            'sale_details' => $sale_details,
            'company' => $company,
            'farmer' => $farmer
        ];

        // Generate the PDF
        $pdf = PDF::loadView('companies.sales.print-invoice', $data);
        $pdf->setPaper([0, 0, 204, 650], 'portrait'); // Adjust size for thermal printer

        $uniqueId = time(); 
        $fullname = $farmer->fname."-".$farmer->lname;
        $filename = "{$fullname}-{$id}-{$uniqueId}.pdf";
        $pdfPath = storage_path("app/public/sales_invoice/{$filename}");

        // Save the PDF to storage
        $pdf->save($pdfPath);

        // Return the URL to the generated PDF
        return response()->json(['pdfUrl' => asset("storage/sales_invoice/{$filename}")]);

        //return view('companies.sales.print-invoice', compact('items', 'company', 'farmer', 'sale_details'));
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
