<?php

include '../dbconnection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = $_POST['id'];
    $customer_email = $_POST['customer_email'];
    $rental_status = $_POST['rental_status'];

    $stmt = $conn->prepare("UPDATE rental SET rental_status = ? WHERE id = ?");
    $stmt->bind_param("si", $rental_status, $rental_id);

    if ($stmt->execute()) {
        echo "Status updated successfully!";

    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location:../../../staff/booking_management.php ");
exit;
?>
