<?php if(!empty($company->logo)): ?>
    <div style="display: flex; justify-content: center; align-items: center;" style="text-align: center">
        <img class="" src="<?php echo e(asset('storage/logos/'.$company->logo)); ?>" alt="Logo" style="height: 40px; margin-right: 10px; margin-top: 18px;">
    </div>   
<?php endif; ?>
<p class="text-center text-danger" >
    <b><?php echo e($company->name); ?></b>
</p>
<p class="text-center">
    <span style="font-size: 15px;"><?php echo e($company->address); ?></span> <br>
    <span style="font-size: 15px;"><?php echo e($company->tel_no); ?></span>  <br>
    <span style="font-size: 15px;">SSN: <?php echo e($company->ssni_est); ?></span>
</p>
<?php /**PATH C:\laragon\www\payroll\resources\views/layout/company-header.blade.php ENDPATH**/ ?>