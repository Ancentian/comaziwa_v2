<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .user-img{
            height: 80px !important;
            width: 80px !important;
            aspect-ratio: 1; 
            border-radius: 50%;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $guard = auth()->getDefaultDriver();
            if(empty(auth()->guard('employee')->user())){
                $tenant_id = auth()->user()->id;
            }else{
                $tenant_id = optional(auth()->guard('employee')->user())->tenant_id;
            }
            
            $company = \App\Models\CompanyProfile::where('tenant_id', $tenant_id)->first();
        @endphp
        @if(!empty($company->logo))
            <span class=""><img src="{{ asset('storage/logos/'.$company->logo) }}" alt="" class="rounded-circle user-img"></span>
        @endif
                            
        <h3>{{$subject}}</h3>
        <p>{!! str_replace("\n", "<br>",$msg) !!}</p>
    </div>
</body>
</html>
