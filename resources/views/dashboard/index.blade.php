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

    $morning = App\Models\MilkCollection::where('tenant_id', '=', $tenant_id)->sum('morning');
    $evening = App\Models\MilkCollection::where('tenant_id', '=', $tenant_id)->sum('evening');
    $rejected = App\Models\MilkCollection::where('tenant_id', '=', $tenant_id)->sum('rejected');
    $total = ($morning + $evening) - $rejected;

    $stores = App\Models\StoreSale::where('tenant_id', '=', $tenant_id)->sum('total_cost');
    $deductions = App\Models\Deduction::where('tenant_id', '=', $tenant_id)->sum('amount');
    // $milk = App\Models\PAyment::where('tenant_id', '=', $tenant_id)->sum('total_milk');
    
@endphp


<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Production Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Total Milk</p>
                                <h3>{{num_format($total)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Morning</p>
                                <h3>{{num_format($morning)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Evening</p>
                                <h3>{{num_format($evening)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Rejected</p>
                                <h3>{{num_format($rejected)}}</h3>
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
                <h4 class="card-title">Sales Statistics</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Stores</p>
                                <h3>{{num_format($stores)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Deductions</p>
                                <h3>{{num_format($deductions)}}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Gross</p>
                                <h3>{{ 0.00 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 text-center">
                            <div class="stats-box mb-4" >
                                <p>Nett</p>
                                <h3>{{ 0.00 }}</h3>
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
                        <h3 class="card-title">Monthly Overview</h3>
                        <div id="pie-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Milk Overview</h3>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Collection Center Overview</h3>
                        <canvas id="line2Chart" style="height: 250px;"></canvas>
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
                <h5 class="card-title">Center Statistics</h5>
                <div class="stats-list">
                    <table class="table table-striped custom-table" id="center_statistics_table">
                        <thead>
                            <tr>
                                <th>Center</th>
                                <th>Total Milk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-lg-6 col-xl-6 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Farmer Statistics</h4>
                <div class="statistics">
                    <table class="table table-striped custom-table" id="farmer_statistics_table">
                        <thead>
                            <tr>
                                <th>Farmer</th>
                                <th>Total Milk</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div> 
</div>

@endsection

@section('javascript')
<script>
    //Bar Graph
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

    //Pie Chart
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
    
    //Line Chart
   

    
    $(document).ready(function() {
    $.ajax({
        url: '/monthly-milk-analysis', // Adjust the route as needed
        method: 'GET',
        success: function(data) {
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var labels = [];
            var totals = [];
            var morning = [];
            var evening = [];
            var rejected = [];

            data.forEach(function(item) {
                labels.push(monthNames[item.month - 1]); // Subtract 1 because JavaScript uses 0-based indexing
                totals.push(item.total_milk);
                morning.push(item.total_morning);
                evening.push(item.total_evening);
                rejected.push(item.total_rejected);
            });

            // Get the context of the canvas element we want to select
            var ctx = document.getElementById("lineChart").getContext('2d');
            var lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total ',
                        data: totals,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Morning ',
                        data: morning,
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Evening ',
                        data: evening,
                        fill: false,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Rejected ',
                        data: evening,
                        fill: false,
                        borderColor: 'rgba(154, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
                },
                options: {
                    responsive: true,
                    legend: {
                        display: true
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Liters'
                            }
                        }
                    }
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", status, error);
        }
    });
});

    

    
//Center Analysis
$(document).ready(function() {
    $.ajax({
        url: '/collection-center-analysis', // Adjust the route as needed
        method: 'GET',
        success: function(data) {
            var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var labels = [];
            var centerData = {};

            // Process the data to create labels and centerData
            data.forEach(function(item) {
                var monthName = monthNames[item.month - 1];
                if (!labels.includes(monthName)) {
                    labels.push(monthName);
                }
                if (!centerData[item.center_name]) {
                    centerData[item.center_name] = {
                        label: item.center_name,
                        data: Array(labels.length).fill(null) // Fill data array with nulls up to the current label length
                    };
                }
                centerData[item.center_name].data[labels.indexOf(monthName)] = item.total_milk;
            });

            // Ensure each center has the correct length of data array
            Object.keys(centerData).forEach(center => {
                centerData[center].data = centerData[center].data.concat(Array(labels.length - centerData[center].data.length).fill(null));
            });

            // Create datasets for the chart
            var datasets = Object.values(centerData).map(center => ({
                label: center.label,
                data: center.data,
                fill: false,
                borderColor: getRandomColor(),
                borderWidth: 1
            }));

            // Check if the canvas element exists
            var canvas = document.getElementById("line2Chart");
            if (canvas) {
                var ctx = canvas.getContext('2d');
                var line2Chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw} liters`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Liters'
                                }
                            }
                        }
                    }
                });
            } else {
                console.error("Canvas element with id 'lineChart' not found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", status, error);
        }
    });
});

// Function to generate a random color for the lines
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$(document).ready(function(){
        center_statistics_table = $('#center_statistics_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('center-statistics')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'center_name', name: 'center_name'},
                {data: 'total_milk', name: 'total_milk'},
                {data: 'action', name: 'action', className: 'text-left'}   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });

    $(document).ready(function(){
        farmer_statistics_table = $('#farmer_statistics_table').DataTable({
            @include('layout.export_buttons')
            processing: true,
            serverSide: false,
            ajax: {
                url : "{{url('farmer-statistics')}}",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'fullname', name: 'fullname'},
                {data: 'total_milk', name: 'total_milk'},
                {data: 'action', name: 'action', className: 'text-left'}   
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });
    });
 
</script>
</script>
@endsection