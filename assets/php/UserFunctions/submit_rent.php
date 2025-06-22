<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $plate_number = $_POST['plate_number'];
    $email = $_POST['email'];
    $rental_duration = $_POST['rental_duration'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];
    $total_price = $_POST['total_price'];

    $rental_status = "Pending Payment";
    $created_at = date('Y-m-d H:i:s');
    $rental_id = rand(100000, 999999);

    // Fetch vehicle_id
    $stmt_vehicle = $conn->prepare("SELECT id, vehicle_name, model FROM vehicles WHERE license_plate = ?");
    $stmt_vehicle->bind_param("s", $plate_number);
    $stmt_vehicle->execute();
    $result_vehicle = $stmt_vehicle->get_result();

    if ($result_vehicle->num_rows === 0) {
        echo "<script>alert('Vehicle not found.'); window.location.href = '../../../rent-car.php';</script>";
        exit();
    }

    $vehicle = $result_vehicle->fetch_assoc();
    $vehicle_id = $vehicle['id'];
    $vehicle_name = $vehicle['vehicle_name'];
    $model = $vehicle['model'];
    $stmt_vehicle->close();

    // Fetch client_id
    $stmt_client = $conn->prepare("SELECT id, name, email FROM clients WHERE email = ?");
    $stmt_client->bind_param("s", $email);
    $stmt_client->execute();
    $result_client = $stmt_client->get_result();

    if ($result_client->num_rows === 0) {
        echo "<script>alert('Client not found.'); window.location.href = '../../../rent-car.php';</script>";
        exit();
    }

    $client = $result_client->fetch_assoc();
    $client_id = $client['id'];
    $customer_name = $client['name'];
    $customer_email = $client['email'];
    $stmt_client->close();

    // Check for date conflicts
    $sql_check = "SELECT * FROM rental 
                  WHERE vehicle_id = ? 
                  AND (rental_status = 'Pending Payment' OR rental_status = 'Approved')
                  AND (
                        (pickup_date BETWEEN ? AND ?) OR
                        (dropoff_date BETWEEN ? AND ?) OR
                        (? BETWEEN pickup_date AND dropoff_date) OR
                        (? BETWEEN pickup_date AND dropoff_date)
                      )";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("issssss", $id, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date, $pickup_date, $dropoff_date);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('System Alert: The vehicle is not available during the selected dates.');
                window.location.href = '../../../rent-car.php';
              </script>";
    } else {
        $sql = "INSERT INTO rental ( vehicle_id, client_id, rental_duration, pickup_date, dropoff_date, total_price, rental_status, created_at) 
                VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissdss", $vehicle_id, $client_id, $rental_duration, $pickup_date, $dropoff_date, $total_price, $rental_status, $created_at);

        if ($stmt->execute()) {
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
                $mail->addAddress($customer_email, $customer_name);

                $mail->isHTML(true);
                $mail->Subject = 'Rental Request Confirmation';
                $mail->Body = "
                <html>
                <body>
                    <div style='font-family:Arial,sans-serif; max-width:600px; margin:auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.1);'>
                        <h2 style='background:#4CAF50; color:#fff; padding:10px; text-align:center;'>Rental Request Confirmation</h2>
                        <p>Dear $customer_name,</p>
                        <p>Thank you for your rental request with us. Here are the details:</p>
                        <ul>
                            <li><strong>Vehicle Name:</strong> $vehicle_name</li>
                            <li><strong>Plate Number:</strong> $plate_number</li>
                            <li><strong>Model:</strong> $model</li>
                            <li><strong>Rental Duration:</strong> $rental_duration days</li>
                            <li><strong>Pickup Date:</strong> $pickup_date</li>
                            <li><strong>Dropoff Date:</strong> $dropoff_date</li>
                            <li><strong>Total Price:</strong> Rs.$total_price</li>
                        </ul>
                        <p>Your rental request is currently <strong>Pending Payment</strong>. Please complete the payment to confirm your booking.</p>
                        <p><a href='http://localhost/primeride/profile.php' style='background:#4CAF50; color:white; padding:10px 20px; text-decoration:none; border-radius:4px;'>Complete Payment</a></p>
                        <p style='color:#777; font-size:12px;'>If you have questions, contact us at support@primeride.com</p>
                        <p style='text-align:center; font-size:12px;'>&copy; 2024 Prime Ride</p>
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
                        alert('Error: Could not send confirmation email.');
                        window.location.href = '../../../profile.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Error: Could not submit the rental request.');
                    window.location.href = '../../../rent-car.php';
                  </script>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
