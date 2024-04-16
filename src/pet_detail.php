<?php
// Start the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php"; // Assuming you have a config file for database connection

$pet_id = isset($_GET['pet_id']) ? intval($_GET['pet_id']) : 0;

if ($pet_id == 0) {
    exit('Error: Invalid pet.');
}

// Attempt to execute the prepared statement
try {
    $sql = "SELECT * FROM Pets WHERE pet_id = :pet_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":pet_id", $pet_id, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the pet exists
    if ($stmt->rowCount() == 1) {
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        exit('No pet found with that ID.');
    }
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pet Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pet Details</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($pet['name']); ?></h5>
                <p class="card-text"><strong>Species:</strong> <?= htmlspecialchars($pet['species']); ?></p>
                <p class="card-text"><strong>Breed:</strong> <?= htmlspecialchars($pet['breed']); ?></p>
                <p class="card-text"><strong>Age:</strong> <?= htmlspecialchars($pet['age']); ?> years old</p>
                <p class="card-text"><strong>Medical History:</strong> <?= htmlspecialchars($pet['medical_history']); ?></p>
                <p class="card-text"><img src="<?= htmlspecialchars($pet['picture']); ?>" alt="Pet Image" style="max-width: 100%;"></p>
            </div>
        </div>
        <a href="welcome.php" class="btn btn-primary mt-3">Back to Pets</a>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
