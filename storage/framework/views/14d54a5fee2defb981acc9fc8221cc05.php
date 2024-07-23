<!-- Header -->
<div class="header">
			
    <!-- Logo -->
   <div class="header-left">
        <a href="#" class="logo">
            <img src="<?php echo e(asset('img/logo.png')); ?>" width="50" height="50" alt="">
        </a>
    </div>
    <!-- /Logo -->
    
    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    
    <!-- Header Title -->
    <div class="page-title-box">
    <?php if(session('is_admin') == 0 && optional(auth()->guard('employee')->user())->is_admin_configured == 1): ?>
        <h3><a class="btn btn-danger" href="<?php echo e(url('staff/set-as-admin')); ?>">Admin View</a></h3>
    <?php endif; ?>    
    <?php if(session('is_admin') == 1): ?>
        <h3><a class="btn btn-warning" href="<?php echo e(url('staff/set-as-staff')); ?>">Staff View</a></h3>
    <?php endif; ?> 
    </div>
    <!-- /Header Title -->
    
    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    
    <!-- Header Menu -->
    <ul class="nav user-menu">

        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img"><img src="<?php echo e(asset('img/profiles/user.jpg')); ?>" alt="">
                <span class="status online"></span></span>
                <span><span><?php echo e(optional(auth()->guard('employee')->user())->name); ?></span></span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="<?php echo e(url('profile/staff-profile')); ?>">My Profile</a>
                <a class="dropdown-item" href="<?php echo e(url('staff/logout')); ?>">Logout</a>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->
    
    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="<?php echo e(url('profile/staff-profile')); ?>">My Profile</a>
            <a class="dropdown-item" href="<?php echo e(url('staff/logout')); ?>">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<!-- /Header --><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/staff/layout/navbar.blade.php ENDPATH**/ ?>