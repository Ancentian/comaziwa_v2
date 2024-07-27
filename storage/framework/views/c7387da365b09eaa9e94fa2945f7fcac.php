<?php if($type == 'employee_registration'): ?>
Dear <?php echo e($data['name']); ?>, <?php echo e(PHP_EOL); ?>

Welcome aboard! Your self-service account has been created. You can now access your payroll information at your convenience. Here are your login details:<?php echo e(PHP_EOL); ?>

Username: <?php echo e($data['email']); ?><?php echo e(PHP_EOL); ?><?php echo e(PHP_EOL); ?>

Temporary Password: <?php echo e($data['password']); ?><?php echo e(PHP_EOL); ?>

Please click the link below to get started:<?php echo e(PHP_EOL); ?>

<?php echo e(url('staff/login')); ?><?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e(company()->mycompany()->name); ?>

<?php elseif($type == 'new_signup'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Thank you for signing up with us. We're excited to have you on board and look forward to serving your payroll and ERP needs.
Here are your login details:<?php echo e(PHP_EOL); ?>

Username: <?php echo e($data['email']); ?><?php echo e(PHP_EOL); ?>

Please click the link below to access your ERP dashboard:<?php echo e(PHP_EOL); ?>

<?php echo e(url('auth/login')); ?><?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e(env('APP_NAME')); ?>

<?php elseif($type == 'subscription_paid'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Thank you for purchasing our subscription plan. We're excited to start this journey with you. Here are the details:
- Subscription Plan: <?php echo e($data['subscription']); ?> <?php echo e(PHP_EOL); ?>

- Billing Amount: <?php echo e(num_format($data['amount'])); ?><?php echo e(PHP_EOL); ?>

- Billing Date: <?php echo e(format_date(date('Y-m-d'))); ?><?php echo e(PHP_EOL); ?>

- Next Billing Date: <?php echo e(format_date($data['date'])); ?><?php echo e(PHP_EOL); ?>

You can access your account and manage your subscription at <?php echo e(url('dashboard/subscriptions')); ?>.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e(env('APP_NAME')); ?>

<?php elseif($type == 'password_change'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

This is a confirmation that your password has been successfully changed. If you did not make this change, please contact us immediately.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'subscription_renewal'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Thank you for renewing your subscription. We appreciate your continued trust in our services.
Your subscription is set to renew on <?php echo e(format_date($data['date'])); ?>.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e(env('APP_NAME')); ?>!
<?php elseif($type == 'subscription_reminder'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

We wanted to notify you that your <?php echo e($data['company']); ?> subscription is expiring on <?php echo e(format_date($data['date'])); ?> . Don't miss out on the benefits of our services!<?php echo e(PHP_EOL); ?>

To renew your subscription, please log in to your account at <?php echo e(url('dashboard/subscriptions')); ?><?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e(env('APP_NAME')); ?>!
<?php elseif($type == 'sending_payslip'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Your payslip for the month of <?php echo e($data['period']); ?> is now available in your account. You can download it here: <?php echo e($data['download_link']); ?>.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'leave_requested'): ?>
Dear <?php echo e($data['supervisor']); ?>,<?php echo e(PHP_EOL); ?>

You have a new Leave Request from: <?php echo e($data['employee']); ?> for <?php echo e($data['leave_type']); ?> starting from <?php echo e($data['start_date']); ?> to <?php echo e($data['end_date']); ?><?php echo e(PHP_EOL); ?>

Kindly review the details and approve or decline the request.<?php echo e(PHP_EOL); ?>

Best regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>,<?php echo e(PHP_EOL); ?>

<?php elseif($type == 'leave_applied'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

We have received your leave request for <?php echo e($data['leave_type']); ?> starting from <?php echo e($data['start_date']); ?> to <?php echo e($data['end_date']); ?>, and it is currently under review. We will get back to you soon.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'leave_approved'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Your leave request for <?php echo e($data['leave_type']); ?> starting from <?php echo e($data['start_date']); ?> to <?php echo e($data['end_date']); ?> has been approved. Enjoy your time off!<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'leave_declined'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

We regret to inform you that your leave request for <?php echo e($data['leave_type']); ?> starting from <?php echo e($data['start_date']); ?> to <?php echo e($data['end_date']); ?> has been rejected. Please contact HR for more information.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'upcoming_training'): ?>
Dear <?php echo e($data['name']); ?>,<?php echo e(PHP_EOL); ?>

Congratulations! You've been nominated to participate in our upcoming training program.<?php echo e(PHP_EOL); ?>

Here are the details:<?php echo e(PHP_EOL); ?>

- Training Program: <?php echo e($data['training']); ?><?php echo e(PHP_EOL); ?>

- Training Vendor: <?php echo e($data['vendor']); ?><?php echo e(PHP_EOL); ?>

- Date: <?php echo e($data['start_date']); ?> to <?php echo e($data['end_date']); ?><?php echo e(PHP_EOL); ?>

- Time: <?php echo e($data['time']); ?><?php echo e(PHP_EOL); ?>

- Location: <?php echo e($data['location']); ?><?php echo e(PHP_EOL); ?>

Your participation is a testament to your dedication to professional growth. Further instructions and materials will be provided as the training date approaches.<?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php elseif($type == 'expense_requested'): ?>
Dear <?php echo e($data['supervisor']); ?>,<?php echo e(PHP_EOL); ?>

You have a new expense request from: <?php echo e($data['name']); ?><?php echo e(PHP_EOL); ?>

- Expense Type: <?php echo e($data['expense_type']); ?><?php echo e(PHP_EOL); ?>

- Date: <?php echo e($data['date']); ?><?php echo e(PHP_EOL); ?>

- Amount: <?php echo e($data['amount']); ?><?php echo e(PHP_EOL); ?>

- Purpose: <?php echo e($data['purpose']); ?><?php echo e(PHP_EOL); ?>

Best Regards,<?php echo e(PHP_EOL); ?>

<?php echo e($data['company']); ?>

<?php endif; ?><?php /**PATH C:\laragon\www\comaziwa\resources\views/emails/transactional_sms_body.blade.php ENDPATH**/ ?>