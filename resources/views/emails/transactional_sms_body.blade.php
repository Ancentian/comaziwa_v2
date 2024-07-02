@if($type == 'employee_registration')
Dear {{$data['name']}}, {{PHP_EOL}}
Welcome aboard! Your self-service account has been created. You can now access your payroll information at your convenience. Here are your login details:{{PHP_EOL}}
Username: {{$data['email']}}{{PHP_EOL}}{{PHP_EOL}}
Temporary Password: {{$data['password']}}{{PHP_EOL}}
Please click the link below to get started:{{PHP_EOL}}
{{url('staff/login')}}{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{company()->mycompany()->name}}
@elseif($type == 'new_signup')
Dear {{$data['name']}},{{PHP_EOL}}
Thank you for signing up with us. We're excited to have you on board and look forward to serving your payroll and ERP needs.
Here are your login details:{{PHP_EOL}}
Username: {{$data['email']}}{{PHP_EOL}}
Please click the link below to access your ERP dashboard:{{PHP_EOL}}
{{url('auth/login')}}{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{env('APP_NAME')}}
@elseif($type == 'subscription_paid')
Dear {{$data['name']}},{{PHP_EOL}}
Thank you for purchasing our subscription plan. We're excited to start this journey with you. Here are the details:
- Subscription Plan: {{$data['subscription']}} {{PHP_EOL}}
- Billing Amount: {{num_format($data['amount'])}}{{PHP_EOL}}
- Billing Date: {{format_date(date('Y-m-d'))}}{{PHP_EOL}}
- Next Billing Date: {{format_date($data['date'])}}{{PHP_EOL}}
You can access your account and manage your subscription at {{url('dashboard/subscriptions')}}.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{env('APP_NAME')}}
@elseif($type == 'password_change')
Dear {{$data['name']}},{{PHP_EOL}}
This is a confirmation that your password has been successfully changed. If you did not make this change, please contact us immediately.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'subscription_renewal')
Dear {{$data['name']}},{{PHP_EOL}}
Thank you for renewing your subscription. We appreciate your continued trust in our services.
Your subscription is set to renew on {{format_date($data['date'])}}.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{env('APP_NAME')}}!
@elseif($type == 'subscription_reminder')
Dear {{$data['name']}},{{PHP_EOL}}
We wanted to notify you that your {{$data['company']}} subscription is expiring on {{format_date($data['date'])}} . Don't miss out on the benefits of our services!{{PHP_EOL}}
To renew your subscription, please log in to your account at {{url('dashboard/subscriptions')}}{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{env('APP_NAME')}}!
@elseif($type == 'sending_payslip')
Dear {{$data['name']}},{{PHP_EOL}}
Your payslip for the month of {{$data['period']}} is now available in your account. You can download it here: {{$data['download_link']}}.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'leave_requested')
Dear {{$data['supervisor']}},{{PHP_EOL}}
You have a new Leave Request from: {{$data['employee']}} for {{ $data['leave_type'] }} starting from {{$data['start_date']}} to {{$data['end_date']}}{{PHP_EOL}}
Kindly review the details and approve or decline the request.{{PHP_EOL}}
Best regards,{{PHP_EOL}}
{{$data['company']}},{{PHP_EOL}}
@elseif($type == 'leave_applied')
Dear {{$data['name']}},{{PHP_EOL}}
We have received your leave request for {{ $data['leave_type'] }} starting from {{$data['start_date']}} to {{$data['end_date']}}, and it is currently under review. We will get back to you soon.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'leave_approved')
Dear {{$data['name']}},{{PHP_EOL}}
Your leave request for {{ $data['leave_type'] }} starting from {{$data['start_date']}} to {{$data['end_date']}} has been approved. Enjoy your time off!{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'leave_declined')
Dear {{$data['name']}},{{PHP_EOL}}
We regret to inform you that your leave request for {{ $data['leave_type'] }} starting from {{$data['start_date']}} to {{$data['end_date']}} has been rejected. Please contact HR for more information.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'upcoming_training')
Dear {{$data['name']}},{{PHP_EOL}}
Congratulations! You've been nominated to participate in our upcoming training program.{{PHP_EOL}}
Here are the details:{{PHP_EOL}}
- Training Program: {{$data['training']}}{{PHP_EOL}}
- Training Vendor: {{$data['vendor']}}{{PHP_EOL}}
- Date: {{$data['start_date']}} to {{$data['end_date']}}{{PHP_EOL}}
- Time: {{$data['time']}}{{PHP_EOL}}
- Location: {{$data['location']}}{{PHP_EOL}}
Your participation is a testament to your dedication to professional growth. Further instructions and materials will be provided as the training date approaches.{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@elseif($type == 'expense_requested')
Dear {{$data['supervisor']}},{{PHP_EOL}}
You have a new expense request from: {{$data['name']}}{{PHP_EOL}}
- Expense Type: {{$data['expense_type']}}{{PHP_EOL}}
- Date: {{$data['date']}}{{PHP_EOL}}
- Amount: {{$data['amount']}}{{PHP_EOL}}
- Purpose: {{$data['purpose']}}{{PHP_EOL}}
Best Regards,{{PHP_EOL}}
{{$data['company']}}
@endif