
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Benefits in Kind</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_benefit"><i class="fa fa-plus"></i> Create Benefits in Kind</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table mb-0" id="benefit_in_kind_table">
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


<!-- Add Benefits Modal -->
<div id="add_benefit" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Benefit in Kind</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="benefitsInKind">
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
                        <button type="submit" class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Benefits Modal -->

<!-- Add Benefits Modal -->
<div id="edit_benefit" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Benefit in Kind</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="deduction_name" type="text">
                         <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>DeductionType <span class="text-danger">*</span></label>
                        <input class="form-control" name="deduction_type" type="number">
                         <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Value<span class="text-danger">*</span></label>
                        <input class="form-control" name="value" type="number">
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
<!-- /Add Benefits Modal -->

<!-- Delete Benefits Modal -->
<div class="modal custom-modal fade" id="delete_benefit" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Benefits</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="delete_benefitsOfKind" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Benefits Modal --><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/partials/benefits/index.blade.php ENDPATH**/ ?>