@extends('layout.employee-auth')

@section('content')
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="{{asset('img/logo.png')}}" alt=""></a>
    </div>
    <!-- /Account Logo -->

    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Employee Login</h3>
            <p class="account-subtitle">Access to our dashboard</p>
            <!-- Account Form -->
            <form action="{{url('staff/login')}}" method = "POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control  @error('email') is-invalid @enderror" type="email" name="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Password</label>
                        </div>
                        <div class="col-auto">
                            <a class="text-muted" href="{{url('staff/staff-forgot-password')}}">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <input class="form-control  @error('password') is-invalid @enderror" type="password" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Login</button>
                </div>
                
            </form>
            <!-- /Account Form -->
            
        </div>
    </div>
</div>
@endsection