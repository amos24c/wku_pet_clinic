<?php
require_once '../config.php'; // Database configuration file

header('Content-Type: application/json'); // Set header for JSON response

// Check if the required data is in POST
if (isset($_POST['appointment_id']) && isset($_POST['new_status'])) {
    $appointment_id = (int)$_POST['appointment_id'];
    $new_status = $_POST['new_status'];

    // Establish database connection
    $mysqli = new mysqli($host, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
        echo json_encode(['error' => 'Database connection failed: ' . $mysqli->connect_error]);
        exit;
    }

    // Prepare the update statement
    $stmt = $mysqli->prepare("UPDATE Appointments SET status = ? WHERE appointment_id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $new_status, $appointment_id);
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => 'Appointment status updated successfully.']);
        } else {
            echo json_encode(['error' => 'No changes made or appointment not found.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error preparing statement: ' . $mysqli->error]);
    }

    $mysqli->close();
} else {
    echo json_encode(['error' => 'Required data not provided.']);
}
?>
