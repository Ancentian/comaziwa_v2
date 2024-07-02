<?php $__env->startSection('content'); ?>
<style>
    .user-img{
        height: 50px !important;
        width: 50px !important;
    }
</style>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                <li class="breadcrumb-item active">Create Company Profile</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Company Profile</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo e(url('company/storeCompany')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input class="form-control" value="<?php echo e(!empty($company) ? $company->name : null); ?>" name="name" type="text" required>
                            </div>
                        </div>

                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input class="form-control" value="<?php echo e(!empty($company) ? $company->tel_no : null); ?>" name="tel_no" type="tel" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Landline.</label>
                                <input class="form-control" value="<?php echo e(!empty($company) ? $company->land_line : null); ?>" name="land_line" type="tel">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSN</label>
                                <input class="form-control" name="ssni_est" value="<?php echo e(!empty($company) ? $company->ssni_est : null); ?>" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>TIN</label>
                                <input class="form-control" name="tin" value="<?php echo e(!empty($company) ? $company->tin : null); ?>" type="text" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" name="address" value="<?php echo e(!empty($company) ? $company->address : null); ?>" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Primary Email</label>
                                <input class="form-control"  type="email"value="<?php echo e(!empty($company) ? $company->email : null); ?>" name="email" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Secondary Email</label>
                                <input class="form-control" type="email"value="<?php echo e(!empty($company) ? $company->secondary_email : null); ?>" name="secondary_email" type="text">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Logo</label>
                                <input class="form-control" name="logo" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php if(!empty($company->logo)): ?>
                                <span class=""><img src="<?php echo e(asset('storage/logos/'.$company->logo)); ?>" alt="" class="rounded-circle user-img"></span>
                            <?php endif; ?>
                        </div>

                    </div>
                    
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/companies/create_companyProfile.blade.php ENDPATH**/ ?>