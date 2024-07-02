<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Attendance</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<!-- Search Filter -->
<div class="row filter-row">
    <div class="col-sm-6 col-md-4">  
        <div class="form-group form-focus select-focus">
            <label class="focus-label">Select Employee</label>
            <select class="select floating" id="employee_id">
                <option value="" >--Choose One </option>
                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($one->id); ?>"><?php echo e($one['name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-4"> 
        <div class="form-group form-focus">            
            <input class="form-control" type="month" value="<?php echo e(date('Y-m')); ?>" id="month">
        </div>
    </div>
        
</div>
<!-- /Search Filter -->

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive" id="attendance_table_div">
            
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function(){
        loadData();

        function loadData(){
            var data = {'employee_id' : $("#employee_id").val(), 'month' : $("#month").val()};
            $.ajax({
                url: "<?php echo e(url('/attendance/list')); ?>",
                type: 'GET',
                data: data,
                success: function(response) {
                    $("#attendance_table_div").empty();
                    $("#attendance_table_div").html(response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log(xhr.responseText);
                }
            });
            $('#employee_id,#month').change(function() {
                loadData();
            });
        }
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/employees/attendance/index.blade.php ENDPATH**/ ?>