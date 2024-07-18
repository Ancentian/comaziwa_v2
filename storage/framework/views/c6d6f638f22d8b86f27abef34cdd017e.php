<?php $__env->startSection('content'); ?>
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="<?php echo e(asset('img/logo.png')); ?>" alt=""></a>
    </div>
    <!-- /Account Logo -->

    <?php if(Session::has('message')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('message')); ?>

        </div>
    <?php endif; ?>
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Staff Forgot Password?</h3>
            <p class="account-subtitle">Enter your email to get a password reset link</p>
            
            <!-- Account Form -->
            <form action="<?php echo e(url('auth/staff-forgot-password')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" name="email" type="email" required>
                    <?php if($errors->has('email')): ?>
                        <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                </div>
                <div class="account-footer">
                    <p>Remember your password? <a href="<?php echo e(url('auth/login')); ?>">Login</a></p>
                </div>
            </form>
            <!-- /Account Form -->

            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/forgot_password.blade.php ENDPATH**/ ?>