@if($type == 'employee_registration')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            Welcome to {{company()->mycompany()->name}}! We are thrilled to have you on board. Your self-service account is ready for you to access all our HR and payroll features. Here are your login details:
        <br>
            Username: <b>{{$data['email']}}</b>
        <br>
            Temporary Password: <b>{{$data['password']}}</b>
        <br>
            Please click the link below to get started:
        <br>
            <a href="{{url('staff/login')}}">Get started</a>
        <br>
            If you have any questions or need assistance, feel free to contact our support team at info@ghpayroll.net . We look forward to working with you! <br>
            Best regards,
        <br>
        {{company()->mycompany()->name}}
    </p>
@elseif($type == 'new_signup')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            Thank you for choosing {{env('APP_NAME')}} for your ERP needs. We're excited to have you on board! Your account has been successfully created, and you can start managing your business processes immediately.
            Here are your login details:
        <br>
            Username: <b>{{$data['email']}}</b>
        <br>
            Please click the link below to access your ERP dashboard:
        <br>
            <a href="{{url('auth/login')}}">Get started</a>
        <br>
        If you have any questions or require assistance, don't hesitate to contact our support team at  info@ghpayroll.net . We're here to help you succeed.
        <br>
        Warm regards,
        <br>
        <b>{{env('APP_NAME')}}</b>
    </p>
@elseif($type == 'subscription_paid')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            Thank you for choosing <b>{{env('APP_NAME')}}</b>! Your subscription purchase has been successful. Here are the details:
            - Subscription Plan: <b>{{$data['subscription']}}</b> 
        <br>
            - Billing Amount: <b>{{num_format($data['amount'])}}</b>
        <br>
            - Billing Date: <b>{{format_date(date('Y-m-d'))}}</b>
        <br>
            - Next Billing Date: <b>{{format_date($data['date'])}}</b>
        <br>
            You can access your account and manage your subscription at <a href="{{url('dashboard/subscriptions')}}">Manage subscriptions</a>. If you have any questions or need assistance, please contact our support team at info@ghpayroll.net .
        <br>
            Best regards,
        <br>
        <b>{{env('APP_NAME')}}</b>
    </p>
@elseif($type == 'password_change')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            This is a confirmation that your password for {{$data['company']}} has been successfully changed. If you did not initiate this change, please contact us immediately at info@ghpayroll.net
        <br>
            Thank you for using our services.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'subscription_renewal')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We hope you've been enjoying your subscription with {{env('APP_NAME')}}. This is a friendly reminder that your subscription is set to renew on {{format_date($data['date'])}}.
        <br>
            To continue enjoying our services, no action is required; we'll automatically renew your subscription. If you wish to make any changes, please log in to your account at <a href="{{url('dashboard/subscriptions')}}">Manage subscriptions</a>. For questions or assistance, reach out to our support team at info@ghpayroll.net 
        <br>
            Thank you for choosing <b>{{env('APP_NAME')}}</b>!
    </p>
@elseif($type == 'subscription_reminder')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We wanted to notify you that your {{$data['company']}} subscription is expiring on {{format_date($data['date'])}} . Don't miss out on the benefits of our services!
        <br>
            To renew your subscription, please log in to your account at <a href="{{url('dashboard/subscriptions')}}">Manage subscriptions</a>. If you have any questions or need assistance, feel free to contact our support team at info@ghpayroll.net.
        <br>
            Best regards,
        <br>
            <b>{{env('APP_NAME')}}</b>!
    </p>
@elseif($type == 'sending_payslip')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            Attached is your payslip for the month of {{$data['period']}}. You can download it here: <a href="{{$data['download_link']}}">Download Here</a>.
        <br>
            If you have any questions regarding your payslip or need further assistance, please don't hesitate to reach out to our payroll team.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'leave_requested')
    <p>
        Dear <b>{{$data['supervisor']}}</b>,
        <br>
            You have a new Leave Request from: <b>{{$data['employee']}}</b> for {{ $data['leave_type'] }} starting from <b>{{$data['start_date']}}</b> to <b>{{$data['end_date']}}</b>.
        <br>
            Kindly review the details and approve or decline the request.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'leave_applied') 
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We have received your leave request starting from <b>{{$data['start_date']}}</b> to <b>{{$data['end_date']}}</b>. Your request is now being reviewed by our HR team. You will be notified once a decision is made.
        <br>
            If you have any questions or need further assistance, please contact our HR department.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'leave_approved')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We're pleased to inform you that your leave request for <b>{{ $data['leave_type'] }}</b> starting from <b>{{$data['start_date']}}</b> to <b>{{$data['end_date']}}</b> has been approved. Enjoy your well-deserved time off!
        <br>
            If you have any questions or need further assistance, please contact our HR department.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'leave_declined')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We regret to inform you that your leave request for <b>{{ $data['leave_type'] }}</b> starting from <b>{{$data['start_date']}}</b> to <b>{{$data['end_date']}}</b> has denied.
        <br>
            If you have any questions or need further assistance, please contact our HR department.
        <br>
            Best regards,
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'upcoming_training')
    <p>
        Dear <b>{{$data['name']}}</b>,
        <br>
            We're excited to inform you that you've been nominated for an upcoming training program. Here are the details:
        <br>
            - Training Program: <b>{{$data['training']}}</b>
        <br>
            - Training Vendor: <b>{{$data['vendor']}}</b>
        <br>
            - Date: <b>{{$data['start_date']}}</b> to <b>{{$data['end_date']}}</b>
        <br>
            - Time: <b>{{$data['time']}}</b>
        <br>
            - Location: <b>{{$data['location']}}</b>
        <br>
            Your participation is a testament to your dedication to professional growth. Further instructions and materials will be provided as the training date approaches.
        <br>
            If you have any questions or require additional information, please contact our training coordinator at <b>{{$data['email']}}</b>.
        <br>
            Congratulations!
        <br>
            <b>{{$data['company']}}</b>
    </p>
@elseif($type == 'expense_requested')
    <p>
        Dear <b>{{$data['supervisor']}}</b>,
        <br>
            You have a new expense request from: <b>{{$data['name']}}</b>
        <br>
            - Expense Type: <b>{{$data['expense_type']}}</b>
        <br>
            - Date: <b>{{$data['date']}}</b>
        <br>
            - Amount: <b>{{$data['amount']}}</b>
        <br>
            - Purpose: <b>{{$data['purpose']}}</b>
        <br>
            <b>{{$data['company']}}</b>
    </p>
@endif
<p>
    <img src="{{ asset('img/ghana.png') }}" width="80" height="40">
    <strong>Powered By JPCann</strong>
</p>