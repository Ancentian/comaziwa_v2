
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Tax bands</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_tax"><i class="fa fa-plus"></i> Create Taxbands</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table mb-0" id="tax_bands_table">
                <thead>
                    <tr>
                        <th>Minimum</th>
                        <th>Maximum</th>
                        <th>Rate</th>
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
<div id="add_tax" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Taxbands</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="taxband">
                    @csrf
                    <div class="form-group">
                        <label>Minimum <span class="text-danger">*</span></label>
                        <input class="form-control" name="min" type="text">
                         <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Maximum <span class="text-danger">*</span></label>
                        <input class="form-control" name="max" type="number">
                         <span class="modal-error invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Rate<span class="text-danger">*</span></label>
                        <input class="form-control" name="rate" type="number">
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
<!-- /Add Taxbands Modal -->

<!-- Delete Taxbands Modal -->
<div class="modal custom-modal fade" id="delete_tax" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Taxbands</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="delete_taxband" class="btn btn-primary continue-btn">Delete</a>
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
<!-- /Delete Taxbands Modal -->