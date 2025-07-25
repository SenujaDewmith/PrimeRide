<?php

include('../dbconnection.php'); 

if (isset($_GET['rental_id'])) {
    $rental_id = $_GET['rental_id'];

    
    $sql = "DELETE FROM rental WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $rental_id);

        if ($stmt->execute()) {
            echo "<script>alert('Rental ID $rental_id has been successfully deleted.');</script>";
        } else {
            echo "<script>alert('Error deleting rental.');</script>";
        }

       
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing the delete statement.');</script>";
    }

    //redirect to myaccount
    header("Location: ../../../profile.php"); 
    exit();
}


$conn->close();
?>
