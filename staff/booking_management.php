
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prime Ride | Staff Dashboard | Booking</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/staff.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            padding-right: 50px;
            margin-left: 300px; 
            
        }

        .booking h2 {
            margin-bottom: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<?php include '../assets/php/dbconnection.php'; ?>

<?php include 'components/staff_header.php'; ?>

<?php include 'components/staff_sidebar.php'; ?>

<!-- Main Content -->
<div class="content-wrapper booking">
    <h2 class="text-center">- Booking Management -</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Rental ID</th>
                <th>Vehicle ID</th>
                <th>Client ID</th>
                <th>Total Price</th>
                <th>Duration (days)</th>
                <th>Pickup Date</th>
                <th>Dropoff Date</th>
                <th>Status</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, vehicle_id, client_id, total_price, rental_duration, 
                    pickup_date, dropoff_date, rental_status, receipt_url FROM rental";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $receiptUrl = "../assets/Photo/paymentreciepts/{$row['receipt_url']}";

                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['vehicle_id']}</td>
                            <td>{$row['client_id']}</td>
                            <td>{$row['total_price']}</td>
                            <td>{$row['rental_duration']}</td>
                            <td>{$row['pickup_date']}</td>
                            <td>{$row['dropoff_date']}</td>
                            <td>
                                <form method='post' action='../assets/php/StaffFunctions/ViewRentals.php'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <input type='hidden' name='client_id' value='{$row['client_id']}'>
                                    <select class='form-select form-select-sm' name='rental_status'>
                                        <option value='Payment pending' " . ($row['rental_status'] == 'Payment pending' ? 'selected' : '') . ">Payment pending</option>
                                        <option value='Approved' " . ($row['rental_status'] == 'Approved' ? 'selected' : '') . ">Approved</option>
                                    </select>
                            </td>
                            <td>
                                <div class='d-flex gap-2'>
                                    <button class='btn btn-success btn-sm' type='submit'>Update</button>
                                </form>

                                <button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#receiptModal' onclick='showReceipt(\"$receiptUrl\")'>Receipt</button>
                                </div>
                            </td>
                            <td>
                                <form method='post' action='../assets/php/StaffFunctions/Delete_Rental.php'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button class='btn btn-danger btn-sm' type='submit' onclick='return confirm(\"Are you sure you want to delete this booking?\");'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='text-center'>No bookings found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="receiptContent">
                <p id="receiptMessage">Loading receipt...</p>
            </div>
        </div>
    </div>
</div>


<script>
function showReceipt(receiptUrl) {
    var receiptContent = document.getElementById("receiptContent");
    if (receiptUrl && receiptUrl !== "../assets/Photo/paymentreciepts/") {
        receiptContent.innerHTML = "<iframe src='" + receiptUrl + "' style='width:100%; height:600px;' frameborder='0'></iframe>";
    } else {
        receiptContent.innerHTML = "<p class='text-danger'>Receipt not available.</p>";
    }
}
</script>

<script defer src="../assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
