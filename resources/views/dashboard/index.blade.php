@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            
            @if(session('is_admin') == 1 && optional(auth()->guard('employee')->user())->is_admin_configured == 1)
                <h3 class="page-title">Welcome {{ optional(auth()->guard('employee')->user())->name }}!</h3>
            @else
                <h3 class="page-title">Welcome {{ auth()->user()->name }}!</h3>
            @endif

            
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Dashboard</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                <div class="dash-widget-info">
                    <h3>{{App\Models\Employee::where('tenant_id',auth()->user()->id)->count()}}</h3>
                    <span>Employees</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                <div class="dash-widget-info">
                    <h3>{{App\Models\Project::where('tenant_id',auth()->user()->id)->count()}}</h3>
                    <span>Projects</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                <div class="dash-widget-info">
                    <h3>{{App\Models\Farmer::where('tenant_id',auth()->user()->id)->count()}}</h3>
                    <span>Farmers</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                <div class="dash-widget-info">
                    <h3>{{App\Models\Leave::where('tenant_id',auth()->user()->id)->where('status',0)->count()}}</h3>
                    <span>Pending Leaves</span>
                </div>
            </div>
        </div>
    </div>

</div>

@php
    use Carbon\Carbon;
    if(session('is_admin') == 1)
    {
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    }else{
        $tenant_id = auth()->user()->id;
    }

    $todays = App\Models\Expense::whereDate('created_at',date('Y-m-d'))->where('tenant_id', $tenant_id)->count();
    $monthly = App\Models\Expense::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->where('tenant_id', $tenant_id)->count();
    $annually = App\Models\Expense::whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->where('tenant_id', $tenant_id)->count();
    $pending_requests = App\Models\Expense::where('approval_status', '=', 0)->whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->where('tenant_id', $tenant_id)->count();

    $today_requests = \App\Models\Expense::where('approval_status', '=', 1)->where('tenant_id', $tenant_id)->whereDate('created_at', '=', Carbon::today())->count();
    $monthly_requests = \App\Models\Expense::where('approval_status', '=', 2)->where('tenant_id', $tenant_id)->whereMonth('created_at', '=', Carbon::now()->month)->count();
    $yearly_requests = \App\Models\Expense::where('approval_status', '=', 2)->where('tenant_id', $tenant_id)->whereYear('created_at', '=', Carbon::now()->year)->count();
    //$pending_requests = \App\Models\Expense::where('approval_status', '=', 0)->count();
    
@endphp


<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Expense Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Today's Expense Requests</p>
                                <h3>{{$todays}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>This Months Expense Requests</p>
                                <h3>{{$monthly}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Annual Expense Requests</p>
                                <h3>{{$annually}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Pending Expense Requests</p>
                                <h3>{{$pending_requests}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Production Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Today's Expense Requests</p>
                                <h3>{{$todays}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>This Months Expense Requests</p>
                                <h3>{{$monthly}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Annual Expense Requests</p>
                                <h3>{{$annually}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Pending Expense Requests</p>
                                <h3>{{$pending_requests}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Total Milk</h3>
                        <div id="bar-charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Sales Overview</h3>
                        <div id="pie-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Sales Overview</h3>
                        <div id="line-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@php
   $total_leaves = App\Models\Leave::count();
   $today_leaves =  $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereDate('created_at',date('Y-m-d'))->count() : 0;
   $month_leaves = $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->count() : 0;
   $year_leaves = $total_leaves > 0 ? App\Models\Leave::where('tenant_id',auth()->user()->id)->whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->count() : 0;
@endphp

<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-6 d-flex">
        <div class="card flex-fill dash-statistics">
            <div class="card-body">
                <h5 class="card-title">Leave Statistics</h5>
                <div class="stats-list">
                    <div class="stats-info">
                        <p>Today Leave <strong>{{$today_leaves}} <small>/ {{$total_leaves}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$today_leaves > 0 ? ($today_leaves/$total_leaves*100) : 0}}%" aria-valuenow="{{$today_leaves > 0 ? ($today_leaves/$total_leaves*100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Month <strong>{{$month_leaves}} <small>/ {{$total_leaves}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{$month_leaves > 0 ? ($month_leaves/$total_leaves*100) : 0}}%" aria-valuenow="{{$month_leaves > 0 ? ($month_leaves/$total_leaves*100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>This Year <strong>{{$year_leaves}} <small>/ {{$total_leaves}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$year_leaves > 0 ? ($year_leaves/$year_leaves*100) : 0}}%" aria-valuenow="{{$year_leaves > 0 ? ($year_leaves/$year_leaves*100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $projects = App\Models\Project::where('tenant_id',auth()->user()->id)->count();
        $inprogress = $projects > 0 ? App\Models\Project::where('progress','<',100)->where('tenant_id',auth()->user()->id)->count() : 0;
        $completed = $projects-$inprogress;
    @endphp
    
    <div class="col-md-12 col-lg-6 col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Project Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>In Progress</p>
                                <h3>{{$inprogress}}</h3>
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Completed</p>
                                <h3>{{$completed}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-4">
                    <div class="progress-bar bg-purple" role="progressbar" style="width: {{$completed > 0 ? ($completed/$projects*100) : 0}}%" aria-valuenow=" {{$completed > 0 ?($completed/$projects*100) : 0}}" aria-valuemin="0" aria-valuemax="100"> {{$completed > 0 ?($completed/$projects*100) : 0}}%</div>
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{$inprogress >0 ? ($inprogress/$projects*100) : 0}}%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="{{$inprogress >0 ? ($inprogress/$projects*100) : 0}}">{{$inprogress >0 ? ($inprogress/$projects*100) : 0}}%</div>
                </div>
                <div>
                    <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Completed <span class="float-right">{{$completed}}</span></p>
                    <p><i class="fa fa-dot-circle-o text-warning mr-2"></i>Inprogress <span class="float-right">{{$inprogress}}</span></p>
                </div>
            </div>
        </div>
    </div> 
</div>

@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/milk-analysis', // Adjust the route as needed
            method: 'GET',
            success: function(data) {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var chartData = [];
                
                data.forEach(function(item) {
                    var monthName = monthNames[item.month - 1]; // Subtract 1 because JavaScript uses 0-based indexing
                    chartData.push({
                        y: monthName,
                        morning: item.total_morning,
                        evening: item.total_evening,
                        rejected: item.total_rejected,
                        total: item.total_milk
                    });
                });

                // Create Morris.Bar chart for Morning, Evening, and Total Milk
                new Morris.Bar({
                    element: 'bar-charts',
                    data: chartData,
                    xkey: 'y',
                    ykeys: ['morning', 'evening', 'total'],
                    labels: ['Morning Milk', 'Evening Milk', 'Total Milk'],
                    barColors: ['#2ecc71', '#e74c3c', '#3498db'],
                    resize: true,
                    xLabelAngle: 45, // Rotate x-axis labels for better visibility
                    hoverCallback: function (index, options, content, row) {
                       
                        var totalMilk = row.morning + row.evening - row.rejected;
                        return content + " Total: " + totalMilk;
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: '/monthly-milk-analysis', // Adjust the route as needed
            method: 'GET',
            success: function(data) {
                var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var chartData = [];
                
                data.forEach(function(item) {
                    var monthName = monthNames[item.month - 1]; // Subtract 1 because JavaScript uses 0-based indexing
                    chartData.push({
                        label: monthName,
                        value: item.total_milk
                    });
                });

                // Create Morris.Donut chart for Total Milk per Month
                new Morris.Donut({
                    element: 'pie-chart',
                    data: chartData,
                    colors: ['#2ecc71', '#e74c3c', '#3498db', '#9b59b6', '#f39c12', '#1abc9c', '#34495e', '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#c0392b'],
                    resize: true,
                    formatter: function (y, data) { return y + " liters"; }
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", status, error);
            }
        });
    });

        $(document).ready(function() {
            $.ajax({
                url: '/monthly-milk-analysis', // Adjust the route as needed
                method: 'GET',
                success: function(data) {
                    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                    var chartData = [];
                    
                    data.forEach(function(item) {
                        var monthName = monthNames[item.month - 1]; // Convert month number to month name
                        chartData.push({
                            year: monthName,
                            value: item.total_milk
                        });
                    });

                    // Create Morris.Line chart
                    new Morris.Line({
                        element: 'line-chart',
                        data: chartData,
                        xkey: 'year',
                        ykeys: ['value'],
                        labels: ['Total Milk'],
                        lineColors: ['#373651'],
                        lineWidth: 2,
                        resize: true,
                        xLabelAngle: 45 // Rotate x-axis labels for better visibility
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", status, error);
                }
            });
        });
    </script>
    </script>

</script>
@endsection