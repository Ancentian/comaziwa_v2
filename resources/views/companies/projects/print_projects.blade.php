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
                            <th colspan="6">
                                @include('layout.company-header')
                                <p class="text-center">
                                    <h5 class="text-center">Projects</h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>  
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Priority</th>
                            <th>Leader</th>
                            <th>Progress(%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key)
                        <tr>
                            <td>{{$key->title}}</td>
                            <td>{{$key->start_date}}</td>
                            <td>{{$key->due_date}}</td>
                            <td>{{$key->priority}}</td>
                            <td>{{$key->employeeName}}</td>
                            <td>{{$key->progress}} %</td>
                        </tr>  
                        @endforeach        
                    </tbody>
                    <tfoot>
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
