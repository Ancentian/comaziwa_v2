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
                            <th colspan="5" >
                                <?php echo $__env->make('layout.company-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <p class="text-center">
                                    <h5 class="text-center"><?php echo e($allowance_name->name); ?> - <?php echo e(date('M Y',strtotime($pay_period))); ?></h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>  
                            <th>Name</th>
                            <th>Position</th>
                            <th>SSN.</th>
                            <th>Allowance</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                        
                        <?php 
                            $result = array_filter(json_decode($key->allowances, true), function ($item) use ($allowance) {
                                return $item['id'] == $allowance;
                            });
                    
                            if (!empty($result)) {
                                $value = reset($result)['value']; 
                                $total += $value;                               
                            }else{
                                $value = 0;
                            }

                        ?>
                        <tr>
                            <td><?php echo e($key->name); ?></td>
                            <td><?php echo e($key->position); ?></td>
                            <td><?php echo e($key->ssn); ?></td>
                            <td><?php echo e($allowance_name->name); ?></td>
                            <td><?php echo e(number_format($value, 2, '.', ',')); ?></td>
                        </tr>  
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <th colspan="4">TOTAL</th>
                            <th><?php echo e(number_format($total, 2, '.', ',')); ?></th>
                        </tr>
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
<?php /**PATH /home/ghpayroll/base/resources/views/reports/print_allowances.blade.php ENDPATH**/ ?>