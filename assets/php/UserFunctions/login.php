<?php
session_start();

include '../dbconnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {

        // prevent session fixation
        session_regenerate_id(true);

        //Stores user information email & name in the session
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name']; 

        header('Location: ../../../profile.php');
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: ../../../authentication.php');
    }
} else {
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: ../../../authentication.php');
}
?>
