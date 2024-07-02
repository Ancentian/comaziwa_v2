@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Requests</li>
            </ul>
        </div>
        
    </div>
</div>
<!-- /Page Header -->


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="staff_list_trainings_table">
                <thead>
                    <tr>
                        <th class="text-right notexport">Action</th>
                        <th>Training Name</th>
                        <th>Training Type</th>
                        <th>Approval Status</th>
                        <th>Completion Status</th>
                        <th>Upload Certificate</th>
                        <th>Certificate</th>
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