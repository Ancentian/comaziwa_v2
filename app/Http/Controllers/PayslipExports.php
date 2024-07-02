<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaySlips;
use App\Models\Allowance;
use App\Models\BenefitsInKind;
use App\Models\NonStatutoryDeduction;
use App\Models\StatutoryDeduction;
use App\Models\Employee;
use PDF;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PayslipExports extends Controller
{
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
    
    
    public function emailPayslip($id, $action)
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
            
            $build_data = ['name' => $emp_name, 'company' => $company->name,'period' => $pay_period,'download_link' => $pdfUrl,'to_email' => $payslip->email,'to_phone' => $payslip->phone_no];
            $emaildata = \App\Models\TransactionalEmails::buildMsg('sending_payslip', $build_data);
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {       
            return view('reports.print_payslip', compact('payslip', 'pay_period', 'company','action'));
        }
    }
    
    
    public function bulkprintPayslip(Request $request)
    {
        // Set maximum PHP execution time to unlimited
        ini_set('max_execution_time', 0);
        
        // Set the memory limit to unlimited
        ini_set('memory_limit', -1);


        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id',$tenant_id)->get();
        
        $tempname = company()->mycompany()->id."#".'tmp_'.date('MY',strtotime($request->pay_period))."/";
        $tempzip = company()->mycompany()->id."#".'payslips_'.date('MY',strtotime($request->pay_period)).".gz";
        
        $folderPath = storage_path('app/public/bulk_exports/' . $tempname);
        $zippath = storage_path('app/public/bulk_exports/' . $tempzip);
        $exportPath = storage_path('app/public/bulk_exports/');
        
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }
        
        if (File::exists($zippath)) {
            File::delete($zippath); // Corrected function name
        }
        
        File::makeDirectory($folderPath);
        
        $readmeContent = "If this folder is empty, then no Payslips exists for the selected month. First generate them under employees page then try printing again.";
        $readmeFilePath = $folderPath . '/README.txt';
        
        File::put($readmeFilePath, $readmeContent);
        
        foreach($employees as $employee){
            $payslip = PaySlips::join('employees', 'employees.id', '=', 'pay_slips.employee_id')
                ->where('pay_slips.employee_id', $employee->id)
                ->where('pay_slips.pay_period',$request->pay_period)
                ->select([
                    'employees.*',
                    'pay_slips.*'
                ])
                ->first();
            
            if(!empty($payslip)){
                $emp_name = $payslip->name;
                $pay_period = date('M,Y', strtotime($payslip->pay_period));
        
                $company = company()->mycompany();
                $nethistory = PaySlips::where('employee_id',$payslip->employee_id)
                                ->where('pay_period', 'LIKE', date('Y', strtotime($payslip->pay_period)) . '-%')
                                ->sum('net_pay');
                                
                $data = [
                    'payslip' => $payslip,
                    'company' => $company,
                    'pay_period' => $pay_period,
                    'nethistory' => $nethistory
                ];
         
                $pdf = PDF::loadView('reports.print_payslip', $data);
                $pdf->setPaper('a4', 'portrait');
                $filename = $emp_name.date('MY',strtotime($payslip->pay_period)) . "Payslip.pdf";
                $pdf->save(storage_path('app/public/bulk_exports/'. $tempname . $filename)); // Save the PDF to a storage location
            }
            
            
        }
        
        $zip = new \ZipArchive();
    
        if ($zip->open($zippath, \ZipArchive::CREATE) !== true) {
            throw new \RuntimeException('Cannot open ' . $filePath);
        }
    
        $this->addContent($zip, $folderPath);
        
        $pdfUrl = url('payslip-exports/download-pdfs',[$tempzip,1]);
        return Response::json(['pdfUrl' => $pdfUrl]);
        
    }
    
     public function bulkemailPayslip(Request $request)
    {
        // Set maximum PHP execution time to unlimited
        ini_set('max_execution_time', 0);
        
        // Set the memory limit to unlimited
        ini_set('memory_limit', -1);


        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $employees = Employee::where('tenant_id', $tenant_id)->get();
        
        foreach($employees as $employee){
            $payslip = PaySlips::join('employees', 'employees.id', '=', 'pay_slips.employee_id')
                ->where('pay_slips.employee_id', $employee->id)
                ->where('pay_slips.pay_period',$request->pay_period)
                ->select([
                    'employees.*',
                    'pay_slips.*'
                ])
                ->first();
            
            if(!empty($payslip)){
                $emp_name = $payslip->name;
                $pay_period = date('M,Y', strtotime($payslip->pay_period));
        
                $company = company()->mycompany();
                $nethistory = PaySlips::where('employee_id',$payslip->employee_id)
                                ->where('pay_period', 'LIKE', date('Y', strtotime($payslip->pay_period)) . '-%')
                                ->sum('net_pay');
                $data = [
                    'payslip' => $payslip,
                    'company' => $company,
                    'pay_period' => $pay_period,
                    'nethistory' => $nethistory
                ];
         
                $pdf = PDF::loadView('reports.print_payslip', $data);
                $pdf->setPaper('a4', 'portrait');
                $filename = $payslip->id."#".$emp_name.date('MY',strtotime($payslip->pay_period)) . "Payslip.pdf";
                $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
                
                // send emails here
                $pdfUrl = url('payslip-exports/download-pdfs',[$filename]);
                
                $build_data = ['name' => $emp_name, 'company' => $company->name,'period' => $pay_period,'download_link' => $pdfUrl,'to_email' => $payslip->email,'to_phone' => $payslip->phone_no];
                $emaildata = \App\Models\TransactionalEmails::buildMsg('sending_payslip', $build_data);
            }
            
            
        }
        
        
        return Response::json(['pdfUrl' => 'True']);
        
    }
    
    
    private function addContent(\ZipArchive $zip, string $path)
    {
        /** @var SplFileInfo[] $files */
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::FOLLOW_SYMLINKS
            ),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    
        while ($iterator->valid()) {
            if (!$iterator->isDot()) {
                $filePath = $iterator->getPathName();
                $relativePath = substr($filePath, strlen($path));
    
                if (!$iterator->isDir()) {
                    $zip->addFile($filePath, $relativePath);
                } else {
                    if ($relativePath !== false) {
                        $zip->addEmptyDir($relativePath);
                    }
                }
            }
            $iterator->next();
        }
    }



    public function paye($id){
        $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                    ->where('pay_slips.id', $id)
                    ->select([
                        'employees.name',
                        'employees.ssn',
                        'employees.account_no',
                        'employees.bank_name',
                        'employees.position',
                        'pay_slips.*'                        
                    ])
                    ->first();
                    
        return view('reports.payslip_reports',compact('report'));
    }

    public function print_tierOne(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('pay_period');
        $action = $request->input('action');
        $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                        ->where('pay_slips.tenant_id', $tenant_id)
                        ->where('pay_slips.pay_period',$pay_period)
                        ->select([
                            'employees.name',
                            'employees.ssn',
                            'employees.position',
                            'pay_slips.*',                 
                        ])->get();
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company
        ];

        
        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_tier_one', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $company_name . "-" . date('MY',strtotime($period)) . "TierOneReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            //return $pdf->stream($company_name ." - ".$period." Tier One" . '.pdf');
            return view('reports.print_tier_one', compact('report', 'pay_period', 'company'));
        }
    }

    public function print_tierTwo(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('pay_period');
        $action = $request->input('action');
        $report = PaySlips::join('employees', 'employees.id', '=', 'pay_slips.employee_id')
            ->where('pay_slips.tenant_id', $tenant_id)
            ->where('pay_slips.pay_period', $pay_period)
            ->select([
                'employees.name',
                'employees.ssn',
                'employees.position',
                'pay_slips.*',                 
            ])->get();
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company
        ];

        

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_tier_two', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $company_name . "-" . date('MY',strtotime($period)) . "TierTwoReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            //return $pdf->stream($company_name ." - ".$period." Tier Two" . '.pdf');
            return view('reports.print_tier_two', compact('report', 'pay_period', 'company'));
            
        }
    }
    


    public function print_paye_tax(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('pay_period');
        $action = $request->input('action');
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
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
        ];

        

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_paye_tax', $data);
            $pdf->setPaper('a4', 'landscape');
            $filename = $company_name . "-" . date('MY',strtotime($period)) . "PayeeTaxReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {
            return view('reports.print_paye_tax', compact('report', 'pay_period', 'company'));
        }
        
    }
    
    public function print_bank_net_pay(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('pay_period');
        $action = $request->input('action');
        $report = PaySlips::join('employees','employees.id', '=' ,'pay_slips.employee_id')
                    ->where('pay_slips.tenant_id', $tenant_id)
                    ->where('pay_slips.pay_period',$pay_period)
                    ->select([
                        'employees.*',
                        'pay_slips.*'                        
                    ])
                    ->get();
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
        ];

        

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_bank_net_pay', $data);
            $pdf->setPaper('a4', 'landscape');
            $filename = $company_name . "-" . date('MY',strtotime($period)) . "PayeeTaxReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {
            return view('reports.print_bank_net_pay', compact('report', 'pay_period', 'company'));
        }
        
    }

    public function print_allowances(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
            $pay_period = $request->input('pay_period');
            $allowance = $request->input('allowance');
            $action = $request->input('action');
            $allowance_name = Allowance::findOrFail($allowance);
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
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
            'allowance' => $allowance,
            'allowance_name' => $allowance_name
        ];

        
        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_allowances', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $allowance_name->name . "-" . date('MY',strtotime($period)) . "Report.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            return view('reports.print_allowances', compact('report', 'pay_period', 'company','allowance_name','allowance'));
            //return $pdf->stream($company_name ." - ".$period." Allowances" . '.pdf');
        }
    }

    public function print_benefits(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
            $pay_period = $request->input('pay_period');
            $benefit = $request->input('benefit');
            $action = $request->input('action');
            $allowance_name = BenefitsInKind::findOrFail($benefit);
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
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
            'benefit' => $benefit,
            'allowance_name' => $allowance_name
        ];

        
        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_benefits', $data);
            $pdf->setPaper('a4', 'landscape');
            $filename = $allowance_name->name . "-" . date('MY',strtotime($period)) . "Report.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            return view('reports.print_benefits', compact('report', 'pay_period', 'company','benefit','allowance_name'));
            //return $pdf->stream($company_name ." - ".$period." Benefits" . '.pdf');
        }
    }

    public function print_statutory(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('pay_period');
        $statutory = $request->input('statutory');
        $action = $request->input('action');
        $allowance_name = StatutoryDeduction::findOrFail($statutory);
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
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
            'statutory' => $statutory,
            'allowance_name' => $allowance_name
        ];

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_statutory', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $allowance_name->name . "-" . date('MY',strtotime($period)) . "Report.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);
        } elseif ($action === 'print') {
            return view('reports.print_statutory', compact('report', 'pay_period', 'company','statutory','allowance_name'));
            //return $pdf->stream($company_name ." - ".$period." Statutory Deductions" . '.pdf');
        }
    }

    public function print_non_statutory(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
            $pay_period = $request->input('pay_period');
            $non_ststutory = $request->input('non_ststutory');
            $action = $request->input('action');
            $allowance_name = NonStatutoryDeduction::findOrFail($non_ststutory);
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
        $statutory = NonStatutoryDeduction::where('tenant_id',$tenant_id)->get();
        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
            'non_ststutory' => $non_ststutory,
            'allowance_name' => $allowance_name
        ];

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_non_statutory', $data);
            $pdf->setPaper('a4', 'portrait');
            $filename = $allowance_name->name . "-" . date('MY',strtotime($period)) . "Report.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {
            return view('reports.print_non_statutory', compact('report', 'pay_period', 'company','non_ststutory','allowance_name'));
            //return $pdf->stream($company_name ." - ".$period." Non Statutory Deductions" . '.pdf');
        }
    }

    public function generate_payee_report(Request $request)
    {
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }
        $pay_period = $request->input('paye_period');
        $action = $request->input('action');
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
        if(session('is_admin') == 1)
        {
            $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
        }else{
            $tenant_id = auth()->user()->id;
        }

        $company = company()->mycompany();

        $company_name = $company->id."#";
        $period = date('M,Y', strtotime($pay_period));
        $data = [
            'report' => $report,
            'pay_period' => $pay_period,
            'company' => $company,
        ];

        

        if ($action === 'download') {
            $pdf = PDF::loadView('reports.print_payee_report', $data);
            $pdf->setPaper('a4', 'landscape');
            $filename = $company_name . "-" . date('MY',strtotime($period)) . "GeneralPayrollReport.pdf";
            $pdf->save(storage_path('app/public/exports/' . $filename)); // Save the PDF to a storage location
            $pdfUrl = url('payslip-exports/download-pdfs',[$filename]); // Get the URL of the saved PDF
            
            return Response::json(['pdfUrl' => $pdfUrl]);

        } elseif ($action === 'print') {
            return view('reports.print_payee_report', compact('report', 'pay_period', 'company'));
        }

    }

    public function downloadPdfExports($file,$is_zip = null)
    {   
        if(!empty($is_zip)){
            $filepath = Storage::path('public/bulk_exports/') . $file;
        }else{
            $filepath = Storage::path('public/exports/') . $file;
        }
        
        
        $headers = array('Content-Type: application/json');
        $response = response()->download($filepath,$file,$headers);
        
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        return $response;
    }
}
