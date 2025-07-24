<?php
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $subject = $_POST['subject'];
    $rental_type = $_POST['rental_type'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $email_address = $_POST['email_address'];
    $date_range = $_POST['date_range'];
    $message_content = $_POST['message'];
    
    $sql = "INSERT INTO messages ( subject, rental_type, first_name, last_name, mobile_number, email_address, date_range, message)
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisss", $subject, $rental_type, $first_name, $last_name, $mobile_number, $email_address, $date_range, $message_content);
    $stmt->execute();
    $result = $stmt->get_result();

}
    
?>
