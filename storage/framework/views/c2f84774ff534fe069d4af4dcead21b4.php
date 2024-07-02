<?php
    use App\Models\EmployeePayslip;
    $total_allowance = 0;
    $total_benefit = 0;
    $total_stat = 0;
    $total_nonstat = 0;

?>



<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                <li class="breadcrumb-item active">Employees Pay Slip</li>
            </ul> 
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <?php echo $flash_mesage; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form action="<?php echo e($action); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                <h4 class="payslip-title">CONFIGURE EMPLOYEE PAYSLIP</h4>
                <h4 class="payslip-title"><?php echo e($employee->name); ?></h4>
                <h4 class="payslip-title"><?php echo e($employee->staff_no); ?></h4>
                <div class="row">
                    <input hidden name="employee_id" value="<?php echo e($employee->id); ?>">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><div class="row">
                                            <div class="col-md-6">
                                                <h5 class="m-b-10"><strong>BASIC SALARY</strong></h5>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control w-50 pull-right" type="number" step="0.01" value="<?php echo e($basic_salary); ?>" id="basic_salary"  name="basic_salary" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>ALLOWANCES</strong></h5></td>
                                        <td>Type</td>
                                        <td>Value</td>
                                        <td>Total</td>
                                    </tr>
                                    <?php $__currentLoopData = $allowance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','allowance')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_allowance += $itemVal;
                                            
                                        ?>
                                        <input hidden name="allowance_key[]" value="<?php echo e($item->id); ?>">
                                        <tr >
                                            <td><h5 class="m-b-10"><strong><?php echo e($item->name); ?></strong></h5></td>
                                            <td><input class="form-control w-50 pull-right calc_type" type="text" value="<?php echo e($item->type); ?>" disabled>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_value" type="number" step="0.01" value="<?php echo e(!empty($itemValue) ? $itemValue->itemvalue : $itemVal); ?>" name="allowance_itemvalue[]" required>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_total" type="number"  step="0.01" value="<?php echo e($itemVal); ?>" name="allowance_value[]" required readonly></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="4"><strong>TOTAL CASH ALLOWANCES </strong> <span class="float-right"><strong id="total_allowance"><?php echo e($total_allowance); ?></strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td colspan="4"><strong>TOTAL CASH EMOLUMENT </strong> <span class="float-right"><strong id="total_emolument"><?php echo e($basic_salary+$total_allowance); ?></strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>BENEFITS IN KIND</strong></h5></td>
                                        <td>Type</td>
                                        <td>Value</td>
                                        <td>Total</td>
                                    </tr>
                                    <?php $__currentLoopData = $benefit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','benefit')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_benefit += $itemVal;
                                            
                                        ?>
                                        <input hidden name="benefit_key[]" value="<?php echo e($item->id); ?>">
                                        <tr >
                                            <td><h5 class="m-b-10"><strong><?php echo e($item->name); ?></strong></h5></td>
                                            <td><input class="form-control w-50 pull-right calc_type" type="text" value="<?php echo e($item->type); ?>" disabled>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_value" type="number"  step="0.01" value="<?php echo e(!empty($itemValue) ? $itemValue->itemvalue : $itemVal); ?>" name="benefit_itemvalue[]" required>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_total" type="number" step="0.01" value="<?php echo e($itemVal); ?>" name="benefit_value[]" required readonly></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="4"><strong>TOTAL BENEFITS IN KIND </strong> <span class="float-right"><strong id="total_benefit"><?php echo e($total_benefit); ?></strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td colspan="4"><strong>TOTAL GROSS PAY </strong> <span class="float-right"><strong id="total_gross"><?php echo e($basic_salary + $total_allowance + $total_benefit); ?></strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>STATUTORY DEDUCTIONS</strong></h5></td>
                                        <td>Type</td>
                                        <td>Value</td>
                                        <td>Total</td>
                                    </tr>
                                    <?php $__currentLoopData = $statutoryDed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','statutory_ded')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_stat += $itemVal;
                                            
                                        ?>
                                        <input hidden name="statutory_key[]" value="<?php echo e($item->id); ?>">
                                        <tr >
                                            <tr >
                                                <td><h5 class="m-b-10"><strong><?php echo e($item->name); ?></strong></h5></td>
                                                <td><input class="form-control w-50 pull-right calc_type" type="text" value="<?php echo e($item->type); ?>" disabled>
                                                </td>
                                                <td><input class="form-control w-50 pull-right calc_value" type="number" step="0.01" value="<?php echo e(!empty($itemValue) ? $itemValue->itemvalue : $itemVal); ?>" name="statutory_itemvalue[]" required>
                                                </td>
                                                <td><input class="form-control w-50 pull-right calc_total" type="number" step="0.01" value="<?php echo e($itemVal); ?>" name="statutory_value[]" required readonly></td>
                                            </tr>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="4"><strong>TOTAL STATUTORY DEDUCTIONS </strong> <span class="float-right"><strong id="total_stat"><?php echo e($total_stat); ?></strong></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td colspan="4"><strong>TOTAL TAXABLE INCOME </strong> <span class="float-right"><strong id="total_taxable"><?php echo e($basic_salary + $total_allowance + $total_benefit - $total_stat); ?></strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <?php
                        $salary = $basic_salary + $total_allowance + $total_benefit - $total_stat; 
                        $total_tax = App\Models\TaxCalculator::calculateTax($salary);
                    ?>


                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tfoot class="table-danger">
                                    <tr class="table-secondary">
                                        <td><strong>PAYE </strong> <span class="float-right" id="total_tax"><?php echo e($total_tax); ?></span></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <td><strong>INCOME AFTER TAX</strong> <span class="float-right"><strong id="income_after"><?php echo e($salary-$total_tax); ?></strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr class="table-secondary">
                                        <td><h5 class="m-b-10"><strong>NON STATUTORY DEDUCTIONS</strong></h5></td>
                                        <td>Type</td>
                                        <td>Value</td>
                                        <td>Total</td>
                                    </tr>
                                    <?php $__currentLoopData = $non_statutoryded; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                        ->where('type','nonstatutory_ded')
                                                                        ->where('source_id',$item->id)->first();
                                            if(!empty($itemValue)){
                                                $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                            }else{
                                                if($item->type == "fixed"){
                                                    $itemVal = $item->value;
                                                }else{
                                                    $itemVal = $item->value*$basic_salary/100;
                                                }
                                            }

                                            $total_nonstat += $itemVal;
                                            
                                        ?>
                                        <input hidden name="nonstatutory_key[]" value="<?php echo e($item->id); ?>">
                                        <tr >
                                            <td><h5 class="m-b-10"><strong><?php echo e($item->name); ?></strong></h5></td>
                                            <td><input class="form-control w-50 pull-right calc_type" type="text" value="<?php echo e($item->type); ?>" disabled>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_value" type="number" step="0.01" value="<?php echo e(!empty($itemValue) ? $itemValue->itemvalue : $itemVal); ?>" name="nonstatutory_itemvalue[]" required>
                                            </td>
                                            <td><input class="form-control w-50 pull-right calc_total" type="number" step="0.01" value="<?php echo e($itemVal); ?>" name="nonstatutory_value[]" required readonly></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <td colspan="4"><strong>TOTAL OTHER DEDUCTIONS </strong> <span class="float-right"><strong id="total_nonstat"><?php echo e($total_nonstat); ?></strong></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div>
                            <table class="table table-bordered">
                                <tfoot class="table-danger">
                                    <tr class="table-secondary">
                                        <td><strong>NET PAY </strong> <span class="float-right" id="net_pay"><?php echo e($salary-$total_tax-$total_nonstat); ?></span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">Save</button>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script>
    $(document).ready(function() {
        $('.calc_value,#basic_salary').on('change', function() {
            calculatePayslipTotals();
            calculatePayslipTotals();
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\payroll\resources\views/employees/generatePayslip.blade.php ENDPATH**/ ?>