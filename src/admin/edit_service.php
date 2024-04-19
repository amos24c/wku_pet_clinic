<?php
include '../config.php'; // Database configuration

$mysqli = new mysqli($host, $username, $password, $dbname);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$promoCode = $_POST['promo_code'];
$promoAmt = $_POST['promo_amt'];

$query = "UPDATE Services SET name = ?, description = ?, price = ?, promo_code = ?, promo_amt = ? WHERE service_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssdsdi", $name, $description, $price, $promoCode, $promoAmt, $id);
if ($stmt->execute()) {
    echo "Service updated successfully";
} else {
    echo "Error updating service: " . $mysqli->error;
}
$stmt->close();
$mysqli->close();
?>
