<?php
session_start();
include '../dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

  
    if ($username === 'Prasanna@primeride' && $password === 'Prasanna@123') {
   
        $_SESSION['user_role'] = 'Prasanna@primeride';
        $_SESSION['username'] = $username;

        header('Location: ../../../admin/vehiclemanagement.php');
        exit();
    } else {
       
        $sql = "SELECT * FROM staff WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

       
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['password'])) {
         
                $_SESSION['user_role'] = 'staff';
                $_SESSION['username'] = $username;

                
                header('Location:../../../staff/booking_management.php');
                exit();
            } else {
                
                $_SESSION['error_message'] = 'Incorrect password!';
                header('Location: ../../../Controlpanel.php');
                exit();
            }
        } else {
            
            $_SESSION['error_message'] = 'Username not found!';
            header('Location: ../../../Controlpanel.php');
            exit();
        }
    }
}
?>
