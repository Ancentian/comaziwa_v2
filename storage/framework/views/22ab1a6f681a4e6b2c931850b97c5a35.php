

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Communications</a></li>
                <li class="breadcrumb-item active">Emails</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#staff_create_template"><i class="fa fa-plus"></i> Create Template</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table mb-0" id="staff_templates_table">
                <thead>
                    <tr>
                        <th class="notexport">Action</th>
                        <th>Name</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="staff_create_template" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="staff_create_template_form" >
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" placeholder="Subject" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="template">Template</label>
                        <textarea rows="4" class="form-control summernote" name="template" placeholder="Enter your message here" required></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><span id="submit_send_email">Submit</span> <i class="fa fa-send m-l-5"></i></button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('companies.staff.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/companies/staff/communications/email_templates.blade.php ENDPATH**/ ?>