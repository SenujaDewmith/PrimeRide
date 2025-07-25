<?php

include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = (int)$_POST['rental_id'];

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
        $receipt_path = $_FILES['receipt']['name'];
        $target_dir = "../../database/payment-slips/";
        $target_file = $target_dir . basename($receipt_path);
        
        
        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $target_file)) {
            
            
            $sql = "UPDATE rental SET receipt_url = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $target_file, $rental_id);
            
            if ($stmt->execute()) {
                
                $sql_email = "SELECT c.email FROM clients c JOIN rental r ON r.client_id = c.id WHERE r.id = ?";
                $stmt_email = $conn->prepare($sql_email);
                $stmt_email->bind_param("i", $rental_id);
                $stmt_email->execute();
                $result_email = $stmt_email->get_result();
                $row_email = $result_email->fetch_assoc();
                $customer_email = $row_email['email'];
                
                echo "<script>
                        alert('Receipt uploaded successfully!');
                        window.location.href = '../../../profile.php';
                     </script>";
            } else {
                echo "Error updating rental: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error moving the uploaded receipt file.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}

$conn->close();
?>
