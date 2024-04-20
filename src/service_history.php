<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include database configuration
require_once "config.php"; 

// Fetch the pet ID from the query string and ensure it is a valid integer
$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;

if ($pet_id <= 0) {
    echo "Invalid Pet ID.";
    exit;
}

$owner_id = $_SESSION['id']; // Assuming owner ID is stored in session

// SQL to fetch service history for a specific pet, ensuring the pet belongs to the owner
$sql = "SELECT a.appointment_id, a.pet_id, a.service_id, a.date, a.status, p.name as pet_name, s.name as service_name, s.price, ar.rating, ar.comment
        FROM Appointments a 
        JOIN Pets p ON a.pet_id = p.pet_id 
        JOIN Services s ON a.service_id = s.service_id
        JOIN AppointmentRating ar on ar.appointment_id = a.appointment_id
        WHERE p.pet_id = ? AND a.status = 'Completed' AND p.owner_id = ?
        ORDER BY a.appointment_id desc";

// Prepare the statement
if ($stmt = $mysqli->prepare($sql)) {
    // Bind the pet ID and owner ID to the statement
    $stmt->bind_param("ii", $pet_id, $owner_id);

    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Start of DataTable HTML
        echo '<table id="serviceHistoryTable" class="display" style="width:100%">';
        echo '<thead><tr><th>Appointment ID</th><th>Pet Name</th><th>Service Name</th><th>Date</th><th>Status</th><th>Price</th><th>Rating</th><th>Comments</th></tr></thead><tbody>';

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>{$row['appointment_id']}</td>
            <td>{$row['pet_name']}</td>
            <td>{$row['service_name']}</td>
            <td>{$row['date']}</td>
            <td>{$row['status']}</td>
            <td>{$row['price']}</td>
            <td>
                <select class='form-control rating-dropdown' data-appointment-id='{$row['appointment_id']}'>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                </select>
                <script>$('.rating-dropdown[data-appointment-id={$row['appointment_id']}]').val('{$row['rating']}');</script>
            </td>
            <td><input type='text' value='{$row['comment']}' class='form-control rating-comment' data-appointment-id='{$row['appointment_id']}' placeholder='Enter comments'></td>
          </tr>";
        }

        echo '</tbody></table>';
        echo '<script>$(document).ready(function(){$("#serviceHistoryTable").DataTable();});</script>';

    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Error preparing the statement: " . $mysqli->error;
}

// Close connection
$mysqli->close();
?>
