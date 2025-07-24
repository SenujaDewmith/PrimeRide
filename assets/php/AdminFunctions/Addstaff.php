<?php
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];           
    $staffusername = $_POST['staffusername']; 
    $staffpassword = $_POST['staffpassword']; 
    

    $hashed_password = password_hash($staffpassword, PASSWORD_DEFAULT);


    $sql = "INSERT INTO staff (username, password)
            VALUES(?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $staffusername,$hashed_password);

   
    if ($stmt->execute()) {
        $_SESSION['message'] = "Staff member added successfully";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    
    header("Location: ../../../admin/staffmanagement.php");
}
?>
