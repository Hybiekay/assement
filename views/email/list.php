<?php
session_start();
// database configuration
require_once  '../../controllers/EmailController.php'; // Include Email model

// Instantiate the EmailController
$controller = new EmailController();

// Fetch all scheduled emails
$emails = $controller->getAllScheduledEmails();
?>

<?php require '../layout/header.php'; ?>

<h2>Scheduled Emails</h2>

<table>
    <thead>
        <tr>
            <th>Recipient</th>
            <th>Subject</th>
            <th>Scheduled Time</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($emails)): ?>
            <?php foreach ($emails as $email): ?>
                <tr>
                    <td><?= htmlspecialchars($email['recipient_email']) ?></td>
                    <td><?= htmlspecialchars($email['subject']) ?></td>
                    <td><?= htmlspecialchars($email['scheduled_time']) ?></td>
                    <td><?= htmlspecialchars($email['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No scheduled emails found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require '../layout/footer.php'; ?>
