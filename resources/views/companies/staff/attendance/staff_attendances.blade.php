@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Attendance</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Search Filter -->
<div class="row filter-row">
    <div class="col-sm-6 col-md-4">  
        <div class="form-group form-focus select-focus">
            <label class="focus-label">Select Employee</label>
            <select class="select floating" id="employee_id">
                <option value="" >--Choose One </option>
                @foreach($employees as $one)
                    <option value="{{$one->id}}">{{$one['name']}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-4"> 
        <div class="form-group form-focus">            
            <input class="form-control" type="month" value="{{ date('Y-m') }}" id="month">
        </div>
    </div>
        
</div>
<!-- /Search Filter -->

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive" id="staff_attendance_table_div">
            
        </div>
    </div>
</div>


@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        loadData();

        function loadData(){
            var data = {'employee_id' : $("#employee_id").val(), 'month' : $("#month").val()};
            $.ajax({
                url: "{{url('/staff/staff-attendances')}}",
                type: 'GET',
                data: data,
                success: function(response) {
                    $("#staff_attendance_table_div").empty();
                    $("#staff_attendance_table_div").html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });
            $('#employee_id,#month').change(function() {
                loadData();
            });
        }
    });

</script>
@endsection