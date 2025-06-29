<?php
session_start();
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

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

// Check for existing email
$checkUser = $conn->prepare("SELECT * FROM clients WHERE email = ?");
$checkUser->bind_param("s", $email);
$checkUser->execute();
$result = $checkUser->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = 'Email already exists.';
    header('Location: ../../../authentication.php');
    exit();
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
    $stmt = $conn->prepare("INSERT INTO clients (name, email, password, profile_picture) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $profile_picture_name);

    if ($stmt->execute()) {
        // // Send welcome email
        // $mail = new PHPMailer(true);
        // try {
        //     $mail->isSMTP();
        //     $mail->Host = 'smtp.gmail.com';
        //     $mail->SMTPAuth = true;
        //     $mail->Username = 'abhistreamsyt01@gmail.com'; 
        //     $mail->Password = 'qoeq udkn ldzm ehdm'; 
        //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //     $mail->Port = 587;

        //     $mail->setFrom('support@primeride.com', 'Prime Ride');
        //     $mail->addAddress($email, $name); 

        //     $mail->isHTML(true);
        //     $mail->Subject = 'Welcome to Prime Ride';
        //     $mail->Body = "
        //     <html>
        //     <head>
        //         <style>
        //             body {
        //                 font-family: Arial, sans-serif;
        //                 background-color: #f4f4f4;
        //             }
        //             .email-container {
        //                 max-width: 600px;
        //                 margin: 20px auto;
        //                 background-color: #ffffff;
        //                 padding: 20px;
        //                 border-radius: 8px;
        //                 box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        //             }
        //             .header {
        //                 background-color: #4CAF50;
        //                 padding: 20px;
        //                 text-align: center;
        //                 color: white;
        //                 border-radius: 8px 8px 0 0;
        //             }
        //             .content {
        //                 padding: 20px;
        //                 color: #333;
        //                 line-height: 1.6;
        //             }
        //             .footer {
        //                 text-align: center;
        //                 font-size: 12px;
        //                 color: #777;
        //                 padding: 10px;
        //                 border-top: 1px solid #ddd;
        //             }
        //             .button {
        //                 background-color: #4CAF50;
        //                 color: white;
        //                 padding: 10px 20px;
        //                 text-decoration: none;
        //                 border-radius: 4px;
        //                 display: inline-block;
        //             }
        //         </style>
        //     </head>
        //     <body>
        //         <div class='email-container'>
        //             <div class='header'>
        //                 <h1>Welcome to Prime Ride, $name!</h1>
        //             </div>
        //             <div class='content'>
        //                 <p>Thank you for signing up with Prime Ride! We're excited to have you on board.</p>
        //                 <p>You can now log in and start exploring our services.</p>
        //                 <p>If you have any questions or need assistance, feel free to reach out to us at support@primeride.com.</p>
        //                 <p><a href='http://localhost/primeride/authentication.php' class='button'>Log In Now</a></p>
        //             </div>
        //             <div class='footer'>
        //                 &copy; 2024 Prime Ride. All rights reserved.
        //             </div>
        //         </div>
        //     </body>
        //     </html>
        //     ";

        //     $mail->send();

            
        // } catch (Exception $e) {
        //     echo "Error sending email: {$mail->ErrorInfo}";
        // }


        // Show offline success message
            echo '
            <style>
                .custom-modal {
                    display: flex;
                    position: fixed;
                    z-index: 9999;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    justify-content: center;
                    align-items: center;
                    background-color: rgba(0,0,0,0.4);
                }

                .custom-modal-content {
                    background-color: #fff;
                    padding: 20px 30px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.25);
                    max-width: 500px;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }

                .custom-modal-content h2 {
                    color: #28a745;
                    margin-bottom: 10px;
                }

                .custom-modal-content p {
                    font-size: 16px;
                    margin: 0;
                }
            </style>

            <div class="custom-modal" id="offlineSuccessModal">
              <div class="custom-modal-content">
                <h2>Signup Successful!</h2>
                <p>You have successfully registered to Prime Ride.</p>
                <p>Redirecting to login page...</p>
              </div>
            </div>

            <script>
              setTimeout(function() {
                window.location.href = "../../../authentication.php?showLogin=true";
              }, 4000);
            </script>
            ';

    } else {
        $_SESSION['error'] = 'Signup failed. Please try again.';
        header('Location: ../../../authentication.php');
        exit();
    }
}
?>
