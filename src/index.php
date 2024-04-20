<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Clinic Services</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .scrolling-wrapper {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
        }

        .service-card {
            display: inline-block;
            width: 300px;
            /* Fixed width for each tile */
            margin-right: 10px;
            /* Space between tiles */
            background-color: #f8f9fa;
            /* Light grey background */
            border: 1px solid #dee2e6;
            /* Grey border for each tile */
            border-radius: 0.25rem;
            /* Rounded corners for aesthetics */
            vertical-align: top;
            /* Align tiles properly */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            height: 250px;
            margin-bottom: 20px;
            background-color: #FFC845;
        }

        .service-card-body {
            padding: 15px;
            /* Padding inside each tile */
        }

        .service-card-title {
            font-size: 23px;
            /* Larger text for the service title */
            margin-bottom: 10px;
            /* Space below the title */
        }

        .service-card-text {
            font-size: 16px;
            /* Slightly smaller text for the description */
        }
    </style>
</head>

<body>
    <!-- Bootstrap Navbar -->
    <?php require 'navbar.php'; ?>

    <!-- Main Content Section -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mb-3">Welcome to Our Veterinary Clinic</h1>
                <p>At Our Veterinary Clinic, we understand that pets are more than just animals—they are family. That’s why we're committed to providing the highest level of care and compassion in everything we do. Whether your furry friend needs routine check-ups, emergency intervention, or specialized treatment, you can count on us to be there every step of the way.</p>
                
                <h2 class="mb-3">Your Pet's Health, Our Top Priority</h1>            
                <p>Open 24/7 for emergencies, our clinic is equipped with state-of-the-art facilities to ensure your pet receives the best possible care at any hour. With a full range of services from vaccinations and dental cleaning to advanced surgical procedures and behavioral training, our dedicated team of veterinary professionals is here to support the health and happiness of your pet.</p>

                <!-- Services Section -->
                <div id="services" class="mb-3">
                    <h2 class="mb-3">Explore Our Comprehensive Veterinary Services</h2>
<p>Navigate through our services below and discover how we can help enhance your pet's life through meticulous care and profound medical expertise. Because at Our Veterinary Clinic, we believe every pet deserves to live a happy and healthy life.</p>
                    <!-- Example service tile -->
            
                    <!-- Include PHP file that generates similar tiles -->
                    <?php include 'services.php'; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Footer and Scripts remain unchanged -->
</body>

</html>