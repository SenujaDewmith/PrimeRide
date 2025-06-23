<?php
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];           
    $staffusername = $_POST['staffusername']; 
    $staffpassword = $_POST['staffpassword']; 
    
    
    $hashed_password = password_hash($staffpassword, PASSWORD_DEFAULT);


    $sql = "INSERT INTO staff (id, username, password)
            VALUES ('$staff_id', '$staffusername', '$hashed_password')";

   
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Staff member added successfully";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

   
    $conn->close();

    
    header("Location: ../../../admin/staffmanagement.php");
}
?>
