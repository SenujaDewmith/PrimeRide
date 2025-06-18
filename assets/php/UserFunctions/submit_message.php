<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
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
    
    $owner_email = 'abhistreamsyt01@gmail.com';

    
    $mail = new PHPMailer(true);
    try {
       
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abhistreamsyt01@gmail.com';
        $mail->Password = 'qoeq udkn ldzm ehdm'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('support@primeride.com', 'Prime Ride');
        $mail->addAddress($owner_email);  
        $mail->addReplyTo($email_address, $first_name . ' ' . $last_name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message from ' . $first_name . ' ' . $last_name;
        $mail->Body = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
                .email-container { max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                .header { background-color: #4CAF50; padding: 20px; text-align: center; color: white; border-radius: 8px 8px 0 0; }
                .content { padding: 20px; color: #333; line-height: 1.6; }
                .footer { text-align: center; font-size: 12px; color: #777; padding: 10px; border-top: 1px solid #ddd; }
            </style>
        </head>
        <body>
            <div class='email-container'>
                <div class='header'>
                    <h1>New Contact Message</h1>
                </div>
                <div class='content'>
                    <p><strong>Subject:</strong> $subject</p>
                    <p><strong>Rental Type:</strong> $rental_type</p>
                    <p><strong>Name:</strong> $first_name $last_name</p>
                    <p><strong>Mobile Number:</strong> $mobile_number</p>
                    <p><strong>Email:</strong> $email_address</p>
                    <p><strong>Date Range:</strong> $date_range</p>
                    <p><strong>Message:</strong> $message_content</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();

        echo "<script>
                alert('Thank you for contacting us! Your message has been submitted successfully.');
                window.location.href = '../../../Contactus.php';
              </script>";

    } catch (Exception $e) {
        echo "<script>
                alert('Error sending your message. Please try again later.');
                window.location.href = '../../../Contactus.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request.');
            window.location.href = '../../../Contactus.php';
          </script>";
}
?>
