<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name')); ?></title>	
        <?php echo $__env->make('layout.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <style>
            .table{
                width: 100% !important;
            }
            .select{
                width: 100% !important;
            }
            .dt-buttons{
                margin-left: 25% !important;
            }
            .btn-sm {
              background-color: #8F3A84 !important;
                color: #fff !important;
                height: 30px !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }
        </style>
    </head>

	
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

            <?php echo $__env->make('companies.staff.layout.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('companies.staff.layout.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					<?php echo $__env->yieldContent('content'); ?>
				
				</div>
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->

        <?php echo $__env->make('layout.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layout.components', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>;
        <?php echo $__env->make('layout.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(session('flash_message')): ?>
            <div class="alert alert-success">
                <?php echo e(session('flash_message')); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('javascript'); ?>
				
    </body>
</html><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/layout/app.blade.php ENDPATH**/ ?>