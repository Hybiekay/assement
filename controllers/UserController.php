<?php
session_start(); // Start the session to handle session variables
require_once __DIR__ . '/../config/config.php';
require_once  __DIR__ .  '/../models/User.php';  // Include the User model

class UserController {
    private $db;
    private $user;

    public function __construct() {
        // Initialize the database connection using the parent's getConnection method
 
        // Instantiate the User model
        $this->user = new User();
    }

    // Register new user
    public function register($email, $password, $confirmPassword) {
        // Validate input
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'All fields are required.';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Invalid email format.';
            return false;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Passwords do not match.';
            return false;
        }

        // Register user using the User model
        if ($this->user->register($email, $password)) {
            $_SESSION['success'] = 'Registration successful! Please log in.';
            return true;
        } else {
            $_SESSION['error'] = 'Registration failed. Try again later.';
            return false;
        }
    }

    // Login user
    public function login($email, $password) {
        // Validate input
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email and password are required.';
            return false;
        }

        // Attempt login using the User model
        if ($this->user->login($email, $password)) {
            $_SESSION['success'] = 'Login successful!';
            return true;
        } else {
            $_SESSION['error'] = 'Invalid credentials. Please try again.';
            return false;
        }
    }

    // Logout user
    public function logout() {
        $this->user->logout();
        $_SESSION['success'] = 'You have successfully logged out.';
        return true;
    }
}
