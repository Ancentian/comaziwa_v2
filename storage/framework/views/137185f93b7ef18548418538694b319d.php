<!DOCTYPE html>
<html>
<head>
  <style>
    html, body {
            margin: 10;
            padding: 0;
            font-size: 12px;
        }

    .table {
      border-spacing: 0;
    }

    @page { size: A4 portrait; margin: 0 !important; }
    body { margin: 0 !important; }
  </style>
  <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>"> 
</head>
<body>
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="">	
                <table class="table table-striped custom-table" border="1" id="">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <?php echo $__env->make('layout.company-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <p class="text-center">
                                    <h5 class="text-center">Projects</h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>  
                            <th>Title</th>
                            <th>Start Date</th>
                            <th>Deadline</th>
                            <th>Priority</th>
                            <th>Leader</th>
                            <th>Progress(%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key->title); ?></td>
                            <td><?php echo e($key->start_date); ?></td>
                            <td><?php echo e($key->due_date); ?></td>
                            <td><?php echo e($key->priority); ?></td>
                            <td><?php echo e($key->employeeName); ?></td>
                            <td><?php echo e($key->progress); ?> %</td>
                        </tr>  
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                <p>
                                    Prepared by: .....................................................................  <br><br>
                                    Designation..................................................................... <br><br>
                                    Date:  <?php echo e(date('d/m/Y')); ?> <br>
                                </p>
                            </td>
                            <td colspan="3">
                                <p>
                                    Approved By: ..................................................................... <br><br>
                                    Designation..................................................................... <br><br>
                                    Date:.....................................................................   <br>
                                </p>
                            </td>
                        </tr>
                    </tfoot>
    
                </table>
            </div>
        </div>
    </div>
  </div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php /**PATH /home/ghpayroll/base/resources/views/companies/projects/print_projects.blade.php ENDPATH**/ ?>