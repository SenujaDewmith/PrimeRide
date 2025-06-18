<?php
include '../dbconnection.php'; 


if (isset($_GET['id'])) {
    $id = $_GET['id'];

  
    $sql = "DELETE FROM staff WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Staff member deleted successfully";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

    // Redirect back to the viewstaff page
    header("Location: ../../../admin/staffmanagement.php");
} else {
    $_SESSION['message'] = "Invalid request";
    header("Location: ../../../admin/staffmanagement.php");
}

$conn->close(); 
?>
