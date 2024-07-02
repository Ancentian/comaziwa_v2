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
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_subscription"><i class="fa fa-plus"></i> Add Subscription</a>
        </div>
    </div>
</div>
<!-- /Page Header -->
@php
    use Carbon\Carbon;

    $currentWeek = Carbon::now()->week;
    $weeks = App\Models\Subscription::whereRaw('YEARWEEK(created_at) = YEARWEEK(CURRENT_DATE())')
    ->sum('amount_paid');
    $todays = App\Models\Subscription::whereDate('created_at',date('Y-m-d'))->sum('amount_paid');
    $months = App\Models\Subscription::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [date('Y-m')])->sum('amount_paid');
    $annual = App\Models\Subscription::whereRaw('DATE_FORMAT(created_at, "%Y") = ?', [date('Y')])->sum('amount_paid');
@endphp

<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Today's Income</h6>
            <h4><span>GHS {{@num_format($todays)}}</span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Week's Income</h6>
            <h4><span>GHS {{@num_format($weeks)}}</span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Month's Income</h6>
            <h4> <span>GHS {{@num_format($months)}}</span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Annual Income</h6>
            <h4><span>GHS {{@num_format($annual)}}</span></h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="subscriptions_table">
                <thead>
                    <tr>
                        <th>Tenant</th>
                        <th>Package</th>
                        <th>Period Paid For</th>
                        <th>Amount</th>
                        <th>Expiry Date</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add Modal -->
<div class="modal custom-modal fade" id="add_subscription" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Subscription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="subscription_form">
                    @csrf
                    <div class="form-group">
                        <label>Tenant <span class="text-danger">*</span></label>
                        <select class="select" name="tenant_id" id="tenant_id"> 
                            <option value="">--Choose Tenant</option>
                            @foreach($tenants as $key)
                            <option value="{{$key->id}}">{{$key->name}}</option>
                            @endforeach
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Package <span class="text-danger">*</span></label>
                        <select class="select" name="package_id" id="">
                            <option value="">--Choose Package--</option>
                            @foreach($packages as $key)
                            <option value="{{$key->id}}">{{$key->name}}</option>
                            @endforeach
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Amount Paid<span class="text-danger">*</span></label>
                        <input class="form-control" name="amount_paid" type="number">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    {{-- <div class="form-group">
                        <label>Start Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="start_date" type="text">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label>Expiry Date <span class="text-danger">*</span></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" name="end_date" type="text">
                            <span class="modal-error invalid-feedback" role="alert"></span>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Modal -->
<!-- Add Modal -->
<div class="modal custom-modal fade" id="add_subs" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Subscription Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Plan Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="plan_name" type="text">
                    </div>
                    <div class="form-group">
                        <label>No. of Days <span class="text-danger">*</span></label>
                        <input class="form-control" name="no_of_days" type="number">
                    </div>
                    <div class="form-group">
                        <label>Price<span class="text-danger">*</span></label>
                        <input class="form-control" name="price" type="number">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Modal -->

<!-- Edit Modal -->
<div class="modal custom-modal fade" id="edit_plan" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscription Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Plan Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="plan_name" type="text">
                    </div>
                    <div class="form-group">
                        <label>No. of Days <span class="text-danger">*</span></label>
                        <input class="form-control" name="no_of_days" type="number">
                    </div>
                    <div class="form-group">
                        <label>Price<span class="text-danger">*</span></label>
                        <input class="form-control" name="price" type="number">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /edit Modal -->

<!-- Delete Plan Modal -->
<div class="modal custom-modal fade" id="delete_plan" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Plan</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Plan Modal -->

@endsection