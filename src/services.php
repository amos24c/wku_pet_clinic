<?php
$host = 'localhost';
$dbname = 'pet_clinic';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT name, description FROM Services ORDER BY name");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

foreach ($services as $service) {
    echo "<div class='card mb-3'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . htmlspecialchars($service['name']) . "</h5>";
    echo "<p class='card-text'>" . htmlspecialchars($service['description']) . "</p>";
    echo "</div>";
    echo "</div>";
}
?>
