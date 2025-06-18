<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = (int)$_POST['rental_id'];

    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
        $receipt_path = $_FILES['receipt']['name'];
        $target_dir = "../../database/payment-slips/";
        $target_file = $target_dir . basename($receipt_path);
        
        
        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $target_file)) {
            
            
            $sql = "UPDATE rental SET receipt_url = ? WHERE rental_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $target_file, $rental_id);
            
            if ($stmt->execute()) {
                
                $sql_email = "SELECT customer_email FROM rental WHERE rental_id = ?";
                $stmt_email = $conn->prepare($sql_email);
                $stmt_email->bind_param("i", $rental_id);
                $stmt_email->execute();
                $result_email = $stmt_email->get_result();
                $row_email = $result_email->fetch_assoc();
                $customer_email = $row_email['customer_email'];
                
                
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
                    $mail->Subject = 'Payment Slip Uploaded Successfully';
                    $mail->Body = "
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 0;
                                padding: 0;
                                background-color: #f4f4f4;
                            }
                            .email-container {
                                max-width: 600px;
                                margin: 20px auto;
                                background-color: #ffffff;
                                padding: 20px;
                                border-radius: 8px;
                                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                            }
                            .header {
                                background-color: #4CAF50;
                                padding: 20px;
                                text-align: center;
                                color: white;
                                border-radius: 8px 8px 0 0;
                            }
                            .header h1 {
                                margin: 0;
                                font-size: 24px;
                            }
                            .content {
                                padding: 20px;
                                color: #333333;
                                line-height: 1.6;
                            }
                            .footer {
                                text-align: center;
                                font-size: 12px;
                                color: #777777;
                                padding: 10px;
                                border-top: 1px solid #dddddd;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='email-container'>
                            <div class='header'>
                                <h1>Payment Slip Uploaded</h1>
                            </div>
                            <div class='content'>
                                <p>Dear Customer,</p>
                                <p>Your payment slip for rental ID <strong>#{$rental_id}</strong> has been uploaded successfully.</p>
                                <p>Please wait while we review your payment. You will receive a confirmation once the payment is approved.</p>
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

                    
                    header("Location:../../../profile.php"); 
                    exit();
                } catch (Exception $e) {
                    echo "Error sending email: {$mail->ErrorInfo}";
                }

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
