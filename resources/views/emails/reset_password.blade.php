<!DOCTYPE html>
<html>
<head>
    <title>Password Recovery Request</title>
    <style>
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .btn .btn-text {
            color: #fff;
        }
    </style>
</head>
<body>
    <img src="{{ asset('img/ghana.png') }}" width="150" height="80">
    <h1>Password Recovery Request</h1>
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We received a request to reset your password. Please click the link below to set a new password.
        <br>
            <a href="{{ $resetLink }}" class="btn">
                <span class="btn-text">Reset Password</span>
            </a>
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
</body>
</html>
