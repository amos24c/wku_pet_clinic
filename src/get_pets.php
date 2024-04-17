<?php
session_start();
require_once 'config.php';  // Assuming this file contains your $mysqli connection setup

header('Content-Type: text/html; charset=UTF-8');

if (!$mysqli) {
    echo 'Database connection error: ' . mysqli_connect_error();
    exit;
}

$owner_id = $_SESSION['id'];  // Assuming you have an owner ID in the session
$query = "SELECT picture, pet_id, name, species, breed, age FROM Pets WHERE owner_id = $owner_id";  // Assuming a 'deleted' column for soft deletes
$result = $mysqli->query($query);

if ($result) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $output = '';

    foreach ($rows as $row) {
        $output .= '<tr>';
        $output .= '<td><img src="' . htmlspecialchars($row['picture']) . '" alt="Pet Image" style="width: 60px; height: auto;"></td>';
        $output .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['species']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['breed']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['age']) . '</td>';
        $output .= '<td><a href="#" class="edit-pet" data-val="' . $row['pet_id'] . '">Edit</a></td>';
        
    }

    echo $output;
} else {
    echo 'Database query failed: ' . $mysqli->error;
}

$mysqli->close();
?>
