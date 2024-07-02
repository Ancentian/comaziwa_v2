<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow">
        <title>@yield('title')</title>
        @include('layout.header')	
    </head>

    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
            <a href="{{url('auth/login')}}" class="btn btn-primary apply-btn">Login as Admin</a>
			<div class="account-content">
                @yield('content')
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		@include('layout.footer')

        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif
		
    </body>
	
</html>