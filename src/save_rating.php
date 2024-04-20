<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    exit('Access denied');
}

require_once "config.php";

// Fetch and sanitize input data
$appointment_id = isset($_POST['appointment_id']) ? (int)$_POST['appointment_id'] : 0;
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
$comment = isset($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : '';

// Check if an entry already exists
$checkSql = "SELECT * FROM AppointmentRating WHERE appointment_id = ?";
if ($stmt = $mysqli->prepare($checkSql)) {
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Update existing record
        $updateSql = "UPDATE AppointmentRating SET rating = ?, comment = ? WHERE appointment_id = ?";
        if ($updateStmt = $mysqli->prepare($updateSql)) {
            $updateStmt->bind_param("isi", $rating, $comment, $appointment_id);
            $updateStmt->execute();
        }
    } else {
        // Insert new record
        $insertSql = "INSERT INTO AppointmentRating (appointment_id, rating, comment) VALUES (?, ?, ?)";
        if ($insertStmt = $mysqli->prepare($insertSql)) {
            $insertStmt->bind_param("iis", $appointment_id, $rating, $comment);
            $insertStmt->execute();
        }
    }
}

$mysqli->close();
?>
