<?php
session_start();  // Start the session

// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';  // Database configuration

// Function to sanitize input data
function sanitizeInput($data, $mysqli) {
    return htmlspecialchars(strip_tags($mysqli->real_escape_string($data)));
}

// Check if the pet_id is received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pet_id'])) {
    $pet_id = sanitizeInput($_POST['pet_id'], $mysqli);

    // SQL to delete a pet
    $query = "UPDATE Pets SET deleted = 1 WHERE pet_id = ?";

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $pet_id);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Pet deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete the pet']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database prepare error: ' . $mysqli->error]);
    }
} else {
    echo json_encode(['error' => 'No pet ID provided']);
}

$mysqli->close();
?>
