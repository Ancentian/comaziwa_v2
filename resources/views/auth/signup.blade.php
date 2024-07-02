@extends('layout.auth')

@section('content')
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="{{asset('img/ghana.png')}}" alt="Dreamguy's Technologies"></a>
    </div>
    <!-- /Account Logo -->
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Register</h3>
            <p class="account-subtitle">Access to our dashboard</p>
            
            <!-- Account Form -->
            <form action="{{url('auth/storeUser')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Phone Number  <span class="text-danger">*</span></label>
                    <input class="form-control @error('phone_number') is-invalid @enderror"  name="phone_number" type="number">
                    @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control pass-input  @error('password') is-invalid @enderror" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control pass-confirm @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                    @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <input type="hidden" class="form-control " name="type" value="client" >
                
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Register</button>
                </div>
                <div class="account-footer">
                    <p>Already have an account? <a href="{{url('auth/login')}}">Login</a></p>
                </div>
            </form>
            <!-- /Account Form -->
        </div>
    </div>
</div>
@endsection