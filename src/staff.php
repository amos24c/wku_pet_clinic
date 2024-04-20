<?php
// Database connection settings
$host = 'localhost'; // or your host
$dbname = 'pet_clinic'; // your database name
$username = 'root'; // your database username
$password = ''; // your database password

// Create connection
$mysqli = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch staff data
$query = "SELECT name, photo_url, qualifications, specialization FROM Staff";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'navbar.php'; ?>
<div class="container mt-5">
    <h2>Meet Our Staff</h2>
    <div class="row">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='card mb-4 shadow-sm'>";
                echo "<img src='" . htmlspecialchars($row['photo_url']) . "' class='card-img-top' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                echo "<p class='card-text'><strong>Qualifications:</strong> " . htmlspecialchars($row['qualifications']) . "</p>";
                echo "<p class='card-text'><strong>Specialization:</strong> " . htmlspecialchars($row['specialization']) . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No staff information available.</p>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close connection
$mysqli->close();
?>
