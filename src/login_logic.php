<?php
session_start(); // Start a new session

$host = 'localhost';  
$dbname = 'pet_clinic';  
$username = 'root';  
$password = '';  

// Create a PDO instance as db connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$login_err = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $userPassword = $_POST['password'] ?? '';
    
    // Prepare a select statement
    $sql = "SELECT owner_id, password FROM Owners WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    
    // Bind variables to the prepared statement
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
    // Attempt to execute
    if($stmt->execute()){
        // Check if email exists, if yes then verify password
        if($stmt->rowCount() == 1){
            if($row = $stmt->fetch()){
                $hashedPassword = $row['password'];
                if(password_verify($userPassword, $hashedPassword)){
                    // Password is correct, start a new session
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $row['owner_id'];
                    $_SESSION['email'] = $email;
                    
                    // Redirect user to welcome page
                    header("location: welcome.php");
                    exit;
                } else{
                    // Display an error message if password is not valid
                    $login_err = "Invalid password.";
                }
            }
        } else{
            // Display an error message if username doesn't exist
            $login_err = "No account found with that email.";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);
}

// Close connection
unset($pdo);
?>
