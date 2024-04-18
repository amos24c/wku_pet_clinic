<?php
session_start(); // Start the session
include 'config.php'; // Database configuration variables

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert statement
    $sql = "INSERT INTO Owners (name, email, phone, address, password, created, updated) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";

    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement
        $stmt->bind_param("sssss", $name, $email, $phone, $address, $hashed_password);
        
        // Attempt to execute
        if ($stmt->execute()) {
            // Redirect to login page
            echo "Account created successfully. Please login.";
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $mysqli->error;
    }
}

// Close connection
$mysqli->close();
?>
