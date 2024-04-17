<?php
session_start();
require_once 'config.php'; // Ensure this file contains your database connection settings

// Check if the form data is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input
    $service = isset($_POST['service']) ? $mysqli->real_escape_string($_POST['service']) : null;
    $date = isset($_POST['date']) ? $mysqli->real_escape_string($_POST['date']) : null;
    $time = isset($_POST['time']) ? $mysqli->real_escape_string($_POST['time']) : null;
    $petId = isset($_POST['pet_id']) ? $mysqli->real_escape_string($_POST['pet_id']) : null;


    // Example of validating and formatting a date in PHP
    $date = $_POST['date']; // e.g., '12/31/2024' from form input

    // Create date object from format
    $dateTime = DateTime::createFromFormat('m/d/Y', $date);

    // Check if date is valid
    if ($dateTime) {
        // Format date for MySQL
        $formattedDate = $dateTime->format('Y-m-d'); // Converts to '2024-12-31'
    } else {
        echo json_encode(['error' => 'Invalid date format']);
        exit;
    }
    // Validate input
    if (empty($service) || empty($date) || empty($time) || empty($petId)) {
        echo json_encode(['error' => 'All fields are required']);
        exit;
    }


    

    // Status is set to 'Scheduled' by default, adjust as needed
    $status = 'Scheduled';

    // Prepare SQL query to insert the booking into the database
    $query = "INSERT INTO Appointments (service_id, pet_id, date, time, status) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("iisss", $service, $petId, $formattedDate, $time, $status);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Service booked successfully']);
        } else {
            echo json_encode(['error' => 'Error booking service: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database error: ' . $mysqli->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$mysqli->close();
?>