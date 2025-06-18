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

  
    move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);


    $sql = "INSERT INTO vehicles (vehicle_name, model, seats, fuel_type, transmission, license_plate, image_path, price_perday) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bind_param("ssiisssd", $vehicle_name, $model, $seats, $fuel_type, $transmission, $license_plate, $image_path, $price_perday);


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
