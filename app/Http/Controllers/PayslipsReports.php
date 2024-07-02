<?php

namespace App\Http\Controllers;

use App\Models\PaySlips;
use App\Models\Employee;
use App\Models\EmployeePayslip;
use App\Models\Allowance;
use App\Models\BenefitsInKind;
use App\Models\NonStatutoryDeduction;
use App\Models\StatutoryDeduction;
use Illuminate\Http\Request;
use App\Models\CompanyProfile;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PayslipsReports extends Controller
{
    public function tier_one(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.basic_salary'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item " href="'.url('payslip-exports/print-tier-one').'"target="_blank" ><i class="fa fa-print m-r-5"></i> Print Tier One</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })   
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('payslip_reports.tier_one');
    }

    public function staff_tier_one(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.basic_salary'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item " href="'.url('payslip-exports/print-tier-one').'"target="_blank" ><i class="fa fa-print m-r-5"></i> Print Tier One</a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })   
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('companies.staff.payslip_reports.tier_one');
    }

    public function tier_two(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.basic_salary'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('payslip_reports.tier_two');
    }

    public function staff_tier_two(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.basic_salary'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('companies.staff.payslip_reports.tier_two');
    }

    public function allowances(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = Allowance::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.allowances'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->allowances, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = auth()->user()->id;

        $allowance = Allowance::where('tenant_id', $tenant_id)->get();

        return view('payslip_reports.allowances',compact('allowance'));
    }

    public function staff_allowances(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = Allowance::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.allowances'                        
                        ])
                        ->get();
            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->allowances, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $allowance = Allowance::where('tenant_id', $tenant_id)->get();

        return view('companies.staff.payslip_reports.allowances',compact('allowance'));
    }

    public function benefits(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = BenefitsInKind::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.benefits'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->benefits, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = auth()->user()->id;

        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();

        return view('payslip_reports.benefits',compact('benefit'));
    }

    public function staff_benefits(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = BenefitsInKind::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.benefits'                        
                        ])
                        ->get();
                       

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->benefits, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $benefit = BenefitsInKind::where('tenant_id',$tenant_id)->get();

        return view('companies.staff.payslip_reports.benefits',compact('benefit'));
    }

    public function statutory(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = StatutoryDeduction::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.statutory_deductions'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->statutory_deductions, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $statutory = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('payslip_reports.statutory_deductions',compact('statutory'));
    }

    public function staff_statutory(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->id;
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = StatutoryDeduction::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.statutory_deductions'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->statutory_deductions, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $statutory = StatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('companies.staff.payslip_reports.statutory_deductions',compact('statutory'));
    }

    public function non_statutory(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = NonStatutoryDeduction::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.nonstatutory_deductions'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->nonstatutory_deductions, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = auth()->user()->id;

        $statutory = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('payslip_reports.nonstatutory_deductions',compact('statutory'));
    }

    public function staff_non_statutory(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $allowance_name = NonStatutoryDeduction::findOrFail($allowance);
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.nonstatutory_deductions'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'value',
                function ($row) use ($allowance) {
                    $result = array_filter(json_decode($row->nonstatutory_deductions, true), function ($item) use ($allowance) {
                        return $item['id'] == $allowance;
                    });
            
                    if (!empty($result)) {
                        $value = num_format(reset($result)['value']);
                        return $value;
                    }
            
                    return 0;
                }
            )

            ->addColumn(
                'allowance_name',
                function ($row) use ($allowance_name) {
                    return $allowance_name->name;
                }
            )
            
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        $statutory = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();

        return view('companies.staff.payslip_reports.nonstatutory_deductions',compact('statutory'));
    }

    public function paye(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item email-report"  data-string="download" data-href="'.url('payslip-exports/email-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-envelope m-r-5"></i> Email Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        return view('payslip_reports.paye');
    }

    public function staff_paye(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item email-report"  data-string="download" data-href="'.url('payslip-exports/email-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-envelope m-r-5"></i> Email Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        return view('companies.staff.payslip_reports.paye');
    }

    public function paye_tax(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        return view('payslip_reports.paye-tax');
    }

    public function staff_paye_tax(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        return view('companies.staff.payslip_reports.paye-tax');
    }
    
    public function bank_net_pay(Request $request){
        if (request()->ajax()) {
            if(session('is_admin') == 1)
            {
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }else{
                $tenant_id = auth()->user()->id;
            }
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.*',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        return view('payslip_reports.bank-net-pay');
    }

    public function staff_bank_net_pay(Request $request){
        if (request()->ajax()) {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            $pay_period = $request->input('pay_period');
            $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.*',
                            'pay_slips.*'                        
                        ])
                        ->get();

            return DataTables::of($report)
            ->addColumn(
                'action',
                function ($row) {

                    $html = '<div class="btn-group">
                    <button type="button" class="badge btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        
                        <a class="dropdown-item print-report"  data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-print m-r-5"></i> Print Payslip
                        </a>
                        <a class="dropdown-item print-report" data-string="download" data-href="'.url('payslip-exports/print-payslip', [$row->id, 'download']).'" target="_blank">
                            <i class="fa fa-download m-r-5"></i> Generate PDF
                        </a>
                    </div>
                  </div>';

                  return $html;
                }
            )
            ->editColumn('basic_salary', function ($row) {
                $html = num_format($row->basic_salary);
                return $html;
            })
            ->editColumn('paye', function ($row) {
                $html = num_format($row->paye);
                return $html;
            })
            ->editColumn(
                'allowances',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->allowances, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->addColumn(
                'tier_one',
                function ($row) {
                    return num_format(0.135*$row->basic_salary);
                }
            )
            ->addColumn(
                'tier_two',
                function ($row) {
                    return num_format(0.05*$row->basic_salary);
                }
            )
            ->editColumn(
                'benefits',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->benefits, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'statutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->statutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )

            ->editColumn(
                'nonstatutory_deductions',
                function ($row) {
                    $total = 0;
                    foreach(json_decode($row->nonstatutory_deductions, true) as $one){
                        $total += $one['value'];
                    }
                    return num_format($total);
                }
            )
            ->editColumn('net_pay', function ($row) {
                $html = num_format($row->net_pay);
                return $html;
            })
              
            ->rawColumns(['action'])
            ->make(true);
        }

        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;

        return view('companies.staff.payslip_reports.bank-net-pay');
    }

}
