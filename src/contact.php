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

// Fetch clinic contact data
$query = "SELECT address, phone, email, hours FROM ClinicInfo";
$result = $mysqli->query($query);
$info = $result->fetch_assoc();

// Close connection
$mysqli->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clinic Contact Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php require 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Contact Us</h2>
        <?php if ($info): ?>
            <div class="card">
                <div class="card-body" style="background-color:#FFC845">
                    <h4 class="card-title">Clinic Contact Information</h4>
                    <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($info['address']); ?></p>
                    <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($info['phone']); ?></p>
                    <p class="card-text"><strong>Email:</strong> <a
                            href="mailto:<?php echo htmlspecialchars($info['email']); ?>"><?php echo htmlspecialchars($info['email']); ?></a>
                    </p>
                    <p class="card-text"><strong>Hours:</strong> <?php echo htmlspecialchars($info['hours']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>No contact information available.</p>
        <?php endif; ?>

        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3134.426684139298!2d-85.68502778466937!3d38.223205179680335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88690b58e93ade23%3A0x8c0a96cf00fb0869!2s2240%20Taylorsville%20Rd%2C%20Louisville%2C%20KY%2040205%2C%20USA!5e0!3m2!1sen!2snp!4v1604537029646!5m2!1sen!2snp"
            width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
            tabindex="0"></iframe>
        <div class="container mt-5">
            <h2>Contact Form</h2>
            <form id="contactForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject:</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message:</label>
                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <button type="button" id="btnSubmit" class="btn btn-primary">Send Message</button>
            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#btnSubmit').on('click', function (event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: 'contact_logic.php', // The server script that handles the submission
                    data: formData,
                    success: function (response) {
                        alert('Message sent successfully.');
                        //reset
                        $('#contactForm')[0].reset();
                    },
                    error: function () {
                        alert('Error sending message.');
                    }
                });
            });
        });
    </script>

</body>

</html>