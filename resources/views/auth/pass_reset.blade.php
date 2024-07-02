@extends('layout.auth')

@section('content')
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="{{asset('img/ghana.png')}}" alt=""></a>
    </div>
    <!-- /Account Logo -->

    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Forgot Password?</h3>
            <p class="account-subtitle">Enter your email to get a password reset link</p>
            
            <!-- Account Form -->
            <form action="{{url('auth/forgot-password')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" name="email" type="email" required>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
                </div>
                <div class="account-footer">
                    <p>Remember your password? <a href="{{url('auth/login')}}">Login</a></p>
                </div>
            </form>
            <!-- /Account Form -->

            
        </div>
    </div>
</div>
@endsection