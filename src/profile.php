<?php
session_start(); // Start the session

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php"; // Adjust the path as needed

$owner_id = $_SESSION['id']; // Set the owner's ID from session

// Fetch the initial data
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare a select statement
    $sql = "SELECT name, email, phone, address FROM Owners WHERE owner_id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $owner_id);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($name, $email, $phone, $address);
                $stmt->fetch();
            } else {
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Edit Profile</h2>
    <p>Please fill this form to update your profile.</p>
    <form id="profileForm">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
        </div>    
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
        </div>
        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="welcome.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
$(document).ready(function () {
    $('#profileForm').submit(function (event) {
        event.preventDefault(); // Stop the form from causing a page refresh.
        $.ajax({
            type: "POST",
            url: "profile_update.php",
            data: $(this).serialize(),
            success: function (response) {
                alert("Profile Updated Successfully!");
            },
            error: function () {
                alert("Error updating profile. Please try again.");
            }
        });
    });
});
</script>

</body>
</html>
