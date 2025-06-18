<?php



include '../dbconnection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $offerTitle = $_POST['offer_title'];
    $offerPrice = $_POST['offer_price'];
    $offerDescription = $_POST['offer_description'];
    $customerUsername = $_POST['customer_username'];
    $customerEmail = $_POST['customer_email'];

    $sql = "INSERT INTO orders (offer_title, offer_price, customer_username, customer_email) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdss", $offerTitle, $offerPrice, $customerUsername, $customerEmail);
    
    if ($stmt->execute()) {
      
        echo "Order placed successfully!";
    } else {
       
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
