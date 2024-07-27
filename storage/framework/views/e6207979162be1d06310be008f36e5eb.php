<?php if($type == 'employee_registration'): ?>
    Welcome to Our Payroll System!
<?php elseif($type == 'new_signup'): ?>
    Welcome to <?php echo e(env('APP_NAME')); ?>

<?php elseif($type == 'subscription_paid'): ?>
    Subscription Plan Purchase Confirmation
<?php elseif($type == 'password_change'): ?>
    Your <?php echo e($data['company']); ?> Password Has Been Successfully Changed
<?php elseif($type == 'subscription_renewal'): ?>
    Renewal Reminder for Your <?php echo e(env('APP_NAME')); ?> Subscription
<?php elseif($type == 'subscription_reminder'): ?>
    Your Subscription is Expiring Soon.
<?php elseif($type == 'sending_payslip'): ?>
    Your Payslip for the Month of <?php echo e($data['period']); ?>

 <?php elseif($type == 'leave_requested'): ?>
    New Leave Request
<?php elseif($type == 'leave_applied'): ?>
    Leave Request Received
<?php elseif($type == 'leave_approved'): ?>
    Leave Request Approved
<?php elseif($type == 'leave_declined'): ?>
    Leave Request Rejected
<?php elseif($type == 'upcoming_training'): ?>
    You've Been Nominated for Upcoming Training!
<?php elseif($type == 'expense_requested'): ?>
    You Have a New Expense Request!
<?php endif; ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/emails/transactional_subject_body.blade.php ENDPATH**/ ?>