@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active"> Balance Sheet</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Pay Period <span class="text-danger">*</span></label>
            <input class="form-control" type="month" name="pay_period" value="{{ date('Y-m') }}" id="pay_period">
        </div>
    </div>

    <div id="items"></div>
<div id="deductions"></div>
<div id="payments"></div>
<div id="company"></div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="balance-sheet-title">Balance Sheet for the month of Feb 2024</h4>
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
                            <h3 class="text-uppercase">Balance Sheet #2024-02</h3>
                            <ul class="list-unstyled">
                                <li>Report Month: <span>February, 2024</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Income Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Income</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Milk Payments</strong> <span class="float-right">$12,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Store Sales</strong> <span class="float-right">$8,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Income</strong> <span class="float-right"><strong>$20,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Expenses Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Expenses</strong></h4>
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
                                        <td><strong>Total Expenses</strong> <span class="float-right"><strong>$11,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Deductions Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Deductionsss</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Individual Deductions</strong> <span id="individual_deductions" class="float-right">0</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>General Deductions</strong> <span id="general_deductions" class="float-right">0</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Deductions</strong> <span id="total_deductions" class="float-right"><strong>0</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                

                <!-- Consumers Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Consumers</strong></h4>
                            {{-- <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Consumer A</strong> <span class="float-right">$3,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Consumer B</strong> <span class="float-right">$2,500</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Consumer C</strong> <span class="float-right">$2,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Payments from Consumers</strong> <span class="float-right"><strong>$7,500</strong></span></td>
                                    </tr>
                                </tbody>
                            </table> --}}
                            <div id="consumers"></div>
                        </div>
                    </div>
                </div>

                <!-- Assets Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Assets</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Cash</strong> <span class="float-right">$10,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Inventory</strong> <span class="float-right">$8,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Property</strong> <span class="float-right">$15,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Assets</strong> <span class="float-right"><strong>$33,000</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Liabilities Section -->
                <div class="row">
                    <div class="col-sm-12 m-b-20">
                        <div>
                            <h4 class="m-b-10"><strong>Liabilities</strong></h4>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Outstanding Loans</strong> <span class="float-right">$4,000</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payables</strong> <span class="float-right">$1,500</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Liabilities</strong> <span class="float-right"><strong>5,500</strong></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Net Balance -->
                <div class="row">
                    <div class="col-sm-12">
                        <p><strong>Net Balance: $7,500</strong> (Seven thousand five hundred only.)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script>
    // $(document).ready(function() {
    //     $('#pay_period').on('change', function(e) {
    //         const payPeriod = $('#pay_period').val(); // Get the value of the pay_period input

    //         $.ajax({
    //             url: "{{ route('accounting.balance-sheet') }}",
    //             type: 'GET',
    //             data: {
    //                 // _token: '{{ csrf_token() }}', // Include CSRF token for security
    //                 pay_period: payPeriod // Send the pay_period value
    //             },
    //             success: function(response) {
    //                 console.log("Success:", response);
                    
    //                 // Generate table for items
    //                 let itemsTable = '<table border="1" class="table table-bordered"><thead><tr><th>ID</th><th>Item Name</th><th>Quantity</th><th>Price</th><th>Center Name</th></tr></thead><tbody>';
    //                 response.items.forEach(item => {
    //                     itemsTable += `<tr>
    //                         <td>${item.id}</td>
    //                         <td>${item.item_name}</td>
    //                         <td>${item.quantity}</td>
    //                         <td>${item.price}</td>
    //                         <td>${item.center_name}</td>
    //                     </tr>`;
    //                 });
    //                 itemsTable += '</tbody></table>';
    //                 $('#items').html(itemsTable);

    //                 // Generate table for deduction deductions
    //                 let deductionsTable = '<table border="1" class="table table-bordered"><thead><tr><th>ID</th><th>Deduction Name</th><th>Amount</th><th>Date</th></tr></thead><tbody>';
    //                 response.deductions.forEach(deduction => {
    //                     deductionsTable += `<tr>
    //                         <td>${deduction.deduction_name}</td>
    //                         <td>${deduction.amount}</td>
    //                         <td>${deduction.date}</td>
    //                     </tr>`;
    //                 });
    //                 deductionsTable += '</tbody></table>';
    //                 $('#deductions').html(deductionsTable);

    //                 // Generate table for payments
    //                 let paymentsTable = '<table border="1" class="table table-bordered"><thead><tr><th>ID</th><th>Farmer Name</th><th>Center Name</th><th>Amount</th><th>Pay Period</th></tr></thead><tbody>';
    //                 if (response.payments) {
    //                     paymentsTable += `<tr>
    //                         <td>${response.payments.id}</td>
    //                         <td>${response.payments.fname} ${response.payments.lname}</td>
    //                         <td>${response.payments.center_name}</td>
    //                         <td>${response.payments.amount}</td>
    //                         <td>${response.payments.pay_period}</td>
    //                     </tr>`;
    //                 }
    //                 paymentsTable += '</tbody></table>';
    //                 $('#payments').html(paymentsTable);


    //                 // Display company info
    //                 let companyInfo = '<table border="1" class="table table-bordered"><thead><tr><th>Company Name</th><th>Location</th></tr></thead><tbody>';
    //                 if (response.company) {
    //                     companyInfo += `<tr>
    //                         <td>${response.company.name}</td>
    //                         <td>${response.company.location}</td>
    //                     </tr>`;
    //                 }
    //                 companyInfo += '</tbody></table>';
    //                 $('#company').html(companyInfo);
    //             },
    //             error: function(xhr) {
    //                 console.error('Error fetching data:', xhr.responseText);
    //             }
    //         });
    //     });
    // });
    $(document).ready(function() {
        $('#pay_period').on('change', function(e) {
            const payPeriod = $('#pay_period').val(); // Get the value of the pay_period input

            $.ajax({
                url: "{{ route('accounting.balance-sheet') }}",
                type: 'GET',
                data: {
                    pay_period: payPeriod // Send the pay_period value
                },
                success: function(response) {
                    console.log("Success:", response);

                    // Parse deductions values to respective fields by ID
                    $('#individual_deductions').text(`${(response.deductions?.total_individual_amount ?? 0).toLocaleString()}`);
                    $('#general_deductions').text(`${(response.deductions?.total_general_amount ?? 0).toLocaleString()}`);
                    $('#total_deductions').text(`${(response.deductions?.total_deductions ?? 0).toLocaleString()}`);


                    // Generate table for items
                    // let itemsTable = '<table border="1" class="table table-bordered"><thead><tr><th>ID</th><th>Item Name</th><th>Quantity</th><th>Price</th><th>Center Name</th></tr></thead><tbody>';
                    // response.items.forEach(item => {
                    //     itemsTable += `<tr>
                    //         <td>${item.id}</td>
                    //         <td>${item.item_name}</td>
                    //         <td>${item.quantity}</td>
                    //         <td>${item.price}</td>
                    //         <td>${item.center_name}</td>
                    //     </tr>`;
                    // });
                    // itemsTable += '</tbody></table>';
                    // $('#items').html(itemsTable);

                    // Generate table for Consumers
                    let consumersTable = '<table border="1" class="table table-bordered"><thead><tr><th>Consumer</th><th>Amount</th></tr></thead><tbody>';
                    response.consumers.forEach(consumer => {
                        consumersTable += `<tr>
                            <td>${consumer.category_name}</td>
                            <td>${consumer.total_consumption}</td>
                        </tr>`;
                    });
                    consumersTable += '</tbody></table>';
                    $('#consumers').html(consumersTable);

                    // Generate table for payments
                    let paymentsTable = '<table border="1" class="table table-bordered"><thead><tr><th>ID</th><th>Farmer Name</th><th>Center Name</th><th>Amount</th><th>Pay Period</th></tr></thead><tbody>';
                    if (response.payments) {
                        paymentsTable += `<tr>
                            <td>${response.payments.id}</td>
                            <td>${response.payments.fname} ${response.payments.lname}</td>
                            <td>${response.payments.center_name}</td>
                            <td>${response.payments.amount}</td>
                            <td>${response.payments.pay_period}</td>
                        </tr>`;
                    }
                    paymentsTable += '</tbody></table>';
                    $('#payments').html(paymentsTable);

                    // Display company info
                    // let companyInfo = '<table border="1" class="table table-bordered"><thead><tr><th>Company Name</th><th>Location</th></tr></thead><tbody>';
                    // if (response.company) {
                    //     companyInfo += `<tr>
                    //         <td>${response.company.name}</td>
                    //         <td>${response.company.location}</td>
                    //     </tr>`;
                    // }
                    // companyInfo += '</tbody></table>';
                    // $('#company').html(companyInfo);
                },
                error: function(xhr) {
                    console.error('Error fetching data:', xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
