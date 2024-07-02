@php
    $employee_id = optional(auth()->guard('employee')->user())->id;
    $total_requests = \App\Models\Expense::where('approval_status','=',1)->where('employee_id', $employee_id)->sum('amount');
    $approved = \App\Models\Expense::where('approval_status','=',1)->where('employee_id', $employee_id)->count();
    $declined = \App\Models\Expense::where('approval_status','=',2)->where('employee_id', $employee_id)->count();
    $paid = \App\Models\Expense::where('payment_status', '=', 1)->where('employee_id', $employee_id)->count();
@endphp
@extends('companies.staff.layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Employee</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_expense"><i class="fa fa-plus"></i> Add Expense Request</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Expense Statistics -->
<div class="row">
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Total Expense</h6>
            <h4>{{@num_format($total_requests)}}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Approved Requests</h6>
            <h4>{{$approved}}<span></span></h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Declined Requests</h6>
            <h4>{{$declined}}</h4>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-info">
            <h6>Paid Requests</h6>
            <h4>{{$paid}} <span></span></h4>
        </div>
    </div>
    
</div>
<!-- /Expense Statistics -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table" id="staff_expenses_table">
                <thead>
                    <tr>
                        <th class="text-left">Actions</th>
                        <th>Type</th>
                        <th>Request By</th>
                        <th>Date</th>  
                        <th>Amount</th>
                        <th>Purpose</th>
                        <th>Approval Status</th>
                        <th class="text-center">Payment Status</th>    
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div id="add_expense" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_expense_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Expense Type </label>
                                <select class="select" name="type_id">
                                    <option>Select Expense Type</option>
                                    @foreach ($expense_types as $key)
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endforeach
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Date</label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="date" type="text">
                                    <span class="modal-error invalid-feedback" role="alert"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Purpose</label>
                                <textarea class="form-control" name="purpose" id="" cols="30" rows="3"></textarea>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input placeholder="" class="form-control" name="amount" type="number">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Supervisor </label>
                                <select class="select" name="supervisor">
                                    <option>Select Supervisor</option>
                                    @foreach ($supervisors as $key)
                                        <option value="{{$key->id}}">{{$key->name}}</option>
                                    @endforeach
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn"> <span id="submit_form">Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Expense Modal -->

<!-- Add Project Modal -->
<div id="expense_modal" class="modal custom-modal fade" role="dialog">
    
</div>

<!-- Delete  Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Record</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <input type="hidden" id="modal_delete_action">
                        <div class="col-6">
                            <a href="#" id="modal_delete_button" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Modal -->
@endsection


@section('javascript')
<script>
     $(document).on('click', '.edit-button', function () {
        var actionuRL = $(this).data('action');

        $('#expense_modal').load(actionuRL, function() {
            $(this).modal('show');
        });
    });

    $(document).on('click', '.delete-button', function () {
        var actionuRL = $(this).data('action');
        console.log(actionuRL);
        $("#modal_delete_action").val(actionuRL);
        $("#delete_modal").modal('show');
    });


    $('#modal_delete_button').on('click', function () {
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: $("#modal_delete_action").val(), 
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token 
            },
            success: function (response) {
                // Handle success response
                staff_expenses_table.ajax.reload();
                $("#delete_modal").modal('hide');
                toastr.success('Data Deleted Successfully','Success');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
                toastr.error('Something went wrong','Error');
            }
        });
    });
</script>
 @endsection