<?php
require_once 'config.php';  // Assuming this file contains your $mysqli connection setup

header('Content-Type: text/html; charset=UTF-8');

if (!$mysqli) {
    echo 'Database connection error: ' . mysqli_connect_error();
    exit;
}

$query = "SELECT pet_id, name, species, breed, age FROM Pets";  // Assuming a 'deleted' column for soft deletes
$result = $mysqli->query($query);

if ($result) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $output = '';

    foreach ($rows as $row) {
        $output .= '<tr>';
        $output .= '<td>' . htmlspecialchars($row['name']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['species']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['breed']) . '</td>';
        $output .= '<td>' . htmlspecialchars($row['age']) . '</td>';
        $output .= '<td><a href="#" class="edit-link" data-id="' . $row['pet_id'] . '">Edit</a> | ';
        $output .= '<a href="#" class="delete-link" data-id="' . $row['pet_id'] . '">Delete</a></td>';
        $output .= '</tr>';
    }

    echo $output;
} else {
    echo 'Database query failed: ' . $mysqli->error;
}

$mysqli->close();
?>
