<?php
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST['title'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $basis = $_POST['basis'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO messages (title, name, email, phone, basis_of_hire, message)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $name, $email, $phone, $basis, $message);

    if ($stmt->execute()) {
        header("Location: ../../../contactus.php?success=1");
    } else {
        header("Location: ../../../contactus.php?error=1");
    }

    $stmt->close();
    $conn->close();
}
    
?>
