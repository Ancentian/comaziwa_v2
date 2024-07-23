

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Farmers</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_farmer"><i class="fa fa-plus"></i> Add Farmer</a> &nbsp;
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#import" hidden><i class="fa fa-download"></i> Import</a> &nbsp;
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table" id="farmers_table">
                <thead>
                    <tr>
                        <th class="text-right no-sort">Action</th>
                        <th>Code</th>
                        <th>Name</th>			
                        <th>Contact</th>
                        <th>Center</th>
                        <th>Bank</th>
                        <th>ID</th>
                        <th>Gender</th>
                        <th>Status</th>
                    </tr> 
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Farmer Modal -->
<div id="add_farmer" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Farmer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_farmer_form" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php
                        $pass = substr(mt_rand(1000000, 9999999), 0, 6);
                    ?>
    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="fname" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input class="form-control" type="text" name="mname">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="lname" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Collection Center <span class="text-danger">*</span></label>
                                <select name="center_id" class="select form-control" required>
                                    <option>Select Center</option>
                                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($center->id); ?>"><?php echo e($center->center_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Farmer Code <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="farmerID" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>ID Number</label>
                                <input class="form-control" type="text" name="id_number" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Primary Contact</label>
                                <input class="form-control" type="text" name="contact1">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Secondary Contact</label>
                                <input class="form-control" type="text" name="contact2">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select class="select form-control" name="gender" required>
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label class="col-form-label">Joining Date <span class="text-danger"></span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="join_date" type="text" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">  
                            <div class="form-group">
                                <label class="col-form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" name="dob" type="text" required>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location</label>
                                <input class="form-control" type="text" name="location">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marital Status <span class="text-danger"></span></label>
                                <select name="marital_status" class="select form-control" >
                                    <option>Select Marital Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widow">Widow</option>
                                    <option value="windower">Windower</option>
                                    <option value="seperated">Seperated</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Status <span class="text-danger">*</span></label>
                                <select name="status" class="select form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="0">Inactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Education Levels <span class="text-danger">*</span></label>
                                <select name="education_level" class="select form-control" >
                                    <option value="">Select Level</option>
                                    <option value="0">KCPE</option>
                                    <option value="1">KCSE</option>
                                    <option value="2">Certificate</option>
                                    <option value="3">Diploma</option>
                                    <option value="4">Degree</option>
                                    <option value="5">Masters</option>
                                    <option value="6">Doctorate</option>
                                    <option value="7">Others</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Bank Name <span class="text-danger">*</span></label>
                                <select name="bank_id" class="select form-control" required>
                                    <option>Select Bank</option>
                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key->id); ?>"><?php echo e($key->bank_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Branch</label>
                                <input class="form-control" type="text" name="bank_branch">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Account Name</label>
                                <input class="form-control" type="text" name="acc_name">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input class="form-control" type="number" name="acc_number" >
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Mpesa Number</label>
                                <input class="form-control" type="text" name="mpesa_number">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Next of Kin Name</label>
                                <input class="form-control" type="text" name="nok_name" required>
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Next of Kin Phone</label>
                                <input class="form-control" type="text" name="nok_phone">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Next of Kin Relationship</label>
                                <input class="form-control" type="text" name="relationship">
                                <span class="modal-error invalid-feedback" role="alert"></span>
                            </div>
                        </div>
                    </div>
    
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit <span class="please-wait-message" style="display:none;">Please wait...</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="import" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Farmer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
                   
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-4 pull-right">
                            <a href="<?php echo e(asset('files/employee-import.xlsx')); ?>" class="btn btn-primary" download><i class="fa fa-download"></i> Download Template</a>
                        </div>
                    </div>
                    <form id="import_employee_form"  enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="form-group">
                            <input type="file" name="csv_file" class="form-control" required>
                        </div>
                       
                        <div class="form-group mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><span id="btn_employee_import">Import</span> <i class="fa fa-download"></i></button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>


<!-- Add Allowance Modal -->
<div id="bulk_generate" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Generate Payslip</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="bulk_payslip_form" action="<?php echo e(url('/employees/bulk-generate-monthly-payslip')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Pay Period <span class="text-danger">*</span></label>
                            <input class="form-control" type="month" name="pay_period" required>
                        </div>
                    </div>
                    
    
                    <div class="col-sm-6">
                        <br><button class="btn btn-primary submit-btn">Submit</button>
                        <div class="alert alert-warning warning">Please wait... Based on the number of staff in your database, this operation might take time<br> Please DO NOT close this window.</div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
$(document).ready(function(){
    $(".warning").hide();
    $(".submit-btn").show();
    
    $(document).on('click', '#add_employee_btn', function () {
        var actionuRL = "<?php echo e(url('/employees/create')); ?>";
        $('#add_employee').load(actionuRL, function() {
            $(this).modal('show');
        });
    });
    
    $(document).on('click', '#bulk_generate_btn', function () {
        $('#bulk_generate').modal("show");
    });

    $('#bulk_payslip_form').on('submit', function (e) {
        e.preventDefault();
        
        $(".warning").show();
        $(".submit-btn").hide();
        

        var form = this;
        var formData = $(this).serialize();
        var url = $(this).attr('action');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function (response) {
                
                form.reset();
                
                toastr.success(response.message,'Success');
                
                $(".warning").hide();
                $(".submit-btn").show();
                
                // Close the modal
                $('#bulk_generate').modal('hide');
            },
            error: function (xhr, status, error) {
                // Handle error response
                console.error(error);
                toastr.error("Something went wrong, please try again",'Error');
                
                $(".warning").hide();
                $(".submit-btn").show();
            }
        });
    });
});

//Save Cooperative Farmers
$(document).ready(function(){
    
    $('#add_farmer_form').on('submit', function (e) {
        e.preventDefault();

        $(".submit-btn").html("Please wait...").prop('disabled', true);
        var form = this;
        var formData = $(this).serialize();

        $.ajax({
            url: '<?php echo e(url('cooperative/store-farmers')); ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                // Handle success response
                form.reset();
                farmers_table.ajax.reload();
                
                // Close the modal
                $('#add_farmer').modal('hide');
                toastr.success(response.message, 'Success');
                $(".submit-btn").prop('disabled', false); 
                $(".submit-btn").html("Submit");
            },
            error: function (xhr, status, error) {
            // Handle error response
            var responseJSON = xhr.responseJSON;
            if (responseJSON && responseJSON.errors) {
                // Display validation errors
                var errors = responseJSON.errors;
                Object.keys(errors).forEach(function (field) {
                    var errorMessage = errors[field][0];
                    var fieldElement = $('[name="' + field + '"]');
                    var errorElement = fieldElement.next('.modal-error');
                    fieldElement.addClass('is-invalid');
                    errorElement.text(errorMessage).show();
                    toastr.error(errorMessage,'Error');
                });
                // Prevent modal closure if there are errors
                return false;
            }else{
                
                toastr.error('Something Went Wrong!, Try again!','Error');
            }
            $(".submit-btn").prop('disabled', false); 
            $(".submit-btn").html("Submit");
        }
        });
    });

});

$(document).ready(function(){
        farmers_table = $('#farmers_table').DataTable({
            <?php echo $__env->make('layout.export_buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            processing: true,
            serverSide: false,
            ajax: {
                url : "<?php echo e(url('cooperative/farmers')); ?>",
                data: function(d){
                    
                }
            },
            columnDefs:[{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
            columns: [
                {data: 'action', name: 'action',className: 'text-left'}, 
                {data: 'farmerID', name: 'farmerID'},
                {data: 'fullname', name: 'fullname'},
                {data: 'contact1', name: 'contact1'},
                {data: 'center_name', name: 'center_name'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'id_number', name: 'id_number'},
                {data: 'gender', name: 'gender'},
                {data: 'status', name: 'status'},             
            ],
            createdRow: function( row, data, dataIndex ) {
            }
        });

    });

    
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/cooperatives/index.blade.php ENDPATH**/ ?>