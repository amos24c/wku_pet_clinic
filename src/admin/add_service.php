<?php
include '../config.php'; // Make sure this file contains the MySQL connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $promoCode = $_POST['promo_code'] ?? '';
    $promoAmt = $_POST['promo_amt'] ?? 0;

    $query = "INSERT INTO Services (name, description, price, created, updated, deleted, promo_code, promo_amt) VALUES (?, ?, ?, NOW(), NOW(), 0, ?, ?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ssdsd", $name, $description, $price, $promoCode, $promoAmt);
        $stmt->execute();
        echo "Service added successfully";
        $stmt->close();
    } else {
        echo "Error: " . $mysqli->error;
    }
    $mysqli->close();
}
?>
