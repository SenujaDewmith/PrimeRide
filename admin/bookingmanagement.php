<?php include '../assets/php/dbconnection.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/management.css"/>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> 
</head>

<body>

<?php include 'components/admin_header.php'; ?>
<?php include 'components/admin_sidebar.php';?>

<div class="content min-vh-100">
    <h2>Booking Management</h2>

    <div class="mb-3">
      <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#reportModal">
        Generate PDF Report
      </button>
    </div>

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
        // Fetching rental data
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
            
            while($row = $result->fetch_assoc()) {
               
                $receiptFile = "../assets/Photo/paymentreciepts/{$row['receipt_url']}";
                $receiptExists = !empty($row['receipt_url']) && file_exists($receiptFile);
                $receiptUrl = $receiptExists ? $receiptFile : '';


                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['customer_name']}</td>
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
                              <option value='Payment pending' " . ($row['rental_status'] == 'Payment pending' ? 'selected' : '') . ">Payment pending</option>
                                    <option value='Approved' " . ($row['rental_status'] == 'Approved' ? 'selected' : '') . ">Approved</option> <!-- New option added -->
                            </select>
                        </td>
                        <td>
                            <button class='btn btn-success ' type='submit'>Update Status</button>
                            </form>
                        </td>
                        <td>
                         <div class='d-flex gap-2'>
                            <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#receiptModal' onclick='showReceipt(\"$receiptUrl\")'>View Receipt</button>
                            <form method='post' action='../assets/php/AdminFunctions/DeleteRental.php' style='display:inline;'>
                                <input type='hidden' name='rental_id' value='{$row['id']}'>
                                <button class='btn btn-danger btn-sm' type='submit' onclick='return confirm(\"Are you sure you want to delete this booking?\");'>Delete</button>
                            </form>
                              </div>
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

<!-- Receipt modal -->
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


<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="../assets/php/AdminFunctions/GenerateReport.php" target="_blank">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportModalLabel">Select Date Range</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" required>
          </div>
          <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Generate PDF</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>

  //script for receipt
  function showReceipt(receiptUrl) {
    var receiptContent = document.getElementById("receiptContent");

    if (receiptUrl && receiptUrl.trim() !== "") {
        receiptContent.innerHTML = "<iframe src='" + receiptUrl + "' style='width: 100%; height: 500px;' frameborder='0'></iframe>";
    } else {
        receiptContent.innerHTML = "<p class='text-danger'>Receipt has not been uploaded yet.</p>";
    }
}

  //script for date range modal
  document.addEventListener("DOMContentLoaded", function(){
    const startDateInput = document.querySelector('input[name="start_date"]');
    const endDateInput = document.querySelector('input[name="end_date"]');

    endDateInput.disabled = true;

    startDateInput.addEventListener('change', function(){
      const startDateValue = startDateInput.value;

      endDateInput.disabled = false;
      endDateInput.setAttribute('min', startDateValue);
    });

  });

</script>


<?php include 'components/admin_footer.php'; ?>

<script defer src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
