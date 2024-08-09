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
use App\Models\Deduction;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\ShareContribution;
use App\Models\ShareSetting;
use App\Models\AccountTransaction;
use App\Models\StoreCollection;
use App\Models\MilkConsumption;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Excel;

class AccountingController extends Controller
{
    public function index()
    {
        return view('companies.accounting.index');
    }

    public function balance_sheet()
    {
        return view('companies.accounting.balance-sheet');
    }

    public function balance_sheet_data(Request $request)
    {
        $tenant_id = auth()->user()->id;
        $pay_period = $request->input('pay_period');

        // Extract year and month from pay period
        list($year, $month) = explode('-', $pay_period);

        // Retrieve store sale items for the given farmer and pay period
        $store_sales = StoreSale::join('inventories', 'inventories.id', '=', 'store_sales.item_id')
            ->join('categories', 'categories.id', '=', 'store_sales.category_id')
            ->where('store_sales.tenant_id', $tenant_id)
            ->whereYear('store_sales.order_date', $year)
            ->whereMonth('store_sales.order_date', $month)
            ->select([
                DB::raw('SUM(store_sales.total_cost) as total_cost'),
            ])->first();

        // Retrieve individual deductions for the given farmer and pay period
        $deductions = Deduction::join('deduction_types', 'deduction_types.id', '=', 'deductions.deduction_id')
            ->where('deductions.tenant_id', $tenant_id)
            ->whereYear('deductions.date', $year)
            ->whereMonth('deductions.date', $month)
            ->select([
                DB::raw('SUM(CASE WHEN deductions.deduction_type = "individual" THEN deductions.amount ELSE 0 END) as total_individual_amount'),
                DB::raw('SUM(CASE WHEN deductions.deduction_type = "general" THEN deductions.amount ELSE 0 END) as total_general_amount'),
                DB::raw('SUM(deductions.amount) as total_deductions'),
            ])
            ->groupBy('deductions.deduction_type')
            ->first();

        //Consumers
        $consumers =  MilkConsumption::join('consumer_categories', 'consumer_categories.id', '=', 'milk_consumptions.category_id')
                ->where('milk_consumptions.tenant_id', $tenant_id)
                ->whereYear('milk_consumptions.date', $year)
                ->whereMonth('milk_consumptions.date', $month)
                ->select([
                    'consumer_categories.name as category_name',
                    DB::raw('SUM(milk_consumptions.total_cost) as total_consumption'),
                ])
                ->groupBy('milk_consumptions.category_id')
                ->get();

        // Retrieve payment information for the given farmer and pay period
        $payment = Payment::where('payments.tenant_id', $tenant_id)
            ->where('payments.pay_period', $pay_period)
            ->select([
                DB::raw('SUM(payments.gross_pay) as total_gross_pay'),
                DB::raw('SUM(payments.store_deductions) as total_store_deductions'),
                DB::raw('SUM(payments.individual_deductions) as total_individual_deductions'),
                DB::raw('SUM(payments.general_deductions) as total_general_deductions'),
            ])->first();
        $company = company()->mycompany();
        // Prepare data for the view
        $data = [
            'items' => $store_sales,
            'deductions' => $deductions,
            'payments' => $payment,
            'company' => $company,
            'consumers' => $consumers
        ];
        // logger($consumers);
        return response()->json($data);
    }

    public function profit_and_loss()
    {
        return view('companies.accounting.profit-and-loss');
    }

    public function accounting_reports()
    {
        return view('companies.accounting.accounting-reports');
    }

    public function income_statement()
    {
        return view('companies.accounting.income-statement');
    }
}
