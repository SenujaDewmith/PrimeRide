<?php
session_start();
include '../dbconnection.php';

// Validate email session or cookie
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header('Location: ../../../authentication.php');
    exit();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : $_COOKIE['email'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePicUpload'])) {

    $target_dir = "../../database/user-profiles-pic/";
    $file = $_FILES['profilePicUpload'];

    // Validate image file
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        die("File is not a valid image.");
    }

    // Check file size (max 2MB)
    if ($file["size"] > 2 * 1024 * 1024) {
        die("File is too large. Maximum allowed size is 2MB.");
    }

    // Allow only JPG, JPEG, PNG
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    // Generate unique filename
    $uniqueName = uniqid('profile_', true) . '.' . $imageFileType;
    $target_file = $target_dir . $uniqueName;

    // Move uploaded file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {

        // Update the database using email (not name!)
        $stmt = $conn->prepare("UPDATE clients SET profile_picture = ? WHERE email = ?");
        if (!$stmt) {
            die("Database error: " . $conn->error);
        }

        $stmt->bind_param("ss", $uniqueName, $email);

        if ($stmt->execute()) {
            header("Location: ../../../profile.php");
            exit();
        } else {
            die("Error updating profile picture.");
        }

        $stmt->close();
        $conn->close();
    } else {
        die("There was an error uploading your file.");
    }
} else {
    die("No file uploaded or invalid request.");
}
?>
