<?php require '../layout/header.php'; ?>

<h2>Schedule Email</h2>

<form action="/controllers/EmailController.php?action=scheduleEmail" method="post">
    <label for="recipient_email">Recipient Email:</label>
    <input type="email" name="recipient_email" required>
    
    <label for="subject">Subject:</label>
    <input type="text" name="subject" required>
    
    <label for="body">Body:</label>
    <textarea name="body" required></textarea>
    
    <label for="scheduled_time">Scheduled Time:</label>
    <input type="datetime-local" name="scheduled_time" required>
    
    <input type="submit" value="Schedule Email">
</form>

<?php require '../views/layout/footer.php'; ?>
