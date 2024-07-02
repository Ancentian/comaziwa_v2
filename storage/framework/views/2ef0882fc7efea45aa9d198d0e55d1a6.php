<?php
    use App\Models\EmployeePayslip;
    $total_allowance = 0;
    $total_benefit = 0;
    $total_stat = 0;
    $total_nonstat = 0;
?>
<!DOCTYPE html>
<html>
<head>	
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>"> 
    
  <style>
    html, body {
            margin: 10;
            padding: 0;
            font-size: 12px;
    }

    .table {
      border-spacing: 0;
    }

    .background-danger {
        background-color: #f8d7da;
        -webkit-print-color-adjust: exact !important;
    }

    table {
    border-collapse: collapse;
    }

    table td, table th {
    border: none;
    }
    

    @page { size: A4 portrait; 
        margin: 0 !important;
        padding: 0 !important; }
    body { margin: 0px !important; }
  </style>
  
</head>
<body>
  <div class="container">
    <div class="row">
            <div class="col-sm-12 ">
                <table class="table table-striped custom-table"  id="">
                    <thead>
                        <tr>
                            <th colspan="6">
                                <?php echo $__env->make('layout.company-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <p class="text-center">
                                    <h5 class="text-center">Salary Slip - <?php echo e(date('M Y',strtotime($payslip->pay_period))); ?></h5>
                                </p>
                            </th>                        
                        </tr>
                        <tr>
                            <th>Employee Name</th>
                            <th>:</th>
                            <th><?php echo e($payslip->name); ?> </th>
                            <th>Social Security No.</th>
                            <th>:</th>
                            <th> <?php echo e($payslip->ssn); ?></th>  
                        </tr>
                        <tr>
                            <th>Employee No</th>
                            <th>:</th>
                            <th><?php echo e($payslip->staff_no); ?> </th>
                            <th>Department</th>
                            <th>:</th>
                            <th>Ghana</th>
                        </tr>
                        <tr>  
                            <th>Job Title </th>
                            <th>:</th>
                            <th> <?php echo e($payslip->position); ?></th>
                            <th>Annual Salary FY23</th>
                            <th>:</th>
                            <th><?php echo e(number_format($payslip->basic_salary*12, 2, '.', ',')); ?></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-sm-12 ">
                <table class="table table-striped custom-table"  id="">
                    <thead>
                        <tr>
                            <th>
                                <table class="table table-striped" style="width: 100%" >
                                    <thead>
                                        <tr bgcolor="#f8d7da">
                                            <th><strong>Earnings</strong></th>
                                            <th>:</th>
                                            <th><strong>Amount</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Monthly Basic Salary</td>
                                            <td>:</td>
                                            <td><?php echo e(number_format($payslip->basic_salary, 2, '.', ',')); ?></td>
                                        </tr>
                                        <?php $__currentLoopData = json_decode($payslip->allowances,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                          
                                            <?php if(!empty($item)): ?>
                                            <?php $total_allowance += $item['value'] ?>  
                                                <tr >
                                                    <td><?php echo e($item['name']); ?></td>
                                                    <td>:</td>
                                                    <td><?php echo e(number_format($item['value'], 2, '.', ',')); ?></td>
                                                </tr>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
                                        <?php $__currentLoopData = json_decode($payslip->benefits,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                            
                                            <?php if(!empty($item)): ?>
                                            <?php $total_benefit += $item['value'] ?>  
                                                <tr >
                                                    <td><?php echo e($item['name']); ?></td>
                                                    <td>:</td>
                                                    <td><?php echo e(number_format($item['value'], 2, '.', ',')); ?></td>
                                                </tr>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                        <th><?php echo e(number_format($payslip->basic_salary + $total_allowance + $total_benefit, 2, '.', ',')); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </th>  
                            <th style="vertical-align: top;">
                                <table class="table table-striped" style="width: 100%" >
                                    <thead>
                                        <tr class="table background-danger">
                                            <th><strong>Deductions</strong></th>
                                            <th>:</th>
                                            <th><strong>Amount</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php $__currentLoopData = json_decode($payslip->statutory_deductions,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
                                            <?php if(!empty($item)): ?>
                                            <?php $total_stat += $item['value'] ?>  
                                                <tr >
                                                    <td><?php echo e($item['name']); ?></td>
                                                    <td>:</td>
                                                    <td><?php echo e(number_format($item['value'], 2, '.', ',')); ?></td>
                                                </tr>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
                                        <?php $__currentLoopData = json_decode($payslip->nonstatutory_deductions,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
                                            <?php if(!empty($item)): ?>
                                            <?php $total_nonstat += $item['value'] ?>  
                                                <tr >
                                                    <td><?php echo e($item['name']); ?></td>
                                                    <td>:</td>
                                                    <td><?php echo e(number_format($item['value'], 2, '.', ',')); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
                                    
                                    <tr>
                                        <td>PAYE</td>
                                        <td>:</td>
                                        <td><?php echo e(number_format($payslip->paye, 2, '.', ',')); ?></td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total Deduction</th>
                                            <th><?php echo e(number_format($payslip->paye + $total_stat + $total_nonstat, 2, '.', ',')); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </th>                     
                        </tr>                        
                    </thead>
                </table>
            </div>
             
            <?php 
            
            $net_pay = ($payslip->basic_salary + $total_allowance + $total_benefit) - ($payslip->paye + $total_stat + $total_nonstat)
            ?>            
            <div class="col-sm-12">
                <table class="table table-striped custom-table" >
                    
                    <tfoot>
                        <tr class="table-primary">
                            <th colspan="5">NetPay</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">
                                <p>
                                    Payment Date : <?php echo e(date('d/m/Y',strtotime($payslip->created_at))); ?> <br>
                                    Net Salary After Tax: <?php echo e(number_format($net_pay, 2, '.', ',')); ?> <br>
                                    Bank Name : <?php echo e($payslip->bank_name); ?> <br>
                                    Bank Account # : <?php echo e($payslip->account_no); ?> <br>
                                    Pay Period : <?php echo e(date('M Y',strtotime($payslip->pay_period))); ?>

                                </p>
                            </th>
                            <th>
                                <p>
                                    13th Month <br>
                                    0.00
                                </p>
                            </th>
                            <th></th>
                            <th>
                                <p>
                                    Net History: <br>
                                    <?php echo e(number_format($nethistory, 2, '.', ',')); ?>

                                </p>
                            </th>
                        </tr>
                        <tr class="table-primary">
                            <th></th>
                            <th></th>
                            <th>SSNIT Tier One </th>
                            <th>Tier Two Corporate Trustees <br> 
                                (Enterprise Trustees Ltd)
                            </th>
                            <th colspan="2">Tier Three Corporate Trustees <br>
                                (United Pension Trustees Ltd)
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2"> Employer Contributions (13%)</th>
                            <th>Tier 1 (13.5%)</th>
                            <th>Tier 2 (5%)</th>
                            <th colspan="2">Tier 3</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th><?php echo e(number_format($payslip->basic_salary*0.135, 2, '.', ',')); ?></th>
                            <th><?php echo e(number_format($payslip->basic_salary*0.05, 2, '.', ',')); ?></th>
                            <th>10%</th>
                            <th><?php echo e(number_format($payslip->basic_salary*0.01, 2, '.', ',')); ?></th>
                        </tr>
                        <tr style="border: none;">
                            <th colspan="3">
                                <br>
                                Empoyee Signature....................................................................
                                
                            </th>
                            <th colspan="3" style="text-align: right">
                                <br>
                                Employer Signature...................................................................
                            </th>
                        </tr>
                        
                    </tfoot>
                </table>
            </div>
</div>
  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php /**PATH /home/ghpayroll/base/resources/views/companies/staff/reports/print_payslip.blade.php ENDPATH**/ ?>