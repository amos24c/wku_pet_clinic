<?php
session_start(); // Start the session

require_once "config.php"; // Database configuration

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo "Not logged in";
    exit;
}

$response = [];
$owner_id = $_SESSION['id']; // Set the owner's ID from session

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    if(empty(trim($_POST["name"]))){
        $response['error'] = true;
        $response['message'] = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $address = trim($_POST["address"]);

        // Prepare an update statement
        $sql = "UPDATE Owners SET name = ?, email = ?, phone = ?, address = ? WHERE owner_id = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssi", $name, $email, $phone, $address, $owner_id);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $response['error'] = false;
                $response['message'] = "Profile updated successfully.";
            } else {
                $response['error'] = true;
                $response['message'] = "Error updating profile.";
            }
            $stmt->close();
        } else {
            $response['error'] = true;
            $response['message'] = "Database error: could not prepare statement.";
        }
    }
    $mysqli->close();
    echo json_encode($response);
}
?>
