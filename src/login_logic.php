<?php
session_start(); // Start a new session

$host = 'localhost';  
$dbname = 'pet_clinic';  
$username = 'root';  
$password = '';  

// Create a MySQLi instance as db connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$login_err = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $userPassword = $_POST['password'] ?? '';

    //check if staff
    $sql = "SELECT staff_id, password, role FROM Staff WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        
        // Bind variables to the prepared statement
        $stmt->bind_param('s', $email);
        
        // Attempt to execute
        if ($stmt->execute()) {
            $stmt->store_result();

            // Check if email exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($staff_id, $hashedPassword, $role);
                $stmt->fetch();
                
                if (password_verify($userPassword, $hashedPassword)) {
                    // Password is correct, start a new session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $staff_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    
                    // Redirect user to welcome page
                    header("location: admin_welcome.php");
                    exit;
                } else {
                    // Display an error message if password is not valid
                    $login_err = "Invalid password.";
                }
            } else {
                // Display an error message if username doesn't exist
                $login_err = "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $mysqli->error;
    }

    // Prepare a select statement
    $sql = "SELECT owner_id, password FROM Owners WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        
        // Bind variables to the prepared statement
        $stmt->bind_param('s', $email);
        
        // Attempt to execute
        if ($stmt->execute()) {
            $stmt->store_result();

            // Check if email exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($owner_id, $hashedPassword);
                $stmt->fetch();
                
                if (password_verify($userPassword, $hashedPassword)) {
                    // Password is correct, start a new session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $owner_id;
                    $_SESSION['email'] = $email;
                    
                    // Redirect user to welcome page
                    header("location: welcome.php");
                    exit;
                } else {
                    // Display an error message if password is not valid
                    $login_err = "Invalid password.";
                }
            } else {
                // Display an error message if username doesn't exist
                $login_err = "No account found with that email.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
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
