<?php
class User extends Config {
    protected $mysqli;

    public function __construct() {

        $this->mysqli = $this::getConnection() ;
    }

    // Register a new user
    public function register($email, $password) {
        // Hash the password for security
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the query to insert the user into the database
        $stmt = $this->mysqli->query("INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')");
    if ($stmt) {
return true;
    } else {
        return false; }// Return whether the query was successful
    }

    // Login a user
    public function login($email, $password) {
        // Prepare the query to select the user
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        // Verify the password and set session if successful
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }

        return false;
    }

    // Logout the user
    public function logout() {
        session_unset();
        session_destroy();
    }
}
?>
