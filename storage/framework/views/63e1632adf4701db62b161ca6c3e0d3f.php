<table class="table table-striped custom-table table-nowrap mb-0">
    <thead>
        <tr>
            <th>Staff Name</th> <!-- Empty header cell for spacing -->
            <?php $__currentLoopData = $calendar_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e($day); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $attendance_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($user['name']); ?></td>
                <?php $__currentLoopData = $user['attendance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                
                    <td>
                        <?php if($one == 1): ?>
                            <i class="fa fa-check text-success"></i>
                        <?php else: ?>
                            <i class="fa fa-close text-danger"></i>
                        <?php endif; ?>
                    </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\payroll\resources\views/employees/attendance/partials/attendance_table.blade.php ENDPATH**/ ?>