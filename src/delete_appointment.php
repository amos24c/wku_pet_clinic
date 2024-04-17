<?php
session_start();
require_once 'config.php'; // Ensure this file contains your database connection settings

// Check if the appointment_id is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = (int)$_POST['appointment_id'];

    // Validate the appointment_id
    if ($appointment_id <= 0) {
        echo json_encode(['error' => 'Invalid appointment ID.']);
        exit;
    }

    // Prepare a DELETE statement
    $query = "DELETE FROM Appointments WHERE appointment_id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param('i', $appointment_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => 'Appointment deleted successfully.']);
        } else {
            echo json_encode(['error' => 'No appointment found with the specified ID, or deletion was not successful.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Database error: ' . $mysqli->error]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method or missing appointment ID.']);
}

$mysqli->close();
?>
