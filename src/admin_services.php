<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div>
    <h2>Services Management</h2>
    <div class="row">
      
            <h3>Available Services</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Promo Code</th>
                        <th>Promo Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php'; // include your database configuration file

                    $mysqli = new mysqli($host, $username, $password, $dbname);
                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }

                    $query = "SELECT service_id, name, description, price, promo_code, promo_amt FROM Services WHERE deleted = 0 ORDER BY name";
                    if ($result = $mysqli->query($query)) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-id='{$row['service_id']}'>";
                            echo "<td><input type='text' class='form-control edit-field' value='" . htmlspecialchars($row['name']) . "' data-field='name'></td>";
                            echo "<td><input style='width:850px' type='text' class='form-control edit-field' value='" . htmlspecialchars($row['description']) . "' data-field='description'></td>";
                            echo "<td><input type='number' class='form-control edit-field' value='" . htmlspecialchars($row['price']) . "' step='0.01' data-field='price'></td>";

//promo code and promo amount
                            echo "<td><input type='text' class='form-control edit-field' value='" . htmlspecialchars($row['promo_code']) . "' data-field='promo_code'></td>";
                            echo "<td><input type='number' class='form-control edit-field' value='" . htmlspecialchars($row['promo_amt']) . "' step='0.01' data-field='promo_amt'></td>";

                            echo "<td><button class='btn btn-primary save-btn'>Save</button></td>";
                            echo "<td><button class='btn btn-danger btnDelete'>Delete</button></td>";
                            echo "</tr>";
                        }
                        $result->close();
                    }
                    $mysqli->close();
                    ?>

                    <tr>
                    <td><input type='text' class='form-control' data-field='name'></td>
                    <td><input style='width:850px' type='text' class='form-control' data-field='description'></td>
                    <td><input type='number' class='form-control' data-field='price' step='0.01'></td>
                    <td><input type='text' class='form-control' data-field='promo_code'></td>
                    <td><input type='number' class='form-control' data-field='promo_amt' step='0.01'></td>
                    <td><button id="btnAddNew" class='btn btn-primary'>ADD</button></td>
           
                    </tr>
                </tbody>
            </table>
       
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {

// Assuming your table has an id `servicesTable`
$('body').on('click', '.btnDelete', function() {
        var row = $(this).closest('tr');
        var serviceId = row.data('id');

        if (confirm('Are you sure you want to delete this service?')) {
            $.ajax({
                url: 'admin/delete_service.php',
                type: 'POST',
                data: { id: serviceId },
                success: function(response) {
                    console.log(response);
                    alert('Service deleted successfully');
                    // Reload the page or remove the row from the table
                    row.fadeOut(400, function() {
                        $(this).remove();
                    });
                },
                error: function() {
                    alert('Error deleting service');
                }
            });
        }
    });

    // $('#btnDelete').on('click', function() {
    //     var row = $(this).closest('tr');
    //     var serviceId = row.data('id');

    //     $.ajax({
    //         url: 'admin/delete_service.php',
    //         type: 'POST',
    //         data: { id: serviceId },
    //         success: function(response) {
    //             console.log(response);
    //             alert('Service deleted successfully');

    //             //reload the page
    //             location.reload();
    //         },
    //         error: function() {
    //             alert('Error deleting service');
    //         }
    //     });
    // });

    $('#btnAddNew').on('click', function() {
        var row = $(this).closest('tr');
        var data = {
            name: row.find('input[data-field="name"]').val(),
            description: row.find('input[data-field="description"]').val(),
            price: row.find('input[data-field="price"]').val(),
            promo_code: row.find('input[data-field="promo_code"]').val(),
            promo_amt: row.find('input[data-field="promo_amt"]').val()
        };

        $.ajax({
            url: 'admin/add_service.php',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
                alert('Service added successfully');

                //reload the page
                location.reload();
            },
            error: function() {
                alert('Error adding service');
            }
        });
    });

    $('.save-btn').on('click', function() {
        var row = $(this).closest('tr');
        var serviceId = row.data('id');
        var data = {
            id: serviceId,
            name: row.find('input[data-field="name"]').val(),
            description: row.find('input[data-field="description"]').val(),
            price: row.find('input[data-field="price"]').val(),
            promo_code: row.find('input[data-field="promo_code"]').val(),
            promo_amt: row.find('input[data-field="promo_amt"]').val()
        };

        $.ajax({
            url: 'admin/edit_service.php',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
                alert('Service updated successfully');
            },
            error: function() {
                alert('Error updating service');
            }
        });
    });
});
</script>
</body>
</html>
