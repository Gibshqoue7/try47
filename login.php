<?php
require 'config.php'; // Database configuration to MySQL
require 'functions.php'; // Utility functions for password verification, etc.

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize user inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!$username || !$password) {
        die("Invalid input. Please try again.");
    }

    try {
        // Establish a connection to MySQL/MariaDB using PDO
        $db = new PDO("mysql:host=localhost;dbname=aproject", "root", " ");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions
        
        // Prepare a query with parameterized placeholders
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindParam(1, $username, PDO::PARAM_STR); // Bind username as a string

        $stmt->execute(); // Execute the query
        
        // Fetch the first row
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
        
        if ($user) {
            // Verify the password with the stored hash
            if (password_verify($password, $user['password'])) {
                // Successful login, set session variables
                $_SESSION['user_id'] = $user['uid']; // or 'id' depending on your schema
                $_SESSION['username'] = $user['username'];

                echo "Login successful!"; // Or redirect to a secure page
            } else {
                echo "Invalid username or password."; // Incorrect password
            }
        } else {
            echo "Invalid username or password."; // No matching user
        }
    } catch (PDOException $e) {
        echo "An error occurred: " . htmlspecialchars($e->getMessage());
    }
}
?>
