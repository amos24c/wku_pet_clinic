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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
        <style>
    .error {
        border: 2px solid red;
    }
</style>
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
                    <th>Image
                    </th>
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
                        <td>
                            <img src="<?php echo htmlspecialchars($pet['picture']); ?>" alt="Pet Image"
                                style="width: 60px; height: auto;">
                        </td>
                        <td><?php echo htmlspecialchars($pet['name']); ?></td>
                        <td><?php echo htmlspecialchars($pet['species']); ?></td>
                        <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                        <td><?php echo htmlspecialchars($pet['age']); ?></td>
                        <td>
                            <a href="#" class="edit-pet" data-val="<?php echo $pet['pet_id'] ?>">Edit</a>
                            |
                            <!-- Add pet appointment -->
                            <a href="#" class="edit-appointments"
                                data-pet-id="<?php echo $pet['pet_id'] ?>">Appointments</a>
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
                    <form enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <label for="pet-image" class="form-label">Pet Image:</label>
                            <input type="file" class="form-control" id="pet-image" name="pet_image">
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


    <!-- Edit Pet Modal -->
    <div class="modal fade" id="editPetModal" tabindex="-1" aria-labelledby="editPetLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPetLabel">Edit Pet Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPetForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit-pet-id">
                        <div class="mb-3">
                            <label for="edit-pet-name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="edit-pet-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-species" class="form-label">Species:</label>
                            <input type="text" class="form-control" id="edit-species" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-breed" class="form-label">Breed:</label>
                            <input type="text" class="form-control" id="edit-breed">
                        </div>
                        <div class="mb-3">
                            <label for="edit-age" class="form-label">Age:</label>
                            <input type="number" class="form-control" id="edit-age">
                        </div>
                        <div class="mb-3">
                            <label for="edit-medical-history" class="form-label">Medical History:</label>
                            <textarea class="form-control" id="edit-medical-history" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-pet-image" class="form-label">Pet Image:</label>
                            <input type="file" class="form-control" id="edit-pet-image" name="pet_image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="btnUpdatePet" class="btn btn-primary">Update Pet</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Selection Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Book a Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="existing-appointments-placeholder">

                    </div>
                    <form>
                        <input type="hidden" id="service-pet-id">
                        <div class="mb-3">
                            <label for="service-select" class="form-label">Select Service:</label>
                            <select id="service-select" name="service" class="form-select">
                                <?php include 'get_services_dropdown.php';
                                echo getServicesDropdown(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="service-date" class="form-label">Select Date:</label>
                            <input type="text" class="form-control" id="service-date">
                        </div>
                        <div class="mb-3">
                            <label for="service-time" class="form-label">Select Time:</label>
                            <input type="text" class="form-control" id="service-time">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btnBookService" type="button" class="btn btn-primary">Book Service</button>
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <!-- Optional Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- add datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#service-date').datepicker();
            $("#service-time").timepicker({
                timeFormat: 'hh:mm tt',
                interval: 30,
                minTime: '10',
                maxTime: '6:00pm',
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true,
            });
            $("#service-time").timepicker('setTime', new Date());
            $('#petsTable').DataTable();
        });
    </script>

    <script type="text/javascript">
        $(function () {

            //book service
            $('#btnBookService').click(function (e) {
                e.preventDefault();

                // Clear previous errors
                $('.form-control').removeClass('error');

                var isValid = true;
                var service = $('#service-select').val();
                var date = $('#service-date').val();
                var time = $('#service-time').val();
                var petId = $('#service-pet-id').val();

                if (!service) {
                    $('#service-select').addClass('error');
                    isValid = false;
                }

                if (!date) {
                    $('#service-date').addClass('error');
                    isValid = false;
                }

                if (!time) {
                    $('#service-time').addClass('error');
                    isValid = false;
                }

                if (!petId) {
                    $('#service-pet-id').addClass('error');
                    isValid = false;
                }

                // If any of the validations failed, stop the function here
                if (!isValid) {
                    alert('Please fill in all required fields correctly.');
                    return;
                }

                // Proceed with AJAX request if all validations pass
                $.ajax({
                    url: 'book_service.php',
                    type: 'POST',
                    data: { service: service, date: date, time: time, pet_id: petId },
                    success: function (response) {
                        console.log(response);
                        var result = JSON.parse(response);
                        if (result.error) {
                            alert('Error: ' + result.error);
                        } else {
                            alert('Service booked successfully!');
                            $('#serviceModal').modal('hide');
                            // Optionally refresh or update UI here
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });


            $('#btnUpdatePet').click(function (e) {
                e.preventDefault();
                var formData = new FormData($('#editPetForm')[0]);  // Create FormData from form element

                // add breed
                //append petid  
                formData.append('pet_id', $('#edit-pet-id').val());
                formData.append('breed', $('#edit-breed').val());
                formData.append('age', $('#edit-age').val());
                formData.append('medical_history', $('#edit-medical-history').val());
                formData.append('age', $('#edit-age').val());
                formData.append('name', $('#edit-pet-name').val());
                formData.append('species', $('#edit-species').val());

                $.ajax({
                    url: 'update_pet.php',  // Your server-side script to process the form
                    type: 'POST',
                    data: formData,
                    contentType: false,  // Required for file upload
                    processData: false,  // Required for file upload
                    success: function (response) {
                        console.log(response);
                        alert('Pet updated successfully!');
                        $('#editPetModal').modal('hide');
                        // Optionally refresh or update UI here
                        reloadPetsTable();


                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });

            //delete appointment
            $('body').on('click', '.delete-appointment', function (e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this appointment?')) {
                    return;
                }
                var appointmentId = $(this).data('id');
                var petId = $(this).data('pet-id');
                $.ajax({
                    url: 'delete_appointment.php',
                    type: 'POST',
                    data: { appointment_id: appointmentId },
                    success: function (response) {
                        console.log(response);
                        alert('Appointment deleted successfully!');
                        // Optionally refresh or update UI here
                        // reloadPetsTable();
                        // load the existing appointments
                        $.ajax({
                            url: 'get_appointments_list.php',
                            type: 'GET',
                            data: { pet_id: petId },
                            success: function (response) {
                                $('.existing-appointments-placeholder').html(response);
                            },
                            error: function (xhr, status, error) {
                                alert('An error occurred: ' + error);
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });

            //edit appointments
            $('#petsTable').on('click', '.edit-appointments', function (e) {
                e.preventDefault();
                var petId = $(this).data('pet-id'); // Ensure you're using the right data attribute to get the pet ID

                // Open the service modal
                $('#serviceModal').modal('show');

                // Set the pet ID in the modal
                $('#service-pet-id').val(petId);



                // load the existing appointments
                $.ajax({
                    url: 'get_appointments_list.php',
                    type: 'GET',
                    data: { pet_id: petId },
                    success: function (response) {
                        $('.existing-appointments-placeholder').html(response);
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });

            $('#petsTable').on('click', '.edit-pet', function (e) {
                e.preventDefault();
                var petId = $(this).data('val'); // Ensure you're using the right data attribute to get the pet ID
                $.ajax({
                    url: 'get_pet.php',
                    type: 'GET',
                    data: { pet_id: petId },
                    success: function (response) {
                        var pet = JSON.parse(response);
                        $('#edit-pet-id').val(pet.pet_id);
                        $('#edit-pet-name').val(pet.name);
                        $('#edit-species').val(pet.species);
                        $('#edit-breed').val(pet.breed);
                        $('#edit-age').val(pet.age);
                        $('#edit-medical-history').val(pet.medical_history);
                        $('#editPetModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });



            $('#btnSavePet').click(function (e) {
                e.preventDefault(); // Prevent default form submission

                var formData = new FormData();
                formData.append('name', $('#pet-name').val());
                formData.append('species', $('#species').val());
                formData.append('breed', $('#breed').val());
                formData.append('age', $('#age').val());
                formData.append('medical_history', $('#medical-history').val());
                formData.append('pet_image', $('#pet-image')[0].files[0]); // Get the file from input

                $.ajax({
                    url: 'add_pet.php', // Your server-side script that handles the form submission
                    type: 'POST',
                    data: formData,
                    contentType: false, // Important: without this, jQuery will set the content-type
                    processData: false, // Important: without this, jQuery will try to convert your FormData into a string, which isn't useful
                    success: function (response) {
                        console.log(response);
                        alert('Pet added successfully!');
                        reloadPetsTable();
                        //reset modal fields
                        $('#pet-name').val('');
                        $('#species').val('');
                        $('#breed').val('');
                        $('#age').val('');
                        $('#medical-history').val('');
                        $('#pet-image').val('');
                        $('#addPetModal').modal('hide');

                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });

        function reloadPetsTable() {
            $.ajax({
                url: 'get_pets.php',
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#petsTable tbody').html(response);
                    $('#petsTable').DataTable();
                    // rebind click event

                },
                error: function (err) {
                    console.log('Error: Failed to fetch pets.');
                    console.log(err);
                }
            });
        }

    </script>

</body>

</html>