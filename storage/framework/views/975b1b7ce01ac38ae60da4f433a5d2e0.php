<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
    </head>

    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
            <a href="<?php echo e(url('auth/login')); ?>" class="btn btn-primary apply-btn">Login as Admin</a>
			<div class="account-content">
                <?php echo $__env->yieldContent('content'); ?>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if(session('flash_message')): ?>
            <div class="alert alert-success">
                <?php echo e(session('flash_message')); ?>

            </div>
        <?php endif; ?>
		
    </body>
	
</html><?php /**PATH C:\laragon\www\comaziwa\resources\views/layout/employee-auth.blade.php ENDPATH**/ ?>