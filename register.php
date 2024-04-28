<?php
require 'config.php'; // Database configuration
require 'functions.php'; // Utility functions (e.g., for password hashing)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!$username || !$email || !$password) {
        // Return error if required fields are empty or invalid
        die("Invalid input. Please try again.");
    }

    // Hash the password securely using bcrypt
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Store user data in the MySQL/MariaDB database
    try {
        // Prepare an SQL statement with parameterized placeholders
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)"); // Ensure 'users' table exists
        
        // Bind values to the placeholders
        $stmt->bind_param("sss", $username, $email, $password_hash); // Parameterized query to prevent SQL injection

        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful! You can now log in.";
        } else {
            echo "Registration failed.";
        }

        $stmt->close(); // Close the statement
    } catch (Exception $e) {
        // Handle exceptions, such as unique constraint violations
        if ($e->getCode() === 1062) { // MySQL unique constraint violation
            echo "Error: Username or email already exists.";
        } else {
            echo "An error occurred: " . $e->getMessage();
        }
    }
}
?>
