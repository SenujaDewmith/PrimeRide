<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_name = $_POST['vehicle_name']; 
    $model = $_POST['model']; 
    $seats = (int)$_POST['seats']; 
    $fuel_type = $_POST['fuel_type']; 
    $transmission = $_POST['transmission']; 
    $license_plate = $_POST['license_plate']; 

    if (isset($_POST['price_perday']) && is_numeric($_POST['price_perday'])) {
        $price_perday = number_format(floatval($_POST['price_perday']), 2, '.', ''); 
    } else {
        die("Invalid price input.");
    }

    $image_path = $_FILES['image_path']['name']; 
    $target_dir = "../../Photo/Vehicleimg/";
    $target_file = $target_dir . basename($image_path);

    // Move uploaded image
    move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);

    // Check for duplicate license plate
    $checkSql = "SELECT id FROM vehicles WHERE license_plate = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $license_plate);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // License plate exists
        echo '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>License Plate Exists</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Bootstrap Modal -->
  <div class="modal fade show" id="errorModal" tabindex="-1" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Duplicate Entry</h5>
        </div>
        <div class="modal-body">
          This license plate is already registered!
        </div>
        <div class="modal-footer">
          <button onclick="history.back()" class="btn btn-danger">Go Back</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-backdrop fade show"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto go back after 3 seconds
    setTimeout(function() {
      history.back();
    }, 3000);
  </script>
</body>
</html>';
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    // Insert new vehicle
    $sql = "INSERT INTO vehicles (vehicle_name, model, seats, fuel_type, transmission, license_plate, image_path, price_perday) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissssd", $vehicle_name, $model, $seats, $fuel_type, $transmission, $license_plate, $image_path, $price_perday);

    if ($stmt->execute()) {
        header("Location:../../../admin/vehiclemanagement.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
