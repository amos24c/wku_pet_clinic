<?php
session_start();

// Including the database connection file
require_once 'config.php'; // Ensure this contains your mysqli connection setup

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    echo "Access denied: You are not logged in.";
    exit;
}

// Check if the necessary data is present
if (isset($_POST['pet_id'], $_POST['name'], $_POST['species'], $_POST['breed'], $_POST['age'], $_POST['medical_history'])) {
    $petId = $_POST['pet_id'];
    $petName = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $medicalHistory = $_POST['medical_history'];

    // Validate input
    if (empty($petName) || empty($species)) {
        echo "Error: Missing required fields.";
        exit;
    }

    // Prepare an UPDATE statement
    $sql = "UPDATE Pets SET name = ?, species = ?, breed = ?, age = ?, medical_history = ? WHERE pet_id = ?";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sssisi", $petName, $species, $breed, $age, $medicalHistory, $petId);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Pet details updated successfully.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing the update statement.";
    }

    // Close connection
    $mysqli->close();
} else {
    echo "Error: All fields are required.";
}
?>
