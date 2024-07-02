@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Trainings</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="employee_trainings_table">
                <thead>
                    <tr>
                        <th class="text-right notexport">Action</th>
                        <th>Name</th>
                        <th>Training Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Time</th>
                        <th>Vendor</th>
                        <th>Location</th>
                        <th>Description </th>  
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Project Modal -->
<div id="edit_modal" class="modal custom-modal fade" role="dialog">
    
</div>


@endsection


@section('javascript')
<script>
     $(document).on('click', '.edit-button', function () {
        var actionuRL = $(this).data('action');

        $('#expense_modal').load(actionuRL, function() {
            $(this).modal('show');
        });
    });

</script>
 @endsection