@php
    $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    $completed = \App\Models\Project::where('progress',100)->where('tenant_id', $tenant_id)->count();
    $progress = \App\Models\Project::where('progress','<',100)->where('tenant_id', $tenant_id)->count();
    $total = \App\Models\Project::where('tenant_id', $tenant_id)->count();
    $high = \App\Models\Project::where('priority','high')->where('tenant_id', $tenant_id)->count();
    $low = \App\Models\Project::where('priority','low')->where('tenant_id', $tenant_id)->count();
@endphp

@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Project</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_staff_project"><i class="fa fa-plus"></i> Create Project</a>
        </div>
    </div>
</div>
<!-- /Page Header -->



<div class="row">
    <div class="col-md-12">
        <div class="card-group m-b-30">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Complete projects</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3">{{$completed}}</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{$total > 0 ? ceil($completed / $total * 100) : 0}}%;" aria-valuenow="{{$total > 0 ? ceil($completed / $total * 100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">In progress</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3">{{$progress}}</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{$total > 0 ? ceil($progress / $total * 100) : 0}}%;" aria-valuenow="{{$total > 0 ? ceil($progress / $total * 100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">Low Priority</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3">{{$low}}</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$total > 0 ? ceil($low / $total * 100) : 0}}%;" aria-valuenow="{{$total > 0 ? ceil($low / $total * 100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <span class="d-block">High Priority</span>
                        </div>
                        
                    </div>
                    <h3 class="mb-3">{{$high}}</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{$total > 0 ? ceil($high / $total * 100) : 0}}%;" aria-valuenow="{{$total > 0 ? ceil($high / $total * 100) : 0}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>

<form id="printProjects" class="mb-2" action="{{ url('projects/print-project') }}" method="POST">
    @csrf
    <div class="row">
        <input type="hidden" value="" name="action" id="action">
        <div class="col-md- mt-4">
            <button type="submit" class="btn btn-primary print-report" name="button" value="print" onclick="setAction('download')"><i class="fa fa-print"></i> Print </button> &nbsp;
            <button type="submit" class="btn btn-primary" name="button" value="download" onclick="setAction('download')"><i class="fa fa-download"></i> PDF</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="all_staff_projects_table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Priority</th>
                        <th>Leader</th>
                        <th>Team</th>
                        <th>Progress(%)</th>
                        <th class="text-right notexport">Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Create Project Modal -->
<div id="create_staff_project" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_staff_project_form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input class="form-control" name="title" type="text">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="select" name="priority">
                                    <option>--Choose Here--</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="start_date" type="text">
                                    <span class="modal-error invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Due Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="due_date" type="text">
                                    <span class="modal-error invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Team Leader</label>
                                <select class="select multiple" name="team_leader">
                                    <option>--Choose Here--</option>
                                    @foreach($employees as $key)
                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endforeach
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Project Team</label>
                                <select class="select multiple" name="project_team[]" multiple>
                                    @foreach($employees as $key)
                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endforeach
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">     
                        <div class="col-12">
                            <div class="pro-progress">
                                <div class="pro-progress-bar">
                                <h4>Progress</h4>
                                <div class="progress">
                                    <input type="range" min="0" max="100" name="progress" class="progress-range progress-input"  style="width: 100%">
                                </div>
                                <span class="progress-value">20%</span>
                                </div>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea class="form-control" name="notes" id="" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- /Create Project Modal -->
@section('javascript')
    <script>
        $(document).ready(function() {
            $('.progress-input').on('input', function() {
                var value = $(this).val();
                $('.progress-value').text(value + '%');
            });
        });

        @if(session('success'))
            toastr.success('{{ session('success') }}', 'Success');
        @endif

        function setAction(action) {
        document.getElementById('action').value = action;
    }

    $(document).ready(function() {
        $('#printProjects').submit(function(e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var formData = $(this).serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'html',
                success: function(response) {
                    if($("#action").val() == 'print'){
                        $("#print_content").html(response);
                        $('#print_content').show().printThis({
                            importCSS: true,
                            afterPrint: function() {
                                $('#print_content').hide();
                            }
                        });
                    }else{
                        var pdfUrl = JSON.parse(response).pdfUrl;
                        window.open(pdfUrl, '_blank');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
    </script>
@endsection