<?php
// Database connection parameters
$host = 'localhost';  
$dbname = 'pet_clinic';  
$username = 'root';  
$password = '';  

// Connect to the database
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// User data
$name = "John Doe";
$email = "john.doe@example.com";
$phone = "555-1234";
$address = "1234 Maple Street";
$userPassword = "examplePassword123"; // Plain password to be hashed

// Hash the user's password
$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

// Prepare SQL statement
$sql = "INSERT INTO Owners (name, email, phone, address, password, deleted, created, updated) 
        VALUES (:name, :email, :phone, :address, :password, 0, NOW(), NOW())";

// Prepare and execute SQL statement
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'password' => $hashedPassword
]);

echo "New owner added successfully with hashed password.";
?>
