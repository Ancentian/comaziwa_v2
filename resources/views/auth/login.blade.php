@extends('layout.auth')

@section('content')
<div class="container">
				
    <!-- Account Logo -->
    <div class="account-logo">
        <a href="#"><img src="{{asset('img/logo.png')}}" alt="Code Sniper Developers"></a>
    </div>
    <!-- /Account Logo -->

    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    
    <div class="account-box">
        <div class="account-wrapper">
            <h3 class="account-title">Login</h3>
            <p class="account-subtitle">Access to our dashboard</p>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
            <!-- Account Form -->
            <form action="{{url('auth/login')}}" method = "POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input class="form-control" type="email" name="email">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label>Password</label>
                        </div>
                        <div class="col-auto">
                            <a class="text-muted" href="{{url('auth/pass-reset')}}">
                                Forgot password?
                            </a>
                        </div>
                    </div>
                    <input class="form-control" type="password" name="password">
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary account-btn" type="submit">Login</button>
                </div>

                <div class="account-footer">
                    <p>New here? <a href="{{url('auth/signup')}}">Signup</a></p>
                </div>
                
            </form>
            <!-- /Account Form -->
            
        </div>
    </div>
</div>
@endsection