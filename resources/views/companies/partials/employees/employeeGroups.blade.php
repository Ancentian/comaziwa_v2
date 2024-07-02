
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Employee Groups</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_empGroup"><i class="fa fa-plus"></i> Create Employee Groups</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table mb-0" id="employees_group_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Minimum</th>
                        <th>Maximum</th>
                        <th class="text-right notexport">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Allowance Modal -->
<div id="add_empGroup" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Employee Groups</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="emp_groupForm">
                    @csrf
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="name" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Minimum Salary<span class="text-danger">*</span></label>
                        <input class="form-control" name="min_salary" type="number">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Maximum Salary<span class="text-danger">*</span></label>
                        <input class="form-control" name="max_salary" type="number">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Employee Groups Modal -->

<!-- Add Employee Groups Modal -->
<div id="edit_empGroup" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee Groups</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Name<span class="text-danger">*</span></label>
                        <input class="form-control " name="name" type="number">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Minimum Salary<span class="text-danger">*</span></label>
                        <input class="form-control" name="minimum_salary" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Maximum Salary<span class="text-danger">*</span></label>
                        <input class="form-control" name="maximum_salary" type="number">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Employee Groups Modal -->

<!-- Delete Employee Groups Modal -->
<div class="modal custom-modal fade" id="delete_employee" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Employee</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="delete_employeeGroup" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Employee Groups Modal -->