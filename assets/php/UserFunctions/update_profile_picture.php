<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['username']) && !isset($_COOKIE['username'])) {
    header('Location: ../../../authentication.php');
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : $_COOKIE['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilePicUpload'])) {
    
    $target_dir = "../../database/user-profiles-pic/";
    
    $file = $_FILES['profilePicUpload'];
    $fileName = basename($file['name']);
    $target_file = $target_dir . $fileName;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }
    
    if ($file["size"] > 2000000) {
        die("Sorry, your file is too large.");
    }

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        die("Sorry, only JPG, JPEG, & PNG files are allowed.");
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        
        $stmt = $conn->prepare("UPDATE clients SET profile_picture = ? WHERE username = ?");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ss", $fileName, $username);
        if ($stmt->execute()) {
            
            header("Location: ../../../profile.php");
        } else {
            echo "Error updating profile picture.";
        }

        $stmt->close();
        $conn->close();
    } else {
        die("Sorry, there was an error uploading your file.");
    }
} else {
    echo "No file uploaded.";
}

?>