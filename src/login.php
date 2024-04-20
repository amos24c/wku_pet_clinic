<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Clinic Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php require 'navbar.php'; ?>


    <!-- Main Content Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <?php include 'login_logic.php'; ?>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h1>Pet Clinic Login</h1>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (!empty($login_err)) {
                                        echo '<div class="alert alert-danger">' . $login_err . '</div>';
                                    }
                                    ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" name="email" id="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                required>
                                        </div>
                                        <div class="d-grid">
                                            <input type="submit" value="Login" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-muted">
                                    © 2024 Our Veterinary Clinic. All rights reserved.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Sections remain the same -->
            </div>
        </div>
    </div>

    <!-- Footer and Scripts remain unchanged -->
</body>

</html>