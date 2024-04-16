<?php
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$host = 'localhost';
$dbname = 'pet_clinic';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Assuming owner_id is stored in session upon login
    $owner_id = $_SESSION['id'];

    // Prepare a select statement to fetch pets
    $sql = "SELECT * FROM Pets WHERE owner_id = :owner_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_INT);
    $stmt->execute();
    $pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pet Clinic</a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    <a class="nav-link" href="#">Services</a>
                    <a class="nav-link" href="#">Contact</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="display-4">Hello, <?php echo htmlspecialchars($_SESSION["email"]); ?>!</h1>
        <p class="lead">Here are your pets:</p>

        <!-- Trigger/Open The Modal -->
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPetModal">Add New Pet</a>


        <!-- Pet Table -->
        <table id="petsTable" class="table table-striped">
            <thead>
                <tr>

                    <th>Name</th>
                    <th>Species</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Actions
                    <th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pets as $pet): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pet['name']); ?></td>
                        <td><?php echo htmlspecialchars($pet['species']); ?></td>
                        <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                        <td><?php echo htmlspecialchars($pet['age']); ?></td>
                        <td>
                            <!-- Fix applied here -->
                            <a href="pet_detail.php?pet_id=<?php echo $pet['pet_id']; ?>">View Details</a> |
                            <a href="edit_pet.php?pet_id=<?php echo $pet['pet_id']; ?>">Edit</a> |
                            <a href="delete_pet.php?pet_id=<?php echo $pet['pet_id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <!-- The Modal -->
<div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Add New Pet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="pet-name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="pet-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="species" class="form-label">Species:</label>
                        <input type="text" class="form-control" id="species" required>
                    </div>
                    <div class="mb-3">
                        <label for="breed" class="form-label">Breed:</label>
                        <input type="text" class="form-control" id="breed">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age:</label>
                        <input type="number" class="form-control" id="age">
                    </div>
                    <div class="mb-3">
                        <label for="medical-history" class="form-label">Medical History:</label>
                        <textarea class="form-control" id="medical-history" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSavePet" class="btn btn-primary">Save Pet</button>
            </div>
        </div>
    </div>
</div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#petsTable').DataTable();
        });
    </script>
    <!-- Optional Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $('#btnSavePet').click(function(){
                var petName = $('#pet-name').val();
                var species = $('#species').val();
                var breed = $('#breed').val();
                var age = $('#age').val();

                $.ajax({
                    url: 'add_pet.php',
                    type: 'POST',
                    data: {
                        petName: petName,
                        species: species,
                        breed: breed,
                        age: age
                    },
                    success: function(response){
                        //close modal
                        $('#addPetModal').modal('hide');
                        reloadPetsTable();

                    },
                    error: function(err){
                        console.log('Error: Failed to add pet.');
                            console.log(err);
                    }
                });
            });
        });

        function reloadPetsTable(){
            $.ajax({
                url: 'get_pets.php',
                type: 'GET',
                success: function(response){
                    console.log(response);
                    $('#petsTable tbody').html(response);
                    $('#petsTable').DataTable();
                },
                error: function(err){
                    console.log('Error: Failed to fetch pets.');
                    console.log(err);
                }
            });
        }
    </script>
</body>

</html>