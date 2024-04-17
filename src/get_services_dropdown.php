<?php
// Include database connection settings
require_once 'config.php';

function getServicesDropdown() {
    global $mysqli;  // Assume $mysqli is your database connection from config.php

    $html = '';
    $query = "SELECT service_id, name FROM Services ORDER BY name ASC";  // Fetching services
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $html .= '<option value="' . $row['service_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
        }
        $result->free();
    } else {
        // Handle error or indicate no services are available
        $html .= '<option value="">No services available</option>';
    }

    return $html;
}
?>
