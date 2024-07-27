@php
    $is_admin_configured = optional(auth()->guard('employee')->user())->is_admin_configured;
    $tenant_id = null;
    if ($is_admin_configured == 1 ) {
        $employee_id = optional(auth()->guard('employee')->user())->id;
        $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
    }
@endphp
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
              background-color: #55CE63 !important;
                color: #fff !important;
                height: 30px !important;
                padding-top: 2px !important;
                padding-bottom: 2px !important;
            }

            .table-danger {
                background-color: #F5C6CB !important; /* Light red background */
                 /* Dark red text */
            }
        </style>
    </head>

	
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">

        @if(session('is_admin') == 1)
            @include('companies.staff.layout.navbar')
            @include('companies.staff.layout.sidebar')
        @else
            @include('layout.navbar')
            @include('layout.sidebar')
        @endif
            
								
			<!-- Page Wrapper -->
            <div class="page-wrapper">

                @php
                    $package = \App\Models\Package::find(auth()->user()->package_id);
                    $pp = !empty($package) ?  $package->price : 0;        
                @endphp
			
				<!-- Page Content -->
                <div class="content container-fluid">
                    @if(((strtotime(auth()->user()->expiry_date) - time()) <= (env('ALERT_DAYS')*86400) && (strtotime(auth()->user()->expiry_date) - time()) > 0) && auth()->user()->type == 'client' && $pp > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Your subscription ends on {{date('d/m/Y H:i',strtotime(auth()->user()->expiry_date))}} ! <a href="#" class="renew_subscription">Click here to renew</a>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif
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
    
        @if (!auth()->user()->package_id && auth()->user()->type == 'client' && empty($tenant_id))
            @if($pp > 0 && empty($is_sub))
                <script>
                    $(document).ready(function() {
                        window.location.href = "{{url('dashboard/subscriptions')}}";
                    });
                </script>
            @endif       
        @endif

        @if ((strtotime(auth()->user()->expiry_date) - time()) <= 0 && auth()->user()->type == 'client'  && empty($tenant_id))
            @if($pp > 0 && empty($is_sub))
            <script>
                $(document).ready(function() {
                    $(document).ready(function() {
                        window.location.href = "{{url('dashboard/subscriptions')}}";
                    });
                });
            </script>
            @endif
        @endif
        
        <script>
            $('.renew_subscription').on('click', function () {
                $("#renew_modal").modal('show');
            });
        </script>
        @yield('javascript')
				
    </body>
</html>