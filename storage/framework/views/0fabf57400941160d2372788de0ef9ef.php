<?php
    use App\Models\EmployeePayslip;
    $total_allowance = 0;
    $total_benefit = 0;
    $total_stat = 0;
    $total_nonstat = 0;
    
    $allowance_array = [];
    $benefit_array = [];
    $stat_array = [];
    $nonstat_array = [];

?>

<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Payslip Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="post_payslip_form" action="<?php echo e(url('/employees/staff-generate-monthly-payslip')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card bg-info">
                    <h5 >Employee Details</h5>
                </div>
                <div class="row">
                    <table class="table table-striped custom-table">
                        <tr>
                            <th>Employee Name</th>
                            <td><?php echo e($employee->name); ?></td>
                            <th>SSN</th>
                            <td><?php echo e($employee->ssn); ?></td>
                        </tr>
                        <tr>
                            <th>Employee Number</th>
                            <td><?php echo e($employee->staff_no); ?></td>
                            <th>Annual Salary</th>
                            <td><?php echo e($basic_salary*12); ?></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?php echo e($employee->position); ?></td>
                            <th></th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                
                <div class="card bg-info ">
                    <h5 class="mt-2">Payslip Details</h5>
                </div>
               
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-striped custom-table">
                            <tr>
                                <th>Earnings</th>
                                <th>Amount</th>
                            </tr>
                            <tr>
                                <td>Monthly Basic Salary</td>
                                <td><?php echo e($basic_salary); ?></td>
                            </tr>
                            <?php $__currentLoopData = $allowance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                ->where('type','allowance')
                                                                ->where('source_id',$item->id)->first();
                                    if(!empty($itemValue)){
                                        $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                        $total_allowance += $itemVal;
                                        $allowance_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                                    }
                                    
                                ?>
                                
                                    <?php if(!empty($itemVal)): ?>
                                    <tr >
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($itemVal); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $benefit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                ->where('type','benefit')
                                                                ->where('source_id',$item->id)->first();
                                    if(!empty($itemValue)){
                                        $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                        $total_benefit += $itemVal;
                                        $benefit_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                                    }
                                    
                                ?>
                                
                                    <?php if(!empty($itemVal)): ?>
                                    <tr >
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($itemVal); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            

                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table table-striped custom-table">
                            <tr>
                                <th>Deductions</th>
                                <th>Amount</th>
                            </tr>
                            <?php $__currentLoopData = $statutoryDed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                ->where('type','statutory_ded')
                                                                ->where('source_id',$item->id)->first();
                                    if(!empty($itemValue)){
                                        $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                        $total_stat += $itemVal;
                                        $stat_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                                    }
                                    
                                ?>
                                
                                    <?php if(!empty($itemVal)): ?>
                                    <tr >
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($itemVal); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php $__currentLoopData = $non_statutoryded; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $itemValue = EmployeePayslip::where('employee_id',$employee->id)
                                                                ->where('type','nonstatutory_ded')
                                                                ->where('source_id',$item->id)->first();
                                    if(!empty($itemValue)){
                                        $itemVal = !empty($itemValue) ? $itemValue->value : 0;
                                        $total_nonstat += $itemVal;
                                        $nonstat_array[] = ['name' => $item->name,'value' => $itemVal,'id' => $item->id];
                                    }
                                    
                                ?>
                                
                                    <?php if(!empty($itemVal)): ?>
                                    <tr >
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($itemVal); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $salary = $basic_salary + $total_allowance + $total_benefit - $total_stat; 
                                $total_tax = App\Models\TaxCalculator::calculateTax($salary);
                            ?>

                            <tr>
                                <td>PAYE</td>
                                <td><?php echo e($total_tax); ?></td>
                            </tr>
                            


                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table table-striped custom-table">
                            <tr>
                                <th>Total</th>
                                <th><?php echo e($basic_salary + $total_allowance + $total_benefit); ?></th>
                                
                            </tr>
                        </table>
                    </div>

                    <div class="col-sm-6">
                        <table class="table table-striped custom-table">
                            <tr>
                                <th>Total</th>
                                <th><?php echo e($total_tax + $total_stat + $total_nonstat); ?></th>
                                
                            </tr>
                        </table>
                    </div>
                    
                </div>

                <div class="card bg-success">
                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5 >Net Salary</h5>
                                </div>
                                <div class="col-sm-6">
                                    <h5>
                                        <?php echo e($salary-$total_tax-$total_nonstat); ?>

                                    </h5>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                </div>

                
                <input type="hidden" name="employee_id" value="<?php echo e($employee->id); ?>" required>
                <input type="hidden" name="basic_salary" value="<?php echo e($basic_salary); ?>" required>
                <input type="hidden" name="paye" value="<?php echo e($total_tax); ?>" required>
                <input type="hidden" name="net_pay" value="<?php echo e($salary-$total_tax-$total_nonstat); ?>" required>
                <input type="hidden" name="allowances" value="<?php echo e(json_encode($allowance_array)); ?>" required>
                <input type="hidden" name="benefits" value="<?php echo e(json_encode($benefit_array)); ?>" required>
                <input type="hidden" name="statutory_deductions" value="<?php echo e(json_encode($stat_array)); ?>" required>
                <input type="hidden" name="nonstatutory_deductions" value="<?php echo e(json_encode($nonstat_array)); ?>" required>
                

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Pay Period <span class="text-danger">*</span></label>
                        <input class="form-control" type="month" name="pay_period" required>
                    </div>
                </div>
                

                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
            
        $('#post_payslip_form').on('submit', function (e) {
            e.preventDefault();
    
            var form = $(this);
            var frm = this;
            var formData = form.serialize();
            var url = form.attr('action');
    
            console.log(formData)
    
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                success: function (response) {

                    // Handle success response
                    console.log(response);
                    frm.reset();

                    // Close the modal
                    $('#edit_modal').modal('hide');
                    employees_table.ajax.reload();                    
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(error);
                }
            });
        });
    });
    </script><?php /**PATH /home/ghpayroll/base/resources/views/employees/staff_generate_monthly_payslip.blade.php ENDPATH**/ ?>