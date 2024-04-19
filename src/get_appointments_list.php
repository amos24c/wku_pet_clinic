<?php
// Include database configuration
require_once 'config.php';

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve pet_id from GET request
$pet_id = isset($_GET['pet_id']) ? (int) $_GET['pet_id'] : 0;

// Query to fetch appointments for a specific pet
$query = "SELECT appointment_id, pet_id, date, time, s.name as name FROM Appointments a JOIN Services s on a.service_id = s.service_id WHERE pet_id = ? ORDER BY date ASC, time ASC";

// Prepare statement
if ($stmt = $mysqli->prepare($query)) {
    // Bind pet_id parameter
    $stmt->bind_param('i', $pet_id);
    
    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    $count = $result->num_rows;

    echo "<br>Total Appointments: " . $count . "<br>";
    // Check for results
    if ($result->num_rows > 0) {
        // Output each row as an HTML anchor tag
        while ($row = $result->fetch_assoc()) {
            echo '<a href="#" class="delete-appointment" data-pet-id=' . $row['pet_id'] . '  data-id="' . $row['appointment_id'] . '">'
               . 'Delete ' . $row['name'] . ' Appointment on ' . $row['date'] . ' at ' . $row['time']
               . '</a><br>';
        }
    } else {
        echo "No appointments found for the specified pet.";
    }

    //add space
    echo "<br>";
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}

// Close connection
$mysqli->close();
?>
