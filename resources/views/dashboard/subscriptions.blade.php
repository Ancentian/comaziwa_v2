@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Subscriptions</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn renew_subscription"><i class="fa fa-plus"></i> Renew Subscription</a>
        </div>
    </div>
</div>
<!-- /Page Header -->
@php
    
@endphp

<div class="row">
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Current Package:</strong> {{$packages->name}}</span><br>
            <span><strong>Monthly Price:</strong> {{@num_format($packages->price)}}</span><br>
            <span><strong>Annual Price:</strong> {{@num_format($packages->annual_price)}}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Maxumum Staff:</strong> {{$packages->staff_no}}</span><br>
            <span><strong>Current Staff:</strong> {{\App\Models\Employee::where('tenant_id',auth()->user()->id)->count()}}</span><br>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-info">
            <span><strong>Expires on:</strong> @if($packages->is_system == 1) <span class="badge bg-success">Free Forever</span> @else {{date('d/m/Y H:i',strtotime(auth()->user()->expiry_date))}} @endif </span><br>
            @if($packages->is_system != 1)<span><strong>Days remaining: </strong> {{ceil((strtotime(auth()->user()->expiry_date)-time()) / 86400 )}}</span>@endif<br>
        </div>
    </div>
   
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="my_subscriptions_table">
                <thead>
                    <tr>
                        <th>Package</th>
                        <th>Period Paid For</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('javascript')

@php

$package = \App\Models\Package::find(auth()->user()->package_id);
$pp = !empty($package) ?  $package->price : 0;

@endphp

<script src="https://js.paystack.co/v1/inline.js"></script>
@if (!auth()->user()->package_id && auth()->user()->type == 'client'  && empty($tenant_id))
@if($pp > 0)
    <script>
        $(document).ready(function() {
            $('#welcome_modal').on('show.bs.modal', function(e) {
                $(this).data('bs.modal')._config.backdrop = 'static';
                $(this).data('bs.modal')._config.keyboard = false;
            });

            $('#welcome_modal').modal('show');
        });
    </script>
@endif

@endif

@if ((strtotime(auth()->user()->expiry_date) - time()) <= 0 && auth()->user()->type == 'client'  && empty($tenant_id))
@if($pp > 0)
<script>
    $(document).ready(function() {
        $('#renew_modal').on('show.bs.modal', function(e) {
            $(this).data('bs.modal')._config.backdrop = 'static';
            $(this).data('bs.modal')._config.keyboard = false;
        });

        $('#renew_modal').modal('show');
    });
</script>
@endif
@endif

@endsection