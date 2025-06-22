<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

include '../dbconnection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = $_POST['id'];
    $customer_email = $_POST['customer_email'];
    $rental_status = $_POST['rental_status'];

    $stmt = $conn->prepare("UPDATE rental SET rental_status = ? WHERE id = ?");
    $stmt->bind_param("si", $rental_status, $rental_id);

    if ($stmt->execute()) {
        echo "Status updated successfully!";

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
            $mail->Subject = 'Rental Status Update';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
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
                    .content p {
                        margin-bottom: 20px;
                    }
                    .footer {
                        text-align: center;
                        font-size: 12px;
                        color: #777777;
                        padding: 10px;
                        border-top: 1px solid #dddddd;
                    }
                    .footer p {
                        margin: 0;
                    }
                    .button {
                        background-color: #4CAF50;
                        color: white;
                        padding: 10px 20px;
                        text-decoration: none;
                        border-radius: 4px;
                        display: inline-block;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <h1>Rental Status Update</h1>
                    </div>
                    <div class='content'>
                        <p>Dear Customer,</p>
                        <p>We would like to inform you that the status of your rental with ID <strong>$rental_id</strong> has been updated to <strong>$rental_status</strong>.</p>
                        <p>If you have any questions, feel free to contact us at support@primeride.com</p>
                        <p><a href='localhost/primeride/profile.php' class='button'>View Rental Details</a></p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2024 Prime Ride</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();
        } catch (Exception $e) {
            echo "Error: Could not send the email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location:../../../staff/staffdashboard.php ");
exit;
?>
