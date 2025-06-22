<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../dbconnection.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$profile_picture = $_FILES['profile_picture'];

if ($password !== $confirm_password) {
    $_SESSION['error'] = 'Passwords do not match.';
    header('Location: ../../../authentication.php');
    exit();
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$checkUser = $conn->prepare("SELECT * FROM clients WHERE email = ?");
$checkUser->bind_param("s", $email);
$checkUser->execute();
$result = $checkUser->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = ' email already exists.';
    header('Location: ../../../authentication.php');
} else {
    // Handle profile picture upload
    $profile_picture_name = 'default.jpg';
    if ($profile_picture['size'] > 0) {
        $profile_picture_name = time() . "_" . basename($profile_picture["name"]);
        $target_dir = "../../database/user-profiles-pic/";
        $target_file = $target_dir . $profile_picture_name;
        move_uploaded_file($profile_picture["tmp_name"], $target_file);
    }

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO clients ( name, email, password, profile_picture) VALUES ( ?, ?, ?, ?)");
    $stmt->bind_param("ssss",  $name, $email, $hashed_password, $profile_picture_name);
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
            $mail->addAddress($email, $name); 

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Prime Ride';
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
                        <h1>Welcome to Prime Ride, $name!</h1>
                    </div>
                    <div class='content'>
                        <p>Dear $name,</p>
                        <p>Thank you for signing up with Prime Ride! We're excited to have you on board.</p>
                        <p>Your username is: <strong>$username</strong></p>
                        <p>You can now log in and start exploring our services.</p>
                        <p>If you have any questions or need assistance, feel free to reach out to us at support@primeride.com.</p>
                        <p><a href='localhost/primeride/authentication.php' class='button'>Log In Now</a></p>
                    </div>
                    <div class='footer'>
                        <p>&copy; 2024 Prime Ride. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();
            echo "<script>
                    alert('Signup successful. A confirmation email has been sent.');
                    setTimeout(function() {
                        window.location.href = '../../../authentication.php?showLogin=true';
                    }, 5000);
                  </script>";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = 'Signup failed. Please try again.';
        header('Location: ../../../authentication.php');
    }
}
?>
