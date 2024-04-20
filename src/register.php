<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<?php require 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-3">Owner Registration</h2>
        <form id="registrationForm" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <div class="invalid-feedback">
                    Please provide a name.
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">
                    Please provide a valid email address.
                </div>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">
                    Please provide a password.
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#registrationForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission

                if (this.checkValidity() === false) {
                    event.stopPropagation(); // Stop propagation if the form is invalid
                } else {
                    var formData = $(this).serialize(); // Serialize the form data

                    $.ajax({
                        type: "POST",
                        url: "register_logic.php",
                        data: formData,
                        success: function (response) {
                            if (response == "Account created successfully. Please login.") {
                                console.log(response);
                                alert("Registration successful!");
                                $('#registrationForm')[0].reset(); // Reset form fields after successful submission
                                window.location.href = "login.php"; // Redirect to login page
                            }
                            else {
                                alert(response);
                            }
                        },
                        error: function () {
                            alert("Error registering. Please try again.");
                        }
                    });
                }
                this.classList.add('was-validated'); // Bootstrap validation class
            });
        });
    </script>
</body>

</html>