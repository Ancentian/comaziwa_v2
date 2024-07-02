@extends('layout.app')

@section('content')
@php
    $pass = substr(mt_rand(1000000, 9999999), 0, 8);
@endphp
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Cooperatives</li>
            </ul>
        </div>
        <div class="col-auto float-right ml-auto">
            @if(usercan('add.client'))
                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
            @endif
        </div>
    </div>
</div>
<!-- /Page Header -->



<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <table class="table table-striped custom-table" id="clients_table">

                <thead>
                    <tr>
                        <th class="text-right notexport">Action</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Cooperative</th>
                        <th>Employees</th>
                        <th>Role</th> 
                        <th>Package</th>
                        <th>Expiry Date</th> 
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Add User Modal -->
<div id="add_user" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_clients" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-xl-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <h4 class="text-muted mb-0">Cooperative Admin Details (<small>Contact Person</small>)</h4>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" name="name" type="text">
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input class="form-control" name="email" type="email">
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input class="form-control" name="password" type="password">
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input class="form-control"  type="password" name="password_confirmation">
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" name="phone_number" type="text">
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" value="client" name="type">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Package</label>
                                                <select class="select" name="package_id">
                                                    @foreach ($packages as $key)
                                                        <option value="{{$key->id}}" @if($key->is_system == 1) selected @endif>{{$key->name}}</option>  
                                                    @endforeach
                                                </select>
                                                <span class="modal-error invalid-feedback" role="alert"></span>
                                            </div>
                                        </div>    
                                    </div>          
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 d-flex">
                            <div class="card flex-fill">
                                <div class="card-header">
                                    <h5 class="text-muted mb-0">Cooperative Info</h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cooperative Name</label>
                                                <input class="form-control" value="{{!empty($company) ? $company->name : null}}" name="company_name" type="text" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mobile No.</label>
                                                <input class="form-control" value="{{!empty($company) ? $company->tel_no : null}}" name="company_tel_no" type="tel" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Landline.</label>
                                                <input class="form-control" value="{{!empty($company) ? $company->land_line : null}}" name="company_land_line" type="tel">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>SSN</label>
                                                <input class="form-control" name="company_ssni_est" value="{{!empty($company) ? $company->ssni_est : null}}" type="text" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>TIN</label>
                                                <input class="form-control" name="company_tin" value="{{!empty($company) ? $company->tin : null}}" type="text" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" name="company_address" value="{{!empty($company) ? $company->address : null}}" type="text" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Primary Email</label>
                                                <input class="form-control" type="email"value="{{!empty($company) ? $company->email : null}}" name="company_email" type="text" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Secondary Email</label>
                                                <input class="form-control" type="email"value="{{!empty($company) ? $company->secondary_email : null}}" name="secondary_email" type="text">
                                            </div>
                                        </div>
                
                                        <div class="col-md-4" hidden>
                                            <div class="form-group">
                                                <label>Logo</label>
                                                <input class="form-control" name="logo" type="file" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-4" hidden>
                                            @if(!empty($company->logo))
                                                <span class=""><img src="{{ asset('storage/logos/'.$company->logo) }}" alt="" class="rounded-circle user-img"></span>
                                            @endif
                                        </div>

                                    </div>
                                                                            
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn"><span id="submit_form">Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add User Modal -->



<!-- Delete User Modal -->
<div class="modal custom-modal fade" id="delete_user" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete User</h3>
                    <p>Are you sure want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete User Modal -->

@endsection