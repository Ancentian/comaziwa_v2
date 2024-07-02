@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Payments</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_payment"><i class="fa fa-plus"></i> Add Paymment</a>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">	
            <table class="table table-striped custom-table datatable mb-0">
                <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Client</th>
                        <th>Payment Type</th>
                        <th>Paid Date</th>
                        <th>Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="invoice-view.html">#INV-0001</a></td>
                        <td>
                            <h2><a href="#">Global Technologies</a></h2>
                        </td>
                        <td>Paypal</td>
                        <td>8 Feb 2019</td>
                        <td>$500</td>
                    </tr>
                    <tr>
                        <td><a href="invoice-view.html">#INV-0002</a></td>
                        <td>
                            <h2><a href="#">Delta Infotech</a></h2>
                        </td>
                        <td>Paypal</td>
                        <td>8 Feb 2019</td>
                        <td>$500</td>
                    </tr>
                    <tr>
                        <td><a href="invoice-view.html">#INV-0003</a></td>
                        <td>
                            <h2><a href="#">Cream Inc</a></h2>
                        </td>
                        <td>Paypal</td>
                        <td>8 Feb 2019</td>
                        <td>$500</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="add_payment" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Payment Plan</label>
                                <select name="" class="select">
                                    <option>Gold</option>
                                    <option>Silver</option>
                                    <option>Bronze</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input class="form-control" name="amount" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Payment Mode</label>
                                <select name="" class="select">
                                    <option>Paypal</option>
                                    <option>Bank Wire</option>
                                    <option>Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Transaction ID <span class="text-danger">*</span></label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add User Modal -->

@endsection

