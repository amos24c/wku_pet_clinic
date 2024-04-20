<?php
session_start();
require_once 'config.php'; // This should contain your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check for necessary fields - example, add more validation as needed
    if (empty($_POST['name']) || empty($_POST['species'])) {
        echo "Please fill in all required fields.";
        exit;
    }

    // Assign variables
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'] ?? ''; // Optional field
    $age = $_POST['age'];
    $owner_id = $_SESSION['id']; // Assuming you have an owner ID in the session
    $medical_history = $_POST['medical_history'] ?? ''; // Optional field

    // Initialize default image
    $target_file = "uploads/default.jpg"; // Default image path

    // File upload handling
    if (!empty($_FILES["pet_image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["pet_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["pet_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["pet_image"]["size"] > 5000000) { // 5MB limit
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file types
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Try to upload file if all checks are ok
        if ($uploadOk == 1 && move_uploaded_file($_FILES["pet_image"]["tmp_name"], $target_file)) {
            echo "The file ". basename($_FILES["pet_image"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            $target_file = "uploads/default.jpg"; // Revert to default if upload fails
        }
    }

    // Insert into database
    $stmt = $mysqli->prepare("INSERT INTO Pets (owner_id, name, species, breed, age, medical_history, picture, deleted) VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("isssiss", $owner_id, $name, $species, $breed, $age, $medical_history, $target_file);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request method.";
}
$mysqli->close();
?>
