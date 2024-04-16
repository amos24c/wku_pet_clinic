<?php
session_start();

// Including the database connection file
require_once 'config.php';

// Check if the data from the AJAX request is available
if (isset($_POST['petName'], $_POST['species'], $_POST['breed'], $_POST['age'])) {
    $petName = $_POST['petName'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $medicalHistory = $_POST['medicalHistory'];
    $owner_id = $_SESSION['id'];  // Assuming the owner's ID is stored in the session

    // Validation (simple example)
    if (empty($petName) || empty($species)) {
        echo 'Please fill in all required fields.';
        exit;
    }

    // Prepare an insert statement
    $sql = "INSERT INTO Pets (owner_id, name, species, breed, age, medical_history) VALUES (?, ?, ?, ?, ?, ?)";

    echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("isssis", $owner_id, $petName, $species, $breed, $age, $medicalHistory);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo 'Pet has been added successfully.';
        } else {
            echo 'Something went wrong. Please try again later.';
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Couldn't prepare statement. Check your query.";
    }

    // Close connection
    $mysqli->close();
} else {
    echo 'All fields are required.';
}
?>
