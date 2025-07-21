<?php

include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $plate_number = $_POST['plate_number'];
    $email = $_POST['email'];
    $rental_duration = $_POST['rental_duration'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $total_price = $_POST['total_price'];


    $rental_status = "Pending Payment";
    $created_at = date('Y-m-d H:i:s');
    $rental_id = rand(100000, 999999);//unused

    // Fetch vehicle_id
    $stmt_vehicle = $conn->prepare("SELECT id, vehicle_name, model FROM vehicles WHERE license_plate = ?");
    $stmt_vehicle->bind_param("s", $plate_number);
    $stmt_vehicle->execute();
    $result_vehicle = $stmt_vehicle->get_result();

    if ($result_vehicle->num_rows === 0) {
        echo "<script>alert('Vehicle not found.'); window.location.href = '../../../rent-car.php';</script>";
        exit();
    }

    $vehicle = $result_vehicle->fetch_assoc();
    $vehicle_id = $vehicle['id'];
    $vehicle_name = $vehicle['vehicle_name'];
    $model = $vehicle['model'];
    $stmt_vehicle->close();

    // Fetch client_id
    $stmt_client = $conn->prepare("SELECT id, name, email FROM clients WHERE email = ?");
    $stmt_client->bind_param("s", $email);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();

    if ($result_client->num_rows === 0) {
        echo "<script>alert('Client not found.'); window.location.href = '../../../rent-car.php';</script>";
        exit();
    }

    $client = $result_client->fetch_assoc();
    $client_id = $client['id'];
    $customer_name = $client['name'];
    $customer_email = $client['email'];
    $stmt_client->close();

    // Check for date conflicts
    $sql_check = "SELECT * FROM rental 
                  WHERE vehicle_id = ? 
                  AND (rental_status = 'Pending Payment' OR rental_status = 'Approved')
                  AND (
                        (pickup_date BETWEEN ? AND ?) OR
                        (dropoff_date BETWEEN ? AND ?) OR
                        (? BETWEEN pickup_date AND dropoff_date) OR
                        (? BETWEEN pickup_date AND dropoff_date)
                      )";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("issssss", $id, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('System Alert: The vehicle is not available during the selected dates.');
                window.location.href = '../../../rent-car.php';
              </script>";
    } else {
        $sql = "INSERT INTO rental ( vehicle_id, client_id, rental_duration, pickup_date, dropoff_date, total_price, rental_status, created_at) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissdss", $vehicle_id, $client_id, $rental_duration, $pickup_date, $dropoff_date, $total_price, $rental_status, $created_at);

        if ($stmt->execute()) {
          include 'success_modal.php';          
        } 
        else {
            echo "<script>
                    alert('Error: Could not submit the rental request.');
                    window.location.href = '../../../rent-car.php';
                  </script>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
