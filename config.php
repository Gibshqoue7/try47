<?php
// MySQL/MariaDB connection settings
$servername = "localhost"; // Change if needed
$username = "root"; // Database username
$password = " "; // Database password
$database = "aproject"; // Name of your database

// Create a MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
