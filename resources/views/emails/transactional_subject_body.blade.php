@if($type == 'employee_registration')
    Welcome to Our Payroll System!
@elseif($type == 'new_signup')
    Welcome to {{env('APP_NAME')}}
@elseif($type == 'subscription_paid')
    Subscription Plan Purchase Confirmation
@elseif($type == 'password_change')
    Your {{$data['company']}} Password Has Been Successfully Changed
@elseif($type == 'subscription_renewal')
    Renewal Reminder for Your {{env('APP_NAME')}} Subscription
@elseif($type == 'subscription_reminder')
    Your Subscription is Expiring Soon.
@elseif($type == 'sending_payslip')
    Your Payslip for the Month of {{$data['period']}}
 @elseif($type == 'leave_requested')
    New Leave Request
@elseif($type == 'leave_applied')
    Leave Request Received
@elseif($type == 'leave_approved')
    Leave Request Approved
@elseif($type == 'leave_declined')
    Leave Request Rejected
@elseif($type == 'upcoming_training')
    You've Been Nominated for Upcoming Training!
@elseif($type == 'expense_requested')
    You Have a New Expense Request!
@endif