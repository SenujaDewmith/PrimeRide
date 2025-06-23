<?php
session_start();
include '../dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

  
    if ($username === 'admin' && $password === 'admin') {
   
        $_SESSION['user_role'] = 'admin';
        $_SESSION['username'] = $username;

       //change the index.html to vehiclemgmt/php
        header('Location: ../../../admin/vehiclemanagement.php');
        exit();
    } else {
       
        $sql = "SELECT * FROM staff WHERE staffusername = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

       
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            if (password_verify($password, $row['staffpassword'])) {
         
                $_SESSION['user_role'] = 'staff';
                $_SESSION['username'] = $username;

                
                header('Location:../../../staff/staffdashboard.php');
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
