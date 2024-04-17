<?php
$host = 'localhost';
$dbname = 'pet_clinic';
$username = 'root';
$password = '';

// Create connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set charset to utf8mb4
$mysqli->set_charset("utf8mb4");

try {
    // Prepare the query
    $query = "SELECT name, description, price FROM Services ORDER BY name";
    $result = $mysqli->query($query);

    // Check if query was successful
    if ($result === false) {
        throw new Exception("Query failed: " . $mysqli->error);
    }

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    // Free result set
    $result->free();

    foreach ($services as $service) {
        echo "<div class='card mb-3'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($service['name']) . ' $'. ($service['price']) . "</h5>";
        echo "<p class='card-text'>" . htmlspecialchars($service['description']) . "</p>";
        echo "</div>";
        echo "</div>";
    }
} catch (Exception $e) {
    die("An error occurred: " . $e->getMessage());
}

// Close connection
$mysqli->close();
?>
