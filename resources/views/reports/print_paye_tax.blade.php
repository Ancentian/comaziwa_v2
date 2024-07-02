<!DOCTYPE html>
<html>
<head>
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}
  <style>
    html, body {
            margin: 10;
            padding: 0;
            font-size: 12px;
        }

    .table {
      border-spacing: 0;
    }

    @page { size: A4 landscape; margin: 0 !important; }
    body { margin: 0 !important; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> 
</head>
<body>
  <div class="container">
   <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="">
                
            </div>
        </div>
        <div class="row">
            <div class="">	
                <table class="table table-striped custom-table" id="paye_reports_table">
                    <thead>
                        <tr>
                            <th colspan="9">
                                @include('layout.company-header')
                                <p class="text-center">
                                    <h5 class="text-center">PAYE TAX RETURNS REPORT - {{date('M Y',strtotime($pay_period))}}</h5>
                                </p>
                            </th>                        
                        </tr>

                        <tr>
                            <th>SSN.</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Basic Salary</th>
                            <th>Allowances</th>
                            <th>Benefits in Kind</th>
                            <th>Gross Income</th>
                            <th>Tax Dedudcted (PAYE)</th>
                            <th>Net Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandAllowance = 0;
                            $grandBenefit = 0;
                            $grandStat = 0;
                            $grandnonStat = 0;
                            $grandpaye = 0;
                            $grandbasic= 0;
                            $grandtier1 = 0;
                            $grandtier2 = 0;
                            $grandNet = 0;
                            $grandGross = 0;
                            
                        @endphp
                        @foreach ($report as $key)

                        @php
                            $grandpaye += $key->paye;
                            $grandbasic+= $key->basic_salary;
                            $grandtier1 += $key->basic_salary*0.135;
                            $grandtier2 += $key->basic_salary*0.05;
                            $grandNet += $key->net_pay;

                            $total_allowance = 0;
                            
                            foreach(json_decode($key->allowances, true) as $one){
                                $total_allowance += $one['value'];
                            }
                            $grandAllowance += $total_allowance;

                            $total_benefit = 0;
                            
                            foreach(json_decode($key->benefits, true) as $one){
                                $total_benefit += $one['value'];
                            }
                            $grandBenefit += $total_benefit;

                            $total_stat = 0;
                            
                            foreach(json_decode($key->statutory_deductions, true) as $one){
                                $total_stat += $one['value'];
                            }
                            $grandStat += $total_stat;

                            $total_nonstat = 0;
                            
                            foreach(json_decode($key->nonstatutory_deductions, true) as $one){
                                $total_nonstat += $one['value'];
                            }
                            $grandnonStat += $total_nonstat;
                            
                            $total_gross = $total_benefit + $total_allowance + $key->basic_salary;
                            $grandGross += $total_gross;
                            


                        @endphp

                        <tr>
                            <td>{{$key->ssn}}</td>
                            <td>{{$key->name}}</td>
                            <td>{{$key->position}}</td>
                            <td>{{@num_format($key->basic_salary)}}</td>
                            <td>{{@num_format($total_allowance)}}</td>
                            <td>{{@num_format($total_benefit)}}</td>
                            <td>{{@num_format($total_gross)}}</td>
                            <td>{{@num_format($key->paye)}}</td>
                            <td>{{@num_format($key->net_pay)}}</td>
                        </tr>   
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary" style="font-weight:bold">
                            <td>TOTAL</td>
                            <td></td>
                            <td></td>
                            <td>{{@num_format($grandbasic)}}</td>
                            <td>{{@num_format($grandAllowance)}}</td>
                            <td>{{@num_format($grandBenefit)}}</td>
                            <td>{{@num_format($grandGross)}}</td>
                            <td>{{@num_format($grandpaye)}}</td>
                            <td>{{@num_format($grandNet)}}</td>
                        </tr>
                        
                        <tr>
                            <td colspan="5">
                                <p>
                                    Prepared by: .....................................................................  <br><br>
                                    Designation..................................................................... <br><br>
                                    Date:  {{date('d/m/Y')}} <br>
                                </p>
                            </td>
                            <td colspan="4">
                                <p>
                                    Approved By: ..................................................................... <br><br>
                                    Designation..................................................................... <br><br>
                                    Date:.....................................................................   <br>
                                </p>
                            </td>
                        </tr>
                    </tfoot>
    
                </table>
            </div>
        </div>
    </div>
   </div>
  </div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
