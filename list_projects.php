<?php
// Database configuration file to get connection details
require 'config.php'; 

try {
    // Connect to MySQL/MariaDB using PDO
    $db = new PDO("mysql:host=localhost;dbname=aproject", "root", " "); // Databse credentials
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exception handling
    
    // Fetch all projects from the "projects" table
    $result = $db->query("SELECT * FROM projects");
    
    // Initialize an empty array to collect projects
    $projects = [];
    
    // Loop through the results and fetch as associative arrays
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $projects[] = $row; // Add each project to the array
    }
    
    // Return the projects as JSON for  JavaScript 
    echo json_encode($projects); // This can be used to return results to an AJAX call
    
} catch (PDOException $e) {
    // Log database errors for debugging
    error_log("Database error: " . htmlspecialchars($e->getMessage()));
    echo "An error occurred while fetching the projects.";
}
?>
