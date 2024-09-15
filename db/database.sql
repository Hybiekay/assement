-- Create the 'users' table for storing user information
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Store hashed passwords
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'scheduled_emails' table for storing email schedules
CREATE TABLE IF NOT EXISTS `scheduled_emails` (
  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `recipient_email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `scheduled_time` DATETIME NOT NULL, -- Time when email should be sent
  `status` ENUM('pending', 'sent', 'failed') DEFAULT 'pending', -- Email status
  `attempts` INT(11) DEFAULT 0, -- Number of send attempts
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  -- Foreign key to relate emails to the user who scheduled them
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Insert a test user 
INSERT INTO `users` (`email`, `password`) VALUES
('test@example.com', 'hashed_password_here'); 

-- Example scheduled email data
INSERT INTO `scheduled_emails` (user_id, recipient_email, subject, body, scheduled_time, status, attempts) VALUES
(1, 'john.doe@example.com', 'Meeting Reminder', 'This is a reminder about our meeting scheduled for tomorrow at 10 AM.', '2024-09-16 09:00:00', 'pending', 0),
(1, 'jane.smith@example.com', 'Project Update', 'Here is the latest update on the project. Please review the attached documents.', '2024-09-16 11:00:00', 'pending', 0),
(1, 'alice.jones@example.com', 'Newsletter Subscription', 'Thank you for subscribing to our newsletter. Stay tuned for updates and promotions!', '2024-09-17 08:00:00', 'pending', 0),
(1, 'bob.brown@example.com', 'Password Reset', 'Click the link below to reset your password.', '2024-09-17 14:00:00', 'pending', 0),
(1, 'charlie.davis@example.com', 'Welcome to Our Service', 'Welcome aboard! We are excited to have you with us.', '2024-09-18 10:00:00', 'pending', 0),
(1, 'diana.martin@example.com', 'Invoice for Recent Purchase', 'Your invoice for the recent purchase is attached. Please review and contact us if you have any questions.', '2024-09-18 15:00:00', 'pending', 0),
(1, 'edward.taylor@example.com', 'Account Verification', 'Please verify your account using the link below.', '2024-09-19 12:00:00', 'pending', 0),
(1, 'fiona.wilson@example.com', 'Event Invitation', 'You are invited to our annual event. Please RSVP using the link below.', '2024-09-19 17:00:00', 'pending', 0),
(1, 'george.clark@example.com', 'Survey Request', 'We value your feedback. Please take a moment to complete our survey.', '2024-09-20 09:00:00', 'pending', 0),
(1, 'hannah.morris@example.com', 'Application Confirmation', 'Your application has been received. We will contact you shortly with further details.', '2024-09-20 11:00:00', 'pending', 0);
