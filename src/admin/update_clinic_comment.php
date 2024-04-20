<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo json_encode(["error" => "Access Denied: User not logged in."]);
    exit;
}

// Include database configuration
require_once "../config.php";

// Validate input
$appointment_id = isset($_POST['appointment_id']) ? intval($_POST['appointment_id']) : 0;
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

// Check if the appointment_id is valid
if ($appointment_id <= 0) {
    echo json_encode(["error" => "Invalid appointment ID"]);
    exit;
}

// Prepare an update statement
$sql = "UPDATE AppointmentRating SET clinic_comment = ? WHERE appointment_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    // Bind variables to the prepared statement
    $stmt->bind_param("si", $comment, $appointment_id);
    
    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        echo json_encode(["message" => "Comment updated successfully."]);
    } else {
        echo json_encode(["error" => "Error updating comment: " . $stmt->error]);
    }

    // Close statement
    $stmt->close();
} else {
    echo json_encode(["error" => "Error preparing the statement: " . $mysqli->error]);
}

// Close connection
$mysqli->close();
?>
