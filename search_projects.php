<?php
// MySQL/MariaDB connection parameters
$servername = "localhost"; // Change if needed
$username = "root"; // Database username
$password = " "; // Database password
$database = "aproject"; // Name of the database

// Connect to MySQL/MariaDB database using mysqli
$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Securely get the search term
if (isset($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']); // Escape special characters to prevent SQL injection
    
    try {
        // Prepare the SQL query with parameterized placeholders
        $stmt = $conn->prepare("SELECT * FROM projects WHERE title LIKE ? OR start_date = ?");
        if ($stmt) {
            // Bind the parameterized values securely
            $stmt->bind_param("ss", $like_search_term, $search_term); // "ss" specifies two string parameters
            $like_search_term = '%' . $search_term . '%'; // LIKE search term
            
            $stmt->execute(); // Execute the prepared statement
            
            $result = $stmt->get_result(); // Get the result set
            $projects = [];

            // Fetch results as associative arrays
            while ($row = $result->fetch_assoc()) {
                $projects[] = $row; // Collect matching projects into an array
            }
            
            // Return the results as JSON
            echo json_encode($projects);
        } else {
            throw new Exception("Failed to prepare SQL statement.");
        }
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage()); // Log the error for debugging
        echo "An error occurred while searching for projects.";
    } finally {
        $conn->close(); // Close the database connection
    }
} else {
    echo "No search term provided.";
}
?>
