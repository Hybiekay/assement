<?php
require '../layout/header.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actions']) && $_POST['actions'] === 'login') {
    // Extract form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
  

    require '../../controllers/UserController.php'; // Adjust path as needed

    // Instantiate the controller and register the user
    $userController = new UserController();
    $registrationSuccess = $userController->login($email, $password, );

    // If successful, redirect to login or display success
    if ($registrationSuccess) {
        $_SESSION['success'] = 'login successful!';
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
    <input type="hidden" name="actions" value="register">

    <label for="email">Email:</label>
    <input type="email" name="email" value="hybie@gmail.com" required>

    <label for="password">Password:</label>
    <input type="password" name="password" value="password" required>

 
    <input type="submit" value="Login">
</form>

<p>Already have an account? <a href="/views/auth/register.php">Login</a></p>

<?php require '../layout/footer.php'; ?>
