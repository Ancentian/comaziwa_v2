@php
    $today = date('l, j F Y');

    $employee_id = optional(auth()->guard('employee')->user())->id;
    $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    $completed = \App\Models\Task::where('status', 'complete')->where('assigned_to', $employee_id)->count();
    $inprogress = \App\Models\Task::where('status', 'inprogress')->where('assigned_to', $employee_id)->count();
    $total = \App\Models\Task::where('assigned_to', $employee_id)->count();

    $projects =  \App\Models\Project::where('team_leader', $employee_id)->count();

    $leave_types = \App\Models\LeaveType::where('tenant_id',$tenant_id)->get();
    $pending = \App\Models\Leave::where('status', 0)->where('employee_id', $employee_id)->count();
    
    $invitedTraining = \App\Models\TrainingRequest::where('employee_id',$employee_id)->where('is_invited',1)->count();
    $appliedTraining = \App\Models\TrainingRequest::where('employee_id',$employee_id)->where('is_invited',0)->count();
    $completedTraining = \App\Models\TrainingRequest::where('employee_id',$employee_id)->where('completion_status',1)->count();
    $outstandingTraining = \App\Models\TrainingRequest::where('employee_id',$employee_id)->where('completion_status',0)->count();


@endphp
@extends('companies.staff.layout.app')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-md-12">
            <div class="welcome-box">
                <div class="welcome-img">
                    <img alt="" src="{{asset('assets/img/profiles/avatar-02.jpg')}}">
                </div>
                <div class="welcome-det">
                    <h3>Welcome, {{ auth()->guard('employee')->user()->name}}!</h3>
                    <p>{{$today}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-lg-12 col-md-12">
        <section class="dash-section">
            <h4 class="card-title">Leave Statistics</h4>
            <!-- Leave Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Total Days</span></h4>
                        @foreach($leave_types as $one)
                            <strong>{{$one->type_name}}</strong>: {{\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['total']}}<br>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Days Taken</span></h4>
                        @foreach($leave_types as $one)
                            <strong>{{$one->type_name}}</strong>: {{\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['taken']}}<br>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-info">
                        <h4> <span>Days Remaining</span></h4>
                        @foreach($leave_types as $one)
                            <strong>{{$one->type_name}}</strong>: {{\App\Models\LeaveDaysCalculator::calculateLeaveDays(auth()->guard('employee')->user()->id,$one->id)['balance']}}<br>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats-info">
                        <h6>Pending</h6>
                        <h4> <span>{{$pending}}</span></h4>
                    </div>
                </div>
                
            </div>

            <h4 class="card-title">Attendance Statistics</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="stats-info">
                        <h6>Today</h6>
                        <h4>{{number_format($attendance_summary['days'], 2)}}</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-info">
                        <h6>This Week</h6>
                        <h4>{{number_format($attendance_summary['weeks'], 2)}}<span></span></h4>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-12 col-md-12">
        <div class="dash-sidebar">
            <section>
                <h5 class="dash-title">Project Statistics</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Total Tasks</h6>
                            <h4>{{number_format($completed)}}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Pending Tasks</h6>
                            <h4>{{number_format($inprogress)}}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-info">
                            <h6>Total Projects</h6>
                            <h4>{{number_format($projects)}}</h4>
                        </div>
                    </div>
                </div>
                
            </section>

            <section>
                <h5 class="dash-title">Training statistics</h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Completed</h6>
                            <h4>{{number_format($completedTraining)}}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Outstanding</h6>
                            <h4>{{number_format($outstandingTraining)}}</h4>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Invited</h6>
                            <h4>{{number_format($invitedTraining)}}</h4>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="stats-info">
                            <h6>Applied</h6>
                            <h4>{{number_format($appliedTraining)}}</h4>
                        </div>
                    </div>
                </div>

                
            </section>
        </div>
    </div>
</div>
@endsection