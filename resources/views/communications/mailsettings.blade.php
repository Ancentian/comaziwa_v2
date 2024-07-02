@extends('layout.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Communications</a></li>
                <li class="breadcrumb-item active">Email Settings</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Email Settings</h4>
            </div>
            <div class="card-body">           
                <form id="email_seetings" action="{{url('communications/store_mailSettings')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email From Address</label>
                                <input class="form-control" value="{{!empty($settings) ? $settings->email_from : null}}" name="email_from" type="email">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Emails From Name</label>
                                <input class="form-control" value="{{!empty($settings) ? $settings->name : null}}" name="name" type="text">
                            </div>
                        </div>
                    </div>
                    <h4 class="page-title m-t-30">SMTP Email Settings</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP HOST</label>
                                <input class="form-control"value="{{!empty($settings) ? $settings->host : null}}" name="host" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP USER</label>
                                <input class="form-control" value="{{!empty($settings) ? $settings->smtp_user : null}}" name="smtp_user" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP PASSWORD</label>
                                <input class="form-control"value="{{!empty($settings) ? $settings->password : null}}" name="password" type="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP PORT</label>
                                <input class="form-control" value="{{!empty($settings) ? $settings->port : null}}" name="port" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>SMTP Security</label>
                                <select class="select" value="{{!empty($settings) ? $settings->smtp_security : null}}" name="smtp_security">
                                    <option>None</option>
                                    <option>SSL</option>
                                    <option>TLS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save &amp; update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        
    </div>
</div>

@endsection