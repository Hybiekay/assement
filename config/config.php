<?php
class Config {
    private static $mysqli; // Static property for the connection

    public static function initialize() {
        // Database configuration
        $host = 'localhost';
        $dbname = 'assess';
        $username = 'assess';
        $password = 'LhtQq!vMrmOB46ma';

        // Create a mysqli connection
        self::$mysqli = new mysqli($host, $username, $password, $dbname);

        // Check connection
        if (self::$mysqli->connect_error) {
            die('Database Connection Failed: ' . self::$mysqli->connect_error);
        }
    }

    public static function getConnection() {
        if (self::$mysqli === null) {
            self::initialize(); // Initialize if not already done
        }
        return self::$mysqli;
    }
}
?>
