<?php
require '../layout/header.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actions']) && $_POST['actions'] === 'register') {
    // Extract form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    require '../../controllers/UserController.php'; // Adjust path as needed

    // Instantiate the controller and register the user
    $userController = new UserController();
    $registrationSuccess = $userController->register($email, $password, $confirm_password);

    // If successful, redirect to login or display success
    if ($registrationSuccess) {
        $_SESSION['success'] = 'Registration successful!';
        header('Location: login.php'); // Optionally redirect to login
        exit();
    } else {
        // The error message will be set in the session and displayed in the UI
    }
}

?>

<h2>Register</h2>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error-message">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']); // Clear the message after displaying it
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message">
        <?php
        echo $_SESSION['success'];
        unset($_SESSION['success']); // Clear the message after displaying it
        ?>
    </div>
<?php endif; ?>

<form action="register.php" method="post">
    <input type="hidden" name="actions" value="login">

    <label for="email">Email:</label>
    <input type="email" name="email" value="hybie@gmail.com" required>

    <label for="password">Password:</label>
    <input type="password" name="password" value="password" required>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password"value="password" required>

    <input type="submit" value="Register">
</form>

<p>Already have an account? <a href="/views/auth/login.php">Login</a></p>

<?php require '../layout/footer.php'; ?>
