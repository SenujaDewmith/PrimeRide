<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {
    header('Location: ../../../authentication.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : $_COOKIE['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];

    
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href = '../../../profile.php';</script>";
        exit();
    }

    
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    
    $stmt = $conn->prepare("UPDATE clients SET password = ? WHERE name = ?");
    if (!$stmt) {
        echo "<script>alert('Database Error.'); window.location.href = '../../../profile.php';</script>";
        die("Prepare failed: " . $conn->error);
    }

    
    $stmt->bind_param("ss", $hashed_password, $username);
    if ($stmt->execute()) {
        echo "<script>alert('Password successfully updated.'); window.location.href = '../../../profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating password: " . $stmt->error . "'); window.location.href = '../../../profile.php';</script>";
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = '../../../profile.php';</script>";
}
?>