<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header('Location: ../../../authentication.php');
    exit();
}

$email = $_SESSION['email'] ?? $_COOKIE['email'];

// Fetch client ID using email
$stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $client_id = $row['id'];
} else {
    echo "<script>alert('User not found.'); window.location.href = '../../../profile.php';</script>";
    exit();
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];

    $old_password = $_POST['oldPassword'];

// Fetch current hashed password from DB
$stmt = $conn->prepare("SELECT password FROM clients WHERE id = ?");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $currentHashedPassword = $row['password'];

    if (!password_verify($old_password, $currentHashedPassword)) {
        echo "<script>alert('Current password is incorrect.'); window.location.href = '../../../profile.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('User not found.'); window.location.href = '../../../profile.php';</script>";
    exit();
}


    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href = '../../../profile.php';</script>";
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("UPDATE clients SET password = ? WHERE id = ?");
    if (!$stmt) {
        echo "<script>alert('Database Error.'); window.location.href = '../../../profile.php';</script>";
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $hashed_password, $client_id);
    if ($stmt->execute()) {
        echo "<script>alert('Password successfully updated.'); window.location.href = '../../../profile.php';</script>";
    } else {
        echo "<script>alert('Error updating password: " . $stmt->error . "'); window.location.href = '../../../profile.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.location.href = '../../../profile.php';</script>";
}
?>
