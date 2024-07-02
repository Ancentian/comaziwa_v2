@php
    use App\Models\EmployeePayslip;
    $total_allowance = 0;
    $total_benefit = 0;
    $total_stat = 0;
    $total_nonstat = 0;
@endphp
<!DOCTYPE html>
<html>
<head>	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> 
    
  <style>
    html, body {
            margin: 10;
            padding: 0;
            font-size: 12px;
    }

    .table {
      border-spacing: 0;
    }

    .background-danger {
        background-color: #f8d7da;
        -webkit-print-color-adjust: exact !important;
    }

    table {
    border-collapse: collapse;
    }

    table td, table th {
    border: none;
    }
    

    @page { size: A4 portrait; 
        margin: 0 !important;
        padding: 0 !important; }
    body { margin: 0px !important; }
  </style>
  
</head>
<body>
  <div class="container">
    <div class="row">
            <div class="col-sm-12 ">
                <table class="table table-striped custom-table"  id="">
                    <thead>
                        <tr>
                            <th colspan="6">
                                @include('layout.company-header')
                                <p class="text-center">
                                    <h5 class="text-center">Salary Slip - {{date('M Y',strtotime($payslip->pay_period))}}</h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>
                            <th>Employee Name</th>
                            <th>:</th>
                            <th>{{$payslip->name}} </th>
                            <th>Social Security No.</th>
                            <th>:</th>
                            <th> {{$payslip->ssn}}</th>  
                        </tr>
                        <tr>
                            <th>Employee No</th>
                            <th>:</th>
                            <th>{{$payslip->staff_no}} </th>
                            <th>Department</th>
                            <th>:</th>
                            <th>Ghana</th>
                        </tr>
                        <tr>  
                            <th>Job Title </th>
                            <th>:</th>
                            <th> {{$payslip->position}}</th>
                            <th>Annual Salary FY23</th>
                            <th>:</th>
                            <th>{{@num_format($payslip->basic_salary*12)}}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-sm-12 ">
                <table class="table table-striped custom-table"  id="">
                    <thead>
                        <tr>
                            <th>
                                <table class="table table-striped" style="width: 100%" >
                                    <thead>
                                        <tr bgcolor="#f8d7da">
                                            <th><strong>Earnings</strong></th>
                                            <th>:</th>
                                            <th><strong>Amount</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Monthly Basic Salary</td>
                                            <td>:</td>
                                            <td>{{@num_format($payslip->basic_salary)}}</td>
                                        </tr>
                                        @foreach (json_decode($payslip->allowances,true) as $item)                                          
                                            @if(!empty($item))
                                            @php
                                                $allowance = \App\Models\Allowance::find($item['id']);
                                                $perc = null;
                                                if(!empty($allowance) && $allowance->type == 'percentage'){
                                                    $perc = $allowance->value;
                                                }
                                            @endphp
                                            @php $total_allowance += $item['value'] @endphp  
                                                <tr >
                                                    <td>{{$item['name']}} @if(!empty($perc)) ({{$perc}}%)  @endif</td>
                                                    <td>:</td>
                                                    <td>{{@num_format($item['value'])}}</td>
                                                </tr>
                                        @endif
                                        @endforeach
            
                                        @foreach (json_decode($payslip->benefits,true) as $item)                                            
                                            @if(!empty($item))
                                            @php
                                                $allowance = \App\Models\BenefitsInKind::find($item['id']);
                                                $perc = null;
                                                if(!empty($allowance) && $allowance->type == 'percentage'){
                                                    $perc = $allowance->value;
                                                }
                                            @endphp
                                            @php $total_benefit += $item['value'] @endphp  
                                                <tr >
                                                    <td>{{$item['name']}} @if(!empty($perc)) ({{$perc}}%)  @endif</td>
                                                    <td>:</td>
                                                    <td>{{@num_format($item['value'])}}</td>
                                                </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                        <th>{{@num_format($payslip->basic_salary + $total_allowance + $total_benefit)}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </th>  
                            <th style="vertical-align: top;">
                                <table class="table table-striped" style="width: 100%" >
                                    <thead>
                                        <tr class="table background-danger">
                                            <th><strong>Deductions</strong></th>
                                            <th>:</th>
                                            <th><strong>Amount</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach (json_decode($payslip->statutory_deductions,true) as $item)            
                                            @if(!empty($item))
                                            @php
                                                $allowance = \App\Models\StatutoryDeduction::find($item['id']);
                                                $perc = null;
                                                if(!empty($allowance) && $allowance->type == 'percentage'){
                                                    $perc = $allowance->value;
                                                }
                                            @endphp
                                            @php $total_stat += $item['value'] @endphp  
                                                <tr >
                                                    <td>{{$item['name']}} @if(!empty($perc)) ({{$perc}}%)  @endif</td>
                                                    <td>:</td>
                                                    <td>{{@num_format($item['value'])}}</td>
                                                </tr>
                                        @endif
                                        @endforeach
            
                                        @foreach (json_decode($payslip->nonstatutory_deductions,true) as $item)            
                                            @if(!empty($item))
                                            @php
                                                $allowance = \App\Models\NonStatutotyDeduction::find($item['id']);
                                                $perc = null;
                                                if(!empty($allowance) && $allowance->type == 'percentage'){
                                                    $perc = $allowance->value;
                                                }
                                            @endphp
                                            @php $total_nonstat += $item['value'] @endphp  
                                                <tr >
                                                    <td>{{$item['name']}} @if(!empty($perc)) ({{$perc}}%)  @endif</td>
                                                    <td>:</td>
                                                    <td>{{@num_format($item['value'])}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
            
                                    
                                    <tr>
                                        <td>PAYE</td>
                                        <td>:</td>
                                        <td>{{@num_format($payslip->paye)}}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total Deduction</th>
                                            <th>{{@num_format($payslip->paye + $total_stat + $total_nonstat)}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </th>                     
                        </tr>                        
                    </thead>
                </table>
            </div>
             
            @php 
            
            $net_pay = ($payslip->basic_salary + $total_allowance + $total_benefit) - ($payslip->paye + $total_stat + $total_nonstat)
            @endphp            
            <div class="col-sm-12">
                <table class="table table-striped custom-table" >
                    
                    <tfoot>
                        <tr class="table-primary">
                            <th colspan="5">NetPay</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">
                                <p>
                                    Payment Date : {{date('d/m/Y',strtotime($payslip->created_at))}} <br>
                                    Net Salary After Tax: {{@num_format($net_pay)}} <br>
                                    Bank Name : {{$payslip->bank_name}} <br>
                                    Bank Account # : {{$payslip->account_no}} <br>
                                    Pay Period : {{date('M Y',strtotime($payslip->pay_period))}}
                                </p>
                            </th>
                            <th>
                                <p>
                                    13th Month <br>
                                    0.00
                                </p>
                            </th>
                            <th></th>
                            <th>
                                <p>
                                    Net History: <br>
                                    {{@num_format($nethistory)}}
                                </p>
                            </th>
                        </tr>
                        <tr class="table-primary">
                            <th></th>
                            <th></th>
                            <th>SSNIT Tier One </th>
                            <th>Tier Two Corporate Trustees <br> 
                                (Enterprise Trustees Ltd)
                            </th>
                            <th colspan="2">Tier Three Corporate Trustees <br>
                                (United Pension Trustees Ltd)
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2"> Employer Contributions (13%)</th>
                            <th>Tier 1 (13.5%)</th>
                            <th>Tier 2 (5%)</th>
                            <th colspan="2">Tier 3</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>{{@num_format($payslip->basic_salary*0.135)}}</th>
                            <th>{{@num_format($payslip->basic_salary*0.05)}}</th>
                            <th>10%</th>
                            <th>{{@num_format($payslip->basic_salary*0.01)}}</th>
                        </tr>
                        <tr style="border: none;">
                            <th colspan="3">
                                <br>
                                Empoyee Signature....................................................................
                                
                            </th>
                            <th colspan="3" style="text-align: right">
                                <br>
                                Employer Signature...................................................................
                            </th>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
</div>
  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
