@extends('layout.app')

@section('content')
<style>
    .user-img{
        height: 50px !important;
        width: 50px !important;
    }
</style>
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                <li class="breadcrumb-item active">Create Company Profile</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Company Profile</h4>
            </div>
            <div class="card-body">
                <form action="{{url('company/storeCompany')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input class="form-control" value="{{!empty($company) ? $company->name : null}}" name="name" type="text" required>
                            </div>
                        </div>

                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input class="form-control" value="{{!empty($company) ? $company->tel_no : null}}" name="tel_no" type="tel" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Landline.</label>
                                <input class="form-control" value="{{!empty($company) ? $company->land_line : null}}" name="land_line" type="tel">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>SSN</label>
                                <input class="form-control" name="ssni_est" value="{{!empty($company) ? $company->ssni_est : null}}" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>TIN</label>
                                <input class="form-control" name="tin" value="{{!empty($company) ? $company->tin : null}}" type="text" required>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" name="address" value="{{!empty($company) ? $company->address : null}}" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Primary Email</label>
                                <input class="form-control"  type="email"value="{{!empty($company) ? $company->email : null}}" name="email" type="text" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Secondary Email</label>
                                <input class="form-control" type="email"value="{{!empty($company) ? $company->secondary_email : null}}" name="secondary_email" type="text">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Logo</label>
                                <input class="form-control" name="logo" type="file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if(!empty($company->logo))
                                <span class=""><img src="{{ asset('storage/logos/'.$company->logo) }}" alt="" class="rounded-circle user-img"></span>
                            @endif
                        </div>

                    </div>
                    
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
