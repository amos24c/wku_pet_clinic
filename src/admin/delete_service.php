<?php
include '../config.php'; // Include your database configuration

// Connect to the database
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get the service ID from POST request
$serviceId = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($serviceId > 0) {
    // Prepare the delete statement
    $query = "UPDATE Services SET deleted = 1 where service_id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        // Bind the integer id to the prepared statement
        $stmt->bind_param("i", $serviceId);
        // Execute the statement
        if ($stmt->execute()) {
            echo "Service deleted successfully";
        } else {
            echo "Error deleting service: " . $mysqli->error;
        }
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
} else {
    echo "Invalid service ID";
}

// Close connection
$mysqli->close();
?>
