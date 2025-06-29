<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../dbconnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        
        session_regenerate_id(true); // prevent session fixation

        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];

     
       
        
        
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'abhistreamsyt01@gmail.com';
            $mail->Password = 'qoeq udkn ldzm ehdm';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('support@primeride.com', 'Prime Ride');
            $mail->addAddress($user['email'], $user['name']);

            $mail->isHTML(true);
            $mail->Subject = 'Login Notification';
            $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 0; margin: 0; }
                    .email-container { max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                    .header { background-color: #4CAF50; padding: 20px; text-align: center; color: white; border-radius: 8px 8px 0 0; }
                    .content { padding: 20px; color: #333; line-height: 1.6; }
                    .footer { text-align: center; font-size: 12px; color: #777; padding: 10px; border-top: 1px solid #ddd; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <h1>Login Notification</h1>
                    </div>
                    <div class='content'>
                        <p>Hello, {$user['name']}</p>
                        <p>Your account was successfully logged into Prime Ride.</p>
                        <p>If this was not you, please secure your account immediately.</p>
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
    
        }

        header('Location: ../../../profile.php');
    } else {
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: ../../../authentication.php');
    }
} else {
    $_SESSION['error'] = 'Invalid username or password.';
    header('Location: ../../../authentication.php');
}
?>
