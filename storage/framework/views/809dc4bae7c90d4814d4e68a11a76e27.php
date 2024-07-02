<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Banks </li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_bank"><i class="fa fa-plus"></i> Add Bank</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table mb-0" id="banks_table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="text-right notexport">Action</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add Center Modal -->
<div id="add_bank" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bankForm">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Bank Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="bank_name" type="text">
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
<!-- /Add Benefits Modal --><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/partials/banks/index.blade.php ENDPATH**/ ?>