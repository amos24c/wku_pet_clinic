<style type="text/css">
    body,
    .container {
        background-color: #E5F2F8 !important;
    }

    h2 {
        color: #03173E !important;
        font-weight: 500;
    }

    p {
        color: #03173E !important;
        font-weight: 400;
        font-size: 20px;
        padding: 20px;
    }

    .navbar-light .navbar-nav .nav-link,
    .navbar a {
        color: white !important;
        font-weight: bold;
    }

    .admin{
        color: red !important;
    }
</style>


<!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #03173E !important;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Our Pet Clinic</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="staff.php">Our Staff</a>
                </li>


                

                <?php if (!isset($_SESSION["loggedin"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["loggedin"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["role"] == "staff"): ?>
                    <li class="nav-item">
                        <a class="nav-link admin" href="admin_welcome.php" style="color:red">ADMIN - Manage Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link admin" href="admin_services.php">ADMIN - Manage Services</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>