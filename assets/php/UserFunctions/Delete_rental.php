<?php


include('../dbconnection.php'); // Make sure the path is correct

if (isset($_GET['rental_id'])) {
    $rental_id = $_GET['rental_id'];

    
    $sql = "DELETE FROM rental WHERE rental_id = ?";
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

    // Redirect back to the main page
    header("Location: ../../../profile.php"); 
    exit();
}

// Close the connection
$conn->close();
?>
