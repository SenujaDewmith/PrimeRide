<?php

include '../dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rental_id = $_POST['id'];

    
    $sql = "SELECT client_id, receipt_url FROM rental WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rental_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $client_id = $row['client_id'];
        $receiptUrl = "../../database/payment-slips/" . $row['receipt_url'];

        
        if (!empty($row['receipt_url']) && file_exists($receiptUrl)) {
            unlink($receiptUrl); 
        }

        
        $sql = "DELETE FROM rental WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $rental_id);

        if ($stmt->execute()) {
            echo "Booking and receipt deleted successfully.";
            header("Location: ../../../staff/booking_management.php");
            exit; 
        } else {
            echo "Error deleting booking: " . $conn->error;
        }

    } else {
        echo "No booking found with the given rental ID.";
    }

    $stmt->close();
}
$conn->close();
?>
