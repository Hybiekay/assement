<?php
// cron/sendEmails.php
require_once __DIR__ . '/../config/config.php'; // Include the config file for the database connection
require_once __DIR__ . '/../models/Email.php';  // Include the Email model

// Create a database connection
$db = new Config();


$email = new Email($db);


$pendingEmails = $email->getPendingEmails();

if (!empty($pendingEmails)) {
    foreach ($pendingEmails as $emailData) {
        // Attempt to send the email
        $sent = $email->sendEmail($emailData['id'], $emailData['recipient_email'], $emailData['subject'], $emailData['body']);

        if ($sent) {
            // Update status to 'sent' if the email was sent successfully
            $email->updateStatus($emailData['id'], 'sent');
            echo "Email to {$emailData['recipient_email']} sent successfully.\n";
        } else {
            // Increment the attempt count if sending fails
            $email->incrementAttempts($emailData['id']);
            if ($emailData['attempts'] >= 3) {
                // If 3 attempts failed, mark the email as 'failed'
                $email->updateStatus($emailData['id'], 'failed');
                echo "Email to {$emailData['recipient_email']} failed after 3 attempts.\n";
            } else {
                echo "Email to {$emailData['recipient_email']} failed, retrying...\n";
            }
        }
    }
} else {
    echo "No pending emails to send.\n";
}
