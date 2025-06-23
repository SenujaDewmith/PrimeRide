<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/management.css"/>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script defer src="../assets/js/bootstrap.bundle.min.js"></script>

</head>

<body>
<!-- header -->
<?php include 'components/admin_header.php'; ?>

  
<!-- Sidebar -->
<?php include 'components/admin_sidebar.php';?>


<!-- Main Content Area -->
<!-- Bookings -->
<?php
include '../assets/php/dbconnection.php'; 
?>
<div class="content min-vh-100">
    <h2>Booking Management</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Rental ID</th>
          <th>Customer</th>
          <th>Email Address</th>
          <th>Vehicle</th>
          <th>Plate Number</th>
          <th>Model</th>
          <th>Duration (days)</th>
          <th>Pickup Date</th>
          <th>Dropoff Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Fetch rental data
        $sql = "
        SELECT
          r.id,
          c.name AS customer_name,
          c.email AS customer_email,
          v.vehicle_name,
          v.license_plate AS plate_number,
          v.model,
          r.rental_duration,
          r.pickup_date,
          r.dropoff_date,
          r.rental_status,
          r.receipt_url
        FROM rental r
        JOIN clients c ON r.client_id = c.id
        JOIN vehicles v ON r.vehicle_id = v.id
      ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output each row
            while($row = $result->fetch_assoc()) {
                // Construct the receipt URL
                $receiptUrl = "../assets/Photo/paymentreciepts/{$row['receipt_url']}";

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['customer_email']}</td>
                        <td>{$row['customer_email']}</td>
                        <td>{$row['vehicle_name']}</td>
                        <td>{$row['plate_number']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['rental_duration']}</td>
                        <td>{$row['pickup_date']}</td>
                        <td>{$row['dropoff_date']}</td>
                        <td>
                            <form method='post' action='../assets/php/AdminFunctions/ViewRentals.php'>
                                <input type='hidden' name='rental_id' value='{$row['id']}'>
                                <input type='hidden' name='customer_email' value='{$row['customer_email']}'>
                                <select class='form-select' name='rental_status'>
                                    <option value='Available' " . ($row['rental_status'] == 'Available' ? 'selected' : '') . ">Available</option>
                                    <option value='Out' " . ($row['rental_status'] == 'Out' ? 'selected' : '') . ">Out</option>
                                    <option value='Payment pending' " . ($row['rental_status'] == 'Payment pending' ? 'selected' : '') . ">Payment pending</option>
                                    <option value='Processing' " . ($row['rental_status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                                    <option value='In service' " . ($row['rental_status'] == 'In service' ? 'selected' : '') . ">In service</option>
                                    <option value='Approved' " . ($row['rental_status'] == 'Approved' ? 'selected' : '') . ">Approved</option> <!-- New option added -->
                                </select>
                        </td>
                        <td>
                            <button class='btn btn-success' type='submit'>Update Status</button>
                            </form>
                        </td>
                        <td>
                            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#receiptModal' onclick='showReceipt(\"$receiptUrl\")'>View Receipt</button>
                            <form method='post' action='../assets/php/AdminFunctions/DeleteRental.php' style='display:inline;'>
                                <input type='hidden' name='rental_id' value='{$row['id']}'>
                                <button class='btn btn-danger' type='submit' onclick='return confirm(\"Are you sure you want to delete this booking?\");'>Delete</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No bookings found</td></tr>";
        }

        $conn->close();
        ?>
      </tbody>
    </table>
</div>

<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
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
    var receiptMessage = document.getElementById("receiptMessage");

    if (receiptUrl) {
        // If URL exists, display it
        receiptContent.innerHTML = "<iframe src='" + receiptUrl + "' style='width: 100%; height: 500px;' frameborder='0'></iframe>";
    } else {
        // If no URL, show an error message
        receiptContent.innerHTML = "";
        receiptMessage.innerHTML = "Error: Receipt does not exist.";
    }
}
</script>

<?php include 'components/admin_footer.php'; ?>

</body>
</html>
