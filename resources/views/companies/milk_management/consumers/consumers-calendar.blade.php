@extends('layout.app')

@section('content')
<style>
    #calendar {
    max-width: 100%;
    margin: 0 auto;
    height: auto;
}

</style>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Farmers</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="{{url('milkCollection/add-collection')}}" class="btn btn-info" ><i class="fa fa-plus"></i> Add Milk Collection</a> &nbsp;
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#import" hidden><i class="fa fa-download"></i> Import</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                    
                        <!-- Calendar -->
                        <div id="calendar"></div>
                        <!-- /Calendar -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');
    
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto', // Adjust the height to fit its container
            // Add other options here
        });
    
        calendar.render();
    });
    </script>
    
    @endsection