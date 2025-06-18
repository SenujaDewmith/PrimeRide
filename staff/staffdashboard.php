<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="staff.css">
  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PrimeRide | Staff Dashboard</title>
</head>

<body>
  <!-- Header -->
  <header class="p-3 text-bg-dark header">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="../assets/Photo/Logo.png" class="navlogo" alt="PrimeRide Logo">
          </a>
          <h1>PrimeRide Staff Dashboard</h1>
        </div>
      </div>
    </div>
  </header>

  <!-- Dashboard -->
  <div class="container my-5">
    <h1 class="text-center">Staff Dashboard</h1>
<!-- Bookings -->
<?php
include '../assets/php/dbconnection.php'; 
?>
<div class="content">
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
        $sql = "SELECT rental_id, customer_username, customer_email, vehicle_name, plate_number, model, rental_duration, 
                pickup_date, dropoff_date, rental_status, receipt_url FROM rental"; 
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output each row
            while($row = $result->fetch_assoc()) {
                // Construct the receipt URL
                $receiptUrl = "../assets/Photo/paymentreciepts/{$row['receipt_url']}";

                echo "<tr>
                        <td>{$row['rental_id']}</td>
                        <td>{$row['customer_username']}</td>
                        <td>{$row['customer_email']}</td>
                        <td>{$row['vehicle_name']}</td>
                        <td>{$row['plate_number']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['rental_duration']}</td>
                        <td>{$row['pickup_date']}</td>
                        <td>{$row['dropoff_date']}</td>
                        <td>
                            <form method='post' action='../assets/php/StaffFunctions/ViewRentals.php'>
                                <input type='hidden' name='rental_id' value='{$row['rental_id']}'>
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
                            <form method='post' action='../assets/php/StaffFunctions/Delete_Rental.php' style='display:inline;'>
                                <input type='hidden' name='rental_id' value='{$row['rental_id']}'>
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


    <!-- Update Gallery Section -->
    <?php

include '../assets/php/dbconnection.php';


?>
<div class="content">
  <h2>Gallery Management</h2>
  
  <!-- Form for uploading images -->
  <form action="../assets/php/StaffFunctions/Update_gallery.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="image" class="form-label">Choose an Image</label>
      <input type="file" class="form-control" name="image" id="image" required>
    </div>
    <button type="submit" class="btn btn-success">Upload to the gallery</button>
  </form>
  <div class="row mt-4">
    <?php
    // Fetch items from the gallery
    $sql = "SELECT id, title, image_path FROM gallery";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="../assets/Photo/Galleryimg/<?php echo $row['image_path']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['title']; ?></h5>
              <form action="../assets/php/StaffFunctions/Delete_gallery_item.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p class='text-center'>Gallery Still Updating</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>
</div>


  <!-- Footer -->
  <footer id="footer" class="footer dark-background">
    <div class="container">
      <div class="row gy-3">
        <!-- Footer details -->
      </div>
    </div>
    <hr class="featurette-divider">
    <div class="container text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">PrimeRide</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href=""></a>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
