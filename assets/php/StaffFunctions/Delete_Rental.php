<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rental_id = $_POST['rental_id'];

    
    $sql = "SELECT customer_email, receipt_url FROM rental WHERE rental_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $rental_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_email = $row['customer_email'];
        $receiptUrl = "../../database/payment-slips/" . $row['receipt_url'];

        
        if (!empty($row['receipt_url']) && file_exists($receiptUrl)) {
            unlink($receiptUrl); 
        }

        
        $sql = "DELETE FROM rental WHERE rental_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $rental_id);

        if ($stmt->execute()) {
            
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'abhistreamsyt01@gmail.com';
                $mail->Password = 'qoeq udkn ldzm ehdm';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('support@primeride.com', 'Prime Ride');
                $mail->addAddress($customer_email);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Booking Cancellation Notification';
                $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 0; margin: 0; }
                        .email-container { max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                        .header { background-color: #e74c3c; padding: 20px; text-align: center; color: white; border-radius: 8px 8px 0 0; }
                        .content { padding: 20px; color: #333; line-height: 1.6; }
                        .footer { text-align: center; font-size: 12px; color: #777; padding: 10px; border-top: 1px solid #ddd; }
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='header'>
                            <h1>Booking Cancellation</h1>
                        </div>
                        <div class='content'>
                            <p>Dear Customer,</p>
                            <p>We regret to inform you that your booking with ID <strong>$rental_id</strong> has been cancelled.</p>
                            <p>If you have any questions, feel free to reach out to us at support@primeride.com.</p>
                        </div>
                        <div class='footer'>
                            <p>&copy; 2024 Prime Ride. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
                ";

                $mail->send();
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }

            echo "Booking and receipt deleted successfully.";
            header("Location: ../../../staff/staffdashboard.php");
            exit; 
        } else {
            echo "Error deleting booking: " . $conn->error;
        }

    } else {
        echo "No booking found with the given rental ID.";
    }

    $stmt->close();
}
$conn->close();
?>
