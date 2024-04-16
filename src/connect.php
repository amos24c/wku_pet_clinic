<?php
$host = '127.0.0.1';  // Database host
$dbname = 'pet_clinic';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password (empty by default in XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>