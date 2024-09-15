
<?php
class Email {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Method to schedule a new email
    public function scheduleEmail($recipientEmail, $subject, $body, $scheduledTime) {
        $sql = "INSERT INTO scheduled_emails (recipient_email, subject, body, scheduled_time, status, attempts)
                VALUES (?, ?, ?, ?, 'pending', 0)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$recipientEmail, $subject, $body, $scheduledTime]);
    }

    // Method to get all scheduled emails
    public function getAllScheduledEmails() {
        $sql = "SELECT * FROM scheduled_emails";
        $stmt = $this->db->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    // Method to get all pending emails that are ready to be sent
    public function getPendingEmails() {
        $sql = "SELECT * FROM scheduled_emails WHERE status = 'pending' AND scheduled_time <= NOW()";
        $stmt = $this->db->query($sql);
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    // Method to send an email
    public function sendEmail($id, $recipientEmail, $subject, $body) {
        // Use PHP's mail function or SMTP to send the email
        $headers = "From: no-reply@example.com";
        return mail($recipientEmail, $subject, $body, $headers);
    }

    // Method to update the status of an email (e.g., 'sent', 'failed')
    public function updateStatus($id, $status) {
        $sql = "UPDATE scheduled_emails SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // Method to increment the number of attempts to send an email
    public function incrementAttempts($id) {
        $sql = "UPDATE scheduled_emails SET attempts = attempts + 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}