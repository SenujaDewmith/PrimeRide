<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $vehicle_name = $_POST['vehicle_name']; 
    $vehicle_make = $_POST['vehicle_make'];
    $model = $_POST['model']; 
    $vehicle_type = $_POST['vehicle_type'];
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
        include 'DuplicatePlate.php';
          
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    // Insert new vehicle
    $sql = "INSERT INTO vehicles (vehicle_make, model, vehicle_type, seats, fuel_type, transmission, license_plate, image_path, price_perday) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssissssd", $vehicle_make, $model, $vehicle_type,  $seats, $fuel_type, $transmission, $license_plate, $image_path, $price_perday);

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
