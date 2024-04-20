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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Clinic Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-body{
            background-color: #f8f9fa;
            padding: 20px;
            margin: 20px;
        }

        .card{
            padding: 20px
        }
    </style>
</head>

<body>
    <?php require 'navbar.php'; ?>


    <!-- Main Content Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="container mt-5">
                <h2>Meet Our Dedicated Team</h2>
                <p style="padding-bottom:0px;">Our team of experienced veterinarians and support staff are here to
                    provide the best care for your pets.</p>
                <p>Welcome to the heart of our clinic—our exceptional team. Each member of our staff is not only highly
                    skilled and knowledgeable but also deeply passionate about providing the best possible care for your
                    pets. From seasoned veterinarians to caring support staff, we are united in our commitment to
                    excellence and compassion in animal care. Get to know the professionals who make our veterinary
                    clinic a trusted name in pet health.</p>
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

            <!-- Other Sections remain the same -->
        </div>
    </div>
    </div>

    <!-- Footer and Scripts remain unchanged -->
</body>

</html>