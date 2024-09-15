<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // Include database configuration
require_once  __DIR__ . '/../models/Email.php'; // Include Email model

class EmailController extends Config {
    private $email;

    public function __construct() {
        parent::initialize();
        $this->email = new Email($this->getConnection());
    }

    // Schedule a new email
    public function scheduleEmail() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $recipientEmail = trim($_POST['recipient_email']);
            $subject = trim($_POST['subject']);
            $body = trim($_POST['body']);
            $scheduledTime = trim($_POST['scheduled_time']);

            // Validate email input
            if (empty($recipientEmail) || empty($subject) || empty($body) || empty($scheduledTime)) {
                $_SESSION['error'] = 'All fields are required';
                header('Location: ../views/schedule_email.php');
                return;
            }

            if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Invalid email format';
                header('Location: ../views/schedule_email.php');
                return;
            }

            // Validate if the scheduled time is a future date
            if (strtotime($scheduledTime) <= time()) {
                $_SESSION['error'] = 'Scheduled time must be in the future';
                header('Location: ../views/schedule_email.php');
                return;
            }

            // Schedule the email using the Email model
            if ($this->email->scheduleEmail($recipientEmail, $subject, $body, $scheduledTime)) {
                $_SESSION['success'] = 'Email scheduled successfully';
                header('Location: ../views/schedule_email.php');
            } else {
                $_SESSION['error'] = 'Failed to schedule email, please try again.';
                header('Location: ../views/schedule_email.php');
            }
        }
    }

    // Method to handle sending emails (triggered by cron job)
    public function sendPendingEmails() {
        // Fetch pending emails
        $pendingEmails = $this->email->getPendingEmails();

        foreach ($pendingEmails as $email) {
            $success = $this->email->sendEmail($email['id'], $email['recipient_email'], $email['subject'], $email['body']);
            
            if ($success) {
                $this->email->updateStatus($email['id'], 'sent');
            } else {
                $this->email->incrementAttempts($email['id']);
                if ($email['attempts'] >= 3) {
                    $this->email->updateStatus($email['id'], 'failed');
                }
            }
        }
    }

    // Method to fetch all scheduled emails for display
    public function getAllScheduledEmails() {
        return $this->email->getAllScheduledEmails();
    }
}

// Instantiate the EmailController
$controller = new EmailController();

// Handle scheduling email requests
if (isset($_POST['action']) && $_POST['action'] == 'schedule_email') {
    $controller->scheduleEmail();
}
