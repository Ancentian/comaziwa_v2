

<?php $__env->startSection('content'); ?>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Profit and Loss Statement</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="profit-loss-title">Profit and Loss Statement for the month of Feb 2024</h4>
                <div class="row">
                    <div class="col-sm-6 m-b-20">
                        <img src="assets/img/logo2.png" class="inv-logo" alt="">
                        <ul class="list-unstyled mb-0">
                            <li>Milk Cooperative</li>
                            <li>123 Dairy Lane,</li>
                            <li>Farmville, CA, 12345</li>
                        </ul>
                    </div>
                    <div class="col-sm-6 m-b-20">
                        <div class="invoice-details">
                            <h3 class="text-uppercase">Profit and Loss Statement #2024-02</h3>
                            <ul class="list-unstyled">
                                <li>Report Month: <span>February, 2024</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Revenue Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Revenue</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Milk Payments</strong> <span class="float-right">$12,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Store Sales</strong> <span class="float-right">$8,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Revenue</strong> <span class="float-right"><strong>$20,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cost of Goods Sold (COGS) Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Cost of Goods Sold (COGS)</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Raw Materials</strong> <span class="float-right">$4,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Production Costs</strong> <span class="float-right">$3,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total COGS</strong> <span class="float-right"><strong>$7,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Gross Profit Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Gross Profit</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Gross Profit</strong> <span class="float-right"><strong>$13,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Operating Expenses Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Operating Expenses</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Operational Costs</strong> <span class="float-right">$5,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Maintenance</strong> <span class="float-right">$2,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Salaries</strong> <span class="float-right">$3,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Other Expenses</strong> <span class="float-right">$1,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Operating Expenses</strong> <span class="float-right"><strong>$11,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Net Profit Section -->
                <div class="row">
                    <div class="col-sm-12">
                        <div>
                            <h4 class="m-b-10"><strong>Net Profit</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Net Profit</strong> <span class="float-right"><strong>$2,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/companies/accounting/profit-and-loss.blade.php ENDPATH**/ ?>