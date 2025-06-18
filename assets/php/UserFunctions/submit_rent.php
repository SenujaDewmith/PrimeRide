<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_name = $_POST['vehicle_name'];
    $plate_number = $_POST['plate_number'];
    $model = $_POST['model'];
    $customer_username = $_POST['customer_username'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $rental_duration = $_POST['rental_duration'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $total_price = $_POST['total_price']; 
    
    $rental_status = "Pending Payment"; 
    $created_at = date('Y-m-d H:i:s');
    $rental_id = rand(100000, 999999); 

    $sql_check = "SELECT * FROM rental 
                  WHERE plate_number = ? 
                  AND (rental_status = 'Pending Payment' OR rental_status = 'Approved')
                  AND (
                        (pickup_date BETWEEN ? AND ?) OR
                        (dropoff_date BETWEEN ? AND ?) OR
                        (? BETWEEN pickup_date AND dropoff_date) OR
                        (? BETWEEN pickup_date AND dropoff_date)
                      )";

    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("sssssss", $plate_number, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        
        echo "<script>
                alert('System Alert : The vehicle is not available during the selected dates.');
                window.location.href = '../../../rent-car.php'; // Redirect back to the rent page
              </script>";
    } else {
        
        $sql = "INSERT INTO rental (rental_id, vehicle_name, plate_number, model, customer_name, customer_username, customer_email, rental_duration, pickup_date, dropoff_date, total_price, rental_status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssssssssss", $rental_id, $vehicle_name, $plate_number, $model, $customer_name, $customer_username, $customer_email, $rental_duration, $pickup_date, $dropoff_date, $total_price, $rental_status, $created_at);

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
                $mail->addAddress($customer_email, $customer_name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Rental Request Confirmation';
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
                            margin: 0 auto;
                            background-color: #ffffff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                        }
                        .header {
                            background-color: #4CAF50;
                            padding: 10px;
                            color: #ffffff;
                            text-align: center;
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
                            <h2>Rental Request Confirmation</h2>
                        </div>
                        <div class='content'>
                            <p>Dear $customer_name,</p>
                            <p>Thank you for your rental request with us. Here are the details of your request:</p>
                            <p><strong>Vehicle Name:</strong> $vehicle_name</p>
                            <p><strong>Plate Number:</strong> $plate_number</p>
                            <p><strong>Model:</strong> $model</p>
                            <p><strong>Rental Duration:</strong> $rental_duration days</p>
                            <p><strong>Pickup Date:</strong> $pickup_date</p>
                            <p><strong>Dropoff Date:</strong> $dropoff_date</p>
                            <p><strong>Total Price:</strong> Rs.$total_price</p>
                            <p>Your rental request is currently <strong>Pending Payment</strong>. Please visit our website to complete the payment and confirm your booking.</p>
                            <p><a class='button' href='localhost/primeride/profile.php'>Complete Payment</a></p>
                        </div>
                        <div class='footer'>
                            <p>If you have any questions, feel free to contact us at support@primeride.com</p>
                            <p>&copy; 2024 Prime Ride</p>
                        </div>
                    </div>
                </body>
                </html>
                ";

                $mail->send();
                echo "<script>
                        alert('Rental request submitted successfully! A confirmation email has been sent.');
                        window.location.href = '../../../profile.php';
                      </script>";
            } catch (Exception $e) {
                echo "<script>
                        alert('Error: Could not send the confirmation email.');
                        window.location.href = '../../../profile.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Error: Could not submit the rental request. Please try again later.');
                    window.location.href = '../../../rent-car.php';
                  </script>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
