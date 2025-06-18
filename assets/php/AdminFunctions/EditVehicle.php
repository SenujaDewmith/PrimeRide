<?php
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['vehicleId'];
    $vehicle_name = $_POST['editVehicleName'];
    $model = $_POST['editVehicleModel'];
    $seats = $_POST['editSeats'];
    $fuel_type = $_POST['editFuelType'];
    $transmission = $_POST['editTransmission'];
    $license_plate = $_POST['editLicensePlate'];
    $target_dir = "../assets/vehicles/";

    
    if (!empty($_FILES["editVehicleImage"]["name"])) {
        $target_file = $target_dir . basename($_FILES["editVehicleImage"]["name"]);
        move_uploaded_file($_FILES["editVehicleImage"]["tmp_name"], $target_file);

       
        $sql = "UPDATE vehicles SET vehicle_name='$vehicle_name', model='$model', seats='$seats', 
                fuel_type='$fuel_type', transmission='$transmission', license_plate='$license_plate', 
                image_path='$target_file' WHERE id=$id";
    } else {
        
        $sql = "UPDATE vehicles SET vehicle_name='$vehicle_name', model='$model', seats='$seats', 
                fuel_type='$fuel_type', transmission='$transmission', license_plate='$license_plate' 
                WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Vehicle updated successfully";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

    $conn->close();
    header("Location:../../../../Pages/Dashboards/admindashboard.php");
}
?>
