@extends('layout.auth')

@section('content')
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="{{asset('img/logo.png')}}" alt=""></a>
    </div>
    <!-- /Account Logo -->
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Staff Reset Password</h3>
            <p class="account-subtitle">Enter your New password</p>
            
            <!-- Account Form -->
            <form action="{{ url('auth/staff-reset-password') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" type="email" name="email" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label>Password <span class="login-danger">*</span></label>
                    <input type="password" class="form-control pass-input  @error('password') is-invalid @enderror" name="password" required autofocus>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm password <span class="login-danger">*</span></label>
                    <input type="password" class="form-control pass-confirm @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autofocus>
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>
            </form>
            <!-- /Account Form -->
            
        </div>
    </div>
</div>
@endsection