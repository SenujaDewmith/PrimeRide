<?php
include '../dbconnection.php';

if (isset($_GET['plate_number'])) {
    $plate = $_GET['plate_number'];

    $stmt = $conn->prepare("SELECT id FROM vehicles WHERE license_plate = ?");
    $stmt->bind_param("s", $plate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($vehicle = $result->fetch_assoc()) {
        $vehicle_id = $vehicle['id'];

        $sql = "SELECT pickup_date, dropoff_date FROM rental 
                WHERE vehicle_id = ? 
                AND rental_status IN ('Pending Payment', 'Approved')";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bind_param("i", $vehicle_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $booked_dates = [];
        while ($row = $result2->fetch_assoc()) {
            $booked_dates[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($booked_dates);
    }
}
?>
