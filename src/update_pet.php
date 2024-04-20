<?php
session_start();
require_once 'config.php'; // This should contain your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //echo all POST data

    // Check for necessary fields - example, add more validation as needed
    if (empty($_POST['name']) || empty($_POST['species']) || empty($_POST['pet_id'])) {
        echo "Please fill in all required fields." . $_POST['name'] . $_POST['species'] . $_POST['pet_id'];
        exit;
    }

    // Assign variables
    $pet_id = $_POST['pet_id'];
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'] ?? ''; // Optional field
    $age = $_POST['age'];
    $medical_history = $_POST['medical_history'] ?? ''; // Optional field

    // Initialize default image (if no new image is uploaded, use existing image path)
    
    $target_file = $_POST['existing_image_path']; // Assume this field holds the path to the existing image



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
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Try to upload file if all checks are ok
        if ($uploadOk == 1 && move_uploaded_file($_FILES["pet_image"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["pet_image"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
            // Update database record
        $stmt = $mysqli->prepare("UPDATE Pets SET name = ?, species = ?, breed = ?, age = ?, medical_history = ?, picture = ? WHERE pet_id = ?");
        $stmt->bind_param("sssissi", $name, $species, $breed, $age, $medical_history, $target_file, $pet_id);
    }
else{
        // Update database record
        $stmt = $mysqli->prepare("UPDATE Pets SET name = ?, species = ?, breed = ?, age = ?, medical_history = ? WHERE pet_id = ?");
        $stmt->bind_param("sssisi", $name, $species, $breed, $age, $medical_history, $pet_id);
}


    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Invalid request method.";
}
$mysqli->close();
?>
