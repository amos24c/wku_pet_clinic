<?php
require_once 'config.php'; // Include your DB config file

if (isset($_GET['pet_id']) && is_numeric($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];

    // Prepare a select statement
    $query = "SELECT pet_id, name, species, breed, age, medical_history, picture FROM Pets WHERE pet_id = ?";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            echo json_encode($row); // Send the pet data in JSON format
        } else {
            echo json_encode(array('error' => 'No pet found with that ID.'));
        }

        $stmt->close();
    } else {
        echo json_encode(array('error' => 'Database query failed.'));
    }
} else {
    echo json_encode(array('error' => 'Invalid pet ID.'));
}

$mysqli->close();
?>
