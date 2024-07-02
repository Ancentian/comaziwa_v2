<!DOCTYPE html>
<html>
<head>
  <style>
    html, body {
            margin: 10;
            padding: 0;
            font-size: 12px;
        }

    .table {
      border-spacing: 0;
    }
    @page { size: A4 portrait; margin: 0 !important; }
    body { margin: 0 !important; }
  </style>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> 
</head>
<body>
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="">	
                <table class="table table-striped custom-table" border="1" id="">
                    <thead>
                        <tr>
                            <th colspan="5" >
                                @include('layout.company-header')
                                <p class="text-center">
                                    <h5 class="text-center">{{$allowance_name->name}} - {{date('M Y',strtotime($pay_period))}}</h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>  
                            <th>Name</th>
                            <th>Position</th>
                            <th>SSN.</th>
                            <th>Allowance</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($report as $key)                        
                        @php 
                            $result = array_filter(json_decode($key->allowances, true), function ($item) use ($allowance) {
                                return $item['id'] == $allowance;
                            });
                    
                            if (!empty($result)) {
                                $value = reset($result)['value']; 
                                $total += $value;                               
                            }else{
                                $value = 0;
                            }

                        @endphp
                        <tr>
                            <td>{{$key->name}}</td>
                            <td>{{$key->position}}</td>
                            <td>{{$key->ssn}}</td>
                            <td>{{$allowance_name->name}}</td>
                            <td>{{@num_format($value)}}</td>
                        </tr>  
                        @endforeach        
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <th colspan="4">TOTAL</th>
                            <th>{{@num_format($total)}}</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>
                                    Prepared by: .....................................................................  <br><br>
                                    Designation..................................................................... <br><br>
                                    Date:  {{date('d/m/Y')}} <br>
                                </p>
                            </td>
                            <td colspan="3">
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
