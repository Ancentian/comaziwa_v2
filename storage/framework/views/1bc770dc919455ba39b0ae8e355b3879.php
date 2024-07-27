<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Receipt</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 12px;
            background-color: #fff;
            font-family: Arial, sans-serif;
        }

        #printbox {
            width: 280px;
            margin: 5pt auto;
            padding: 5px;
            text-align: justify;
        }

        h3 {
            margin: 5pt 0;
            font-size: 12px;
            text-align: center;
        }

        .inv_info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .inv_info th, .inv_info td {
            padding: 4px 6px;
            text-align: left;
            word-wrap: break-word;
        }

        .inv_info th {
            background-color: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .totals {
            font-weight: bold;
        }

        @media print {
            body, html {
                width: 100%;
                height: 100%;
            }

            #printbox {
                width: auto;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div id='printbox'>
    <h3>I N V O I C E</h3>
    <h3><?php echo e($company->name); ?> Cooperative<br><small><?php echo e($payments->center_name); ?> Center<br>Meru, Kenya</small></h3>
    <p style="font-size: 10px; text-align: center; !important">TEL: 0795 974 284<br>Email: info@cowango.org</p>
    &nbsp; 
    
    <table class="inv_info">
        <tr>
            <td>Invoiced To:</td>
            <td><?php echo e($payments->fname . " " . $payments->lname); ?></td>
        </tr>
        <tr>
            <td>Farmer Code:</td>
            <td><?php echo e($payments->farmerID); ?></td>
        </tr>
        <tr>
            <td>Invoice no:</td>
            <td># <?php echo e(str_pad($payments->id, 4, "0", STR_PAD_LEFT)); ?></td>
        </tr>
        <tr>
            <td>Date: </td>
            <td><?php echo e(\Carbon\Carbon::parse($payments->pay_period . '-01')->format('F Y')); ?></td>
        </tr>
    </table>

    <hr>

    <table class="inv_info">
        <tr>
            <th>Instance</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>Total Milk</td>
            <td><?php echo e(num_format($payments->total_milk)); ?></td>
        </tr>
        <tr>
            <td>Rate/Litre</td>
            <td><?php echo e($payments->milk_rate); ?></td>
        </tr>
        <tr>
            <td>Individual Deductions</td>
            <td><?php echo e(num_format($payments->individual_deductions)); ?></td>
        </tr>
        <tr>
            <td>General Deductions</td>
            <td><?php echo e(num_format($payments->general_deductions)); ?></td>
        </tr>
        <tr>
            <td>Store Deductions</td>
            <td><?php echo e(num_format($payments->store_deductions)); ?></td>
        </tr>
        <tr>
            <td>Shares Deduction</td>
            <td><?php echo e(num_format($payments->shares_contribution)); ?></td>
        </tr>
        <tr>
            <td>Total Shares</td>
            <td><?php echo e(num_format($shares->total_shares)); ?></td>
        </tr>
        <?php $totalDeductions = $payments->store_deductions + $payments->individual_deductions + $payments->general_deductions + $payments->shares_contribution; ?>
        <tr class="totals">
            <td>Total Deductions</td>
            <td><?php echo e(num_format($totalDeductions)); ?></td>
        </tr>
        <tr class="totals">
            <td>Gross Pay</td>
            <td><?php echo e(num_format($payments->gross_pay)); ?></td>
        </tr>
        <?php $totalEarned = $payments->gross_pay - $totalDeductions; ?>
        <tr class="totals">
            <td>Total Earned</td>
            <td><?php echo e(num_format($totalEarned)); ?></td>
        </tr>
    </table>

    <?php if($items->isNotEmpty()): ?>
        <hr>
        <h3>Store Sales Items</h3>
        <table class="inv_info">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>@</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalCost = 0; ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-center">
                        <td style="width: 5%;"><?php echo e(++$key); ?></td>
                        <td style="width: 35%;"><?php echo e($item->item_name); ?></td>
                        <td style="width: 10%;"><?php echo e($item->qty); ?></td>
                        <td style="width: 20%;" class="text-right"><?php echo e(num_format($item->unit_cost)); ?></td>
                        <td style="width: 30%;" class="text-right"><?php echo e(num_format($item->total_cost)); ?></td>
                    </tr>
                    <?php $totalCost += $item->total_cost; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="3" class="text-right">Total</td>
                    <td colspan="2" class="text-right"><?php echo e(num_format($totalCost)); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <?php if($individuals->isNotEmpty()): ?>
        <hr>
        <h3>Individual Deductions</h3>
        <table class="inv_info">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Deduction</th>
                    <th>Date</th>
                    <th>Amount</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $totalAmount = 0; ?>
                <?php $__currentLoopData = $individuals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $deduction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-center">
                        <td style="width: 5%;"><?php echo e(++$key); ?></td>
                        <td style="width: 35%;"><?php echo e($deduction->deduction_name); ?></td>
                        <td style="width: 30%;"><?php echo e(format_date($deduction->date)); ?></td>
                        <td style="width: 30%;" class="text-right"><?php echo e(num_format($deduction->amount)); ?></td>
                    </tr>
                    <?php $totalAmount += $deduction->amount; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="2" class="text-right">Total</td>
                    <td colspan="2" class="text-right"><?php echo e(num_format($totalAmount)); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <?php if($generals->isNotEmpty()): ?>
        <hr>
        <h3>General Deductions</h3>
        <table class="inv_info">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Deduction</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalGen = 0; ?>
                <?php $__currentLoopData = $generals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $general): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-center">
                        <td style="width: 5%;"><?php echo e(++$key); ?></td>
                        <td style="width: 35%;"><?php echo e($general->deduction_name); ?></td>
                        <td style="width: 30%;"><?php echo e(format_date($general->date)); ?></td>
                        <td style="width: 30%;" class="text-right"><?php echo e(num_format($general->amount)); ?></td>
                    </tr>
                    <?php $totalGen += $general->amount; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr class="totals">
                    <td colspan="2" class="text-right">Total</td>
                    <td colspan="2" class="text-right"><?php echo e(num_format($totalGen)); ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>

    <hr>
    <table>
        <tr>
            <td>Invoiced by: </td>
            <td></td>
        </tr>
        <tr>
            <td>Stamp: </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <hr>
</div>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</body>
</html>
<?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/payments/print-payslip.blade.php ENDPATH**/ ?>