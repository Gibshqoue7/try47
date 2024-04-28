<?php
require 'config.php'; // Database configuration for MySQL

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = intval($_POST['pid']); // Securely get project ID
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = htmlspecialchars($_POST['phase']);

    try {
        // Connect to MySQL/MariaDB using PDO
        $db = new PDO("mysql:host=localhost;dbname=aproject", "root", " "); // Database credentials
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling

        // Prepare the SQL query with placeholders for parameterized queries
        $stmt = $db->prepare("UPDATE projects SET title = ?, description = ?, start_date = ?, end_date = ?, phase = ? WHERE id = ?");

        // Bind the parameters to the query
        $stmt->bindParam(1, $title, PDO::PARAM_STR); // Bind title as a string
        $stmt->bindParam(2, $description, PDO::PARAM_STR); // Bind description as a string
        $stmt->bindParam(3, $start_date, PDO::PARAM_STR); // Bind start date as a string
        $stmt->bindParam(4, $end_date, PDO::PARAM_STR); // Bind end date as a string
        $stmt->bindParam(5, $phase, PDO::PARAM_STR); // Bind phase as a string
        $stmt->bindParam(6, $pid, PDO::PARAM_INT); // Bind project ID as an integer
        
        $stmt->execute(); // Execute the update query
        
        echo "Project updated successfully!";
    } catch (PDOException $e) {
        // Log database errors and handle them gracefully
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred while updating the project.";
    }
}
?>
