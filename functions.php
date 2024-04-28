<?php
// Utility function to establish a secure connection to MySQL/MariaDB
function get_db_connection() {
    // MySQL/MariaDB database configuration
    $servername = "localhost"; // Hostname or IP address
    $username = "root"; // Database username
    $password = " "; // Database password
    $database = "aproject"; // Database name

    try {
        // Connect to MySQL/MariaDB using PDO
        $db = new PDO("mysql:host=$servername;dbname=$database", $username, $password); 
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
        return $db; // Return the database connection
    } catch (PDOException $e) {
        // Handle connection error
        die("Database connection failed: " . $e->getMessage());
    }
}

// Utility function to hash passwords securely
function hash_password($password) {
    // Use bcrypt to hash the password
    return password_hash($password, PASSWORD_BCRYPT);
}

// Utility function to verify a hashed password
function verify_password($password, $hashed_password) {
    // Verify the password with the stored hash
    return password_verify($password, $hashed_password);
}

// Utility function to generate a unique CSRF token
function generate_csrf_token() {
    // Generate a random CSRF token
    return bin2hex(random_bytes(32)); // Secure token generation
}

// Utility function to sanitize user inputs
function sanitize_input($input, $type = 'string') {
    // Sanitize based on the input type
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_SANITIZE_EMAIL);
        case 'int':
            return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        default:
            return filter_var($input, FILTER_SANITIZE_STRING);
    }
}

// Utility function to check if a user is logged in
function is_user_logged_in() {
    session_start(); // Start the session
    return isset($_SESSION['user_id']); // Check if the user ID is set in the session
}

// Utility function to log out a user
function logout_user() {
    session_start(); // Start the session
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
}
?>
