
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Non Statutory Deduction</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_nonStatutory"><i class="fa fa-plus"></i> Create Non Statutory Deduction</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table mb-0" id="non_statutory_deductions_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Value</th>
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
<div id="add_nonStatutory" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Non Statutory Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="nonStatutoryDeduction">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" type="text">
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Type <span class="text-danger">*</span></label>
                        <select class="select" name="type">
                            <option value="">--Choose Here--</option>
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                        <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Value<span class="text-danger">*</span></label>
                        <input class="form-control" name="value" type="number" step="0.01">
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
<!-- /Add Allowance Modal -->

<!-- Add Allowance Modal -->
<div id="edit_nonStatutory" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Non Statutory Deduction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="deduction_name" type="text">
                    </div>
                    <div class="form-group">
                        <label>DeductionType <span class="text-danger">*</span></label>
                        <input class="form-control" name="deduction_type" type="number">
                    </div>
                    <div class="form-group">
                        <label>Value<span class="text-danger">*</span></label>
                        <input class="form-control" name="value" type="number">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Non Statutory Deduction Modal -->

<!-- Delete Non Statutory Deduction Modal -->
<div class="modal custom-modal fade" id="delete_nonStatutoryDed" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Non Statutory Deduction</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="delete-nonStatutoryDed" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Non Statutory Deduction Modal --><?php /**PATH /home/ghpayroll/base/resources/views/companies/partials/deductions/non_statutoryDeductions.blade.php ENDPATH**/ ?>