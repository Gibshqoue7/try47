<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection parameters
    $servername = 'localhost'; // Database host
    $database = 'aproject'; // The name of MySQL database
    $username = 'root'; // Database username
    $password = ' '; // Database password

    // Get POST data and sanitize it to prevent XSS
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $phase = htmlspecialchars($_POST['phase']);

    try {
        // Connect to MySQL using PDO
        $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $db = new PDO($dsn, $username, $password, $options);

        // Prepare and execute the SQL INSERT statement
        $stmt = $db->prepare("INSERT INTO projects (title, description, start_date, end_date, phase) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $title, PDO::PARAM_STR);
        $stmt->bindParam(2, $description, PDO::PARAM_STR);
        $stmt->bindParam(3, $start_date, PDO::PARAM_STR);
        $stmt->bindParam(4, $end_date, PDO::PARAM_STR);
        $stmt->bindParam(5, $phase, PDO::PARAM_STR);

        $stmt->execute(); // Execute the prepared statement

        echo "Project added successfully!";
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage()); // Log the error message
        echo "An error occurred while adding the project.";
    }
}
?>
