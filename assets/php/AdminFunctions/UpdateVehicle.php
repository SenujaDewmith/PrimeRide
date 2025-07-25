<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_type = $_POST['vehicle_type'];
    $model = $_POST['model'];
    $seats = $_POST['seats'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $license_plate = $_POST['license_plate'];
    $price_perday = $_POST['price_perday']; 

    
    $sql = "SELECT image_path FROM vehicles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($current_image_path);
    $stmt->fetch();
    $stmt->close();

    if ($_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../Photo/Vehicleimg/";
        $old_image_path = $target_dir . $current_image_path;

        if (file_exists($old_image_path)) {
            unlink($old_image_path); 
        }

        $image_path = $_FILES['image_path']['name'];
        $target_file = $target_dir . basename($image_path);
        move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file);

        //with propic updating
        $sql = "UPDATE vehicles SET vehicle_name = ?, model = ?, vehicle_type = ?, seats = ?, fuel_type = ?, transmission = ?, license_plate = ?, image_path = ?, price_perday = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisssssi", $vehicle_name, $model, $vehicle_type, $seats, $fuel_type, $transmission, $license_plate, $image_path, $price_perday, $id);
    } else {
        
        //without propic updating
        $sql = "UPDATE vehicles SET vehicle_name = ?, model = ?, vehicle_type = ?, seats = ?, fuel_type = ?, transmission = ?, license_plate = ?, price_perday = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissssi", $vehicle_name, $model, $vehicle_type, $seats, $fuel_type, $transmission, $license_plate, $price_perday, $id);
    }

    if ($stmt->execute()) {
        
        echo "Vehicle updated successfully.";
    } else {
        
        echo "Error updating vehicle: " . $stmt->error;
    }

   
    $stmt->close();
    $conn->close();

  
    header("Location:../../../admin/vehiclemanagement.php");
    exit();
}
?>
