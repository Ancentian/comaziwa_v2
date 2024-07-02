<?php $__env->startSection('content'); ?>
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="<?php echo e(asset('img/ghana.png')); ?>" alt="Code Sniper Developers"></a>
    </div>
    <!-- /Account Logo -->

    <?php if(Session::has('message')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(Session::get('message')); ?>

        </div>
    <?php endif; ?>
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Login</h3>
            <p class="account-subtitle">Access to our dashboard</p>
            <?php if($errors->any()): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="text-danger"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <!-- Account Form -->
            <form action="<?php echo e(url('auth/login')); ?>" method = "POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" type="email" name="email">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Password</label>
                        </div>
                        <div class="col-auto">
                            <a class="text-muted" href="<?php echo e(url('auth/pass-reset')); ?>">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <input class="form-control" type="password" name="password">
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Login</button>
                </div>

                <div class="account-footer">
                    <p>New here? <a href="<?php echo e(url('auth/signup')); ?>">Signup</a></p>
                </div>
                
            </form>
            <!-- /Account Form -->
            
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/auth/login.blade.php ENDPATH**/ ?>