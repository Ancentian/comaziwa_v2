<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>	
        @include('layout.header')

        <style>
            .table{
                width: 100% !important;
            }
            .select{
                width: 100% !important;
            }
            .dt-buttons{
                margin-left: 25% !important;
            }
            .btn-sm {
              background-color: #8F3A84 !important;
                color: #fff !important;
                height: 30px !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }
        </style>
    </head>

	
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

            @include('companies.staff.layout.navbar')
            @include('companies.staff.layout.sidebar')
								
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
				
					@yield('content')
				
				</div>
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->

        @include('layout.footer')
        @include('layout.components');
        @include('layout.scripts')
        
        @include('flash::message')
        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif

        @yield('javascript')
				
    </body>
</html>