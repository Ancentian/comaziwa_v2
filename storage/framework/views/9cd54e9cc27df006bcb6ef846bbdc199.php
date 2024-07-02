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

    @page { size: A4 landscape; margin: 0 !important; }
    body { margin: 0 !important; }
  </style>
  <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>"> 
</head>
<body>
  <div class="container">
   <div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="">
                
            </div>
        </div>
        <div class="row">
            <div class="">	
                <table class="table table-striped custom-table" id="paye_reports_table">
                    <thead>
                        <tr>
                            <th colspan="7">
                                <?php echo $__env->make('layout.company-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <p class="text-center">
                                    <h5 class="text-center">TIER ONE - SSF CONTRIBUTION REPORT - <?php echo e(date('M Y',strtotime($pay_period))); ?></h5>
                                </p>
                            </th>                        
                        </tr>

                        <tr>
                            <th>SSN.</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Basic Salary</th>
                            <th>Tier One</th>
                            <th>PAYE</th>
                            <th>Net Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $grandAllowance = 0;
                            $grandBenefit = 0;
                            $grandStat = 0;
                            $grandnonStat = 0;
                            $grandpaye = 0;
                            $grandbasic= 0;
                            $grandtier1 = 0;
                            $grandtier2 = 0;
                            $grandNet = 0;
                            $grandGross = 0;
                            
                        ?>
                        <?php $__currentLoopData = $report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php
                            $grandpaye += $key->paye;
                            $grandbasic+= $key->basic_salary;
                            $grandtier1 += $key->basic_salary*0.135;
                            $grandtier2 += $key->basic_salary*0.05;
                            $grandNet += $key->net_pay;

                            $total_allowance = 0;
                            
                            foreach(json_decode($key->allowances, true) as $one){
                                $total_allowance += $one['value'];
                            }
                            $grandAllowance += $total_allowance;

                            $total_benefit = 0;
                            
                            foreach(json_decode($key->benefits, true) as $one){
                                $total_benefit += $one['value'];
                            }
                            $grandBenefit += $total_benefit;

                            $total_stat = 0;
                            
                            foreach(json_decode($key->statutory_deductions, true) as $one){
                                $total_stat += $one['value'];
                            }
                            $grandStat += $total_stat;

                            $total_nonstat = 0;
                            
                            foreach(json_decode($key->nonstatutory_deductions, true) as $one){
                                $total_nonstat += $one['value'];
                            }
                            $grandnonStat += $total_nonstat;
                            
                            $total_gross = $total_benefit + $total_allowance + $key->basic_salary;
                            $grandGross += $total_gross;
                            


                        ?>

                        <tr>
                            <td><?php echo e($key->ssn); ?></td>
                            <td><?php echo e($key->name); ?></td>
                            <td><?php echo e($key->position); ?></td>
                            <td><?php echo e(number_format($key->basic_salary, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($key->basic_salary*0.135, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($key->paye, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($key->net_pay, 2, '.', ',')); ?></td>
                        </tr>   
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary" style="font-weight:bold">
                            <td>TOTAL</td>
                            <td></td>
                            <td></td>
                            <td><?php echo e(number_format($grandbasic, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($grandtier1, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($grandpaye, 2, '.', ',')); ?></td>
                            <td><?php echo e(number_format($grandNet, 2, '.', ',')); ?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="4">
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
  </div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php /**PATH /home/ghpayroll/base/resources/views/reports/print_tier_one.blade.php ENDPATH**/ ?>