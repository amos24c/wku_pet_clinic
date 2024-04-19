<?php
require_once 'config.php';  // Include database configuration

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$pet_id = isset($_GET['pet_id']) ? (int)$_GET['pet_id'] : 0;
$query = "SELECT appointment_id, pet_id, date, time, a.status, s.name as service_name FROM Appointments a JOIN Services s on a.service_id = s.service_id WHERE pet_id = ? ORDER BY date ASC, time ASC";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param('i', $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<tr><th>Service</th><th>Date</th><th>Time</th><th>Action</th><th>Status<th></tr>";
        echo "<tbody>";
    
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['service_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['time']) . "</td>";
            echo "<td><a href='#' class='btn btn-danger delete-appointment' data-id='{$row['appointment_id']}'>Delete</a></td>";
            //add status dropdown option
            echo "<td><select class='form-control appointment-status' id='status-{$row['appointment_id']}' name='status' data-id='{$row['appointment_id']}' >
            <option value='Pending'>Scheduled</option>
            <option value='Approved'>Approved</option>
            <option value='Cancelled'>Cancelled</option>
            <option value='Completed'>Completed</option>
        </select></td>";
            //auto select value
            echo "<script>$('#status-{$row['appointment_id']}').val('{$row['status']}');</script>";

            echo "</tr>";
        }
        echo "</tbody>";
    } else {
        echo "<tr><td colspan='4'>No appointments found for the specified pet.</td></tr>";
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $mysqli->error;
}
$mysqli->close();
?>
