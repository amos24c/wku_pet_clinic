<?php
session_start();

// Include config file for database connection
require_once 'config.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Prepare and initialize variables
$petName = $species = $breed = $age = $medicalHistory = "";
$petId = $_GET['pet_id'] ?? 0;  // Ensure 'pet_id' is passed to this script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // This is an update request
    updatePetDetails($mysqli);
} else {
    // This is a fetch request
    fetchPetDetails($mysqli, $petId);
}

// Function to fetch pet details
function fetchPetDetails($mysqli, $petId) {
    if ($stmt = $mysqli->prepare("SELECT name, species, breed, age, medical_history FROM Pets WHERE pet_id = ?")) {
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $stmt->bind_result($name, $species, $breed, $age, $medical_history);
        if ($stmt->fetch()) {
            // Populate variables to fill in the form later in HTML
            global $petName, $species, $breed, $age, $medicalHistory;
            $petName = $name;
            $species = $species;
            $breed = $breed;
            $age = $age;
            $medicalHistory = $medical_history;
        }
        $stmt->close();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

// Function to update pet details
function updatePetDetails($mysqli) {
    // Extract and sanitize input
    $petId = $_POST['pet_id'];
    $petName = trim($_POST['name']);
    $species = trim($_POST['species']);
    $breed = trim($_POST['breed']);
    $age = trim($_POST['age']);
    $medicalHistory = trim($_POST['medical_history']);

    if ($stmt = $mysqli->prepare("UPDATE Pets SET name = ?, species = ?, breed = ?, age = ?, medical_history = ? WHERE pet_id = ?")) {
        $stmt->bind_param("sssisi", $petName, $species, $breed, $age, $medicalHistory, $petId);
        if ($stmt->execute()) {
            echo "Pet updated successfully.";
            // Optionally redirect or perform further actions
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Pet Information</h2>
        <form action="edit_pet.php?pet_id=<?php echo $petId; ?>" method="post" class="needs-validation" novalidate>
            <input type="hidden" name="pet_id" value="<?php echo $petId; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($petName); ?>" required>
                <div class="invalid-feedback">
                    Please enter a name.
                </div>
            </div>

            <div class="mb-3">
                <label for="species" class="form-label">Species:</label>
                <input type="text" class="form-control" id="species" name="species" value="<?php echo htmlspecialchars($species); ?>" required>
                <div class="invalid-feedback">
                    Please enter the species.
                </div>
            </div>

            <div class="mb-3">
                <label for="breed" class="form-label">Breed:</label>
                <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($breed); ?>">
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>">
            </div>

            <div class="mb-3">
                <label for="medical-history" class="form-label">Medical History:</label>
                <textarea class="form-control" id="medical-history" name="medical_history" rows="3"><?php echo htmlspecialchars($medicalHistory); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Pet</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script>
$(document).ready(function() {
    $('#btnUpdatePet').click(function(e) {
        e.preventDefault();  // Prevent default form submission

        var petId = $('#edit-pet-id').val();
        var petName = $('#edit-pet-name').val();
        var species = $('#edit-species').val();
        var breed = $('#edit-breed').val();
        var age = $('#edit-age').val();
        var medicalHistory = $('#edit-medical-history').val();

        $.ajax({
            url: 'update_pet_details.php', // Server script to process the update
            type: 'POST',
            data: {
                pet_id: petId,
                name: petName,
                species: species,
                breed: breed,
                age: age,
                medical_history: medicalHistory
            },
            success: function(response) {
                alert(response);  // Show response from the server
                $('#editPetModal').modal('hide'); // Hide the modal on success
                reloadPetsTable();  // Reload the data table to reflect changes
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
</script>
