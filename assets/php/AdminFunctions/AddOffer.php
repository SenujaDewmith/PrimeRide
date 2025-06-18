<?php
include '../dbconnection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title']; 
    $description = $_POST['description']; 

    
    if (isset($_POST['price']) && is_numeric($_POST['price'])) {
        $price = number_format(floatval($_POST['price']), 2, '.', ''); 
    } else {
        die("Invalid price input.");
    }

    if (isset($_POST['original_price']) && is_numeric($_POST['original_price'])) {
        $original_price = number_format(floatval($_POST['original_price']), 2, '.', ''); 
    } else {
        die("Invalid original price input.");
    }

  
    if ($_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $image_path = $_FILES['image_path']['name'];
       
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/PrimeRide/assets/Photo/Offerimg/";
        $target_file = $target_dir . basename($image_path);

  
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

       
        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file)) {
            
        } else {
            die("Error uploading the image file.");
        }
    } else {
        die("Image upload is required.");
    }

  
    $sql = "INSERT INTO offers (title, description, price, original_price, image_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

   
    $stmt->bind_param("ssdds", $title, $description, $price, $original_price, $image_path);

    
    if ($stmt->execute()) {
        
        header("Location:../../../admin/Promotions.php?message=OfferAdded");
        exit();
    } else {
       
        echo "Error: " . $stmt->error;
    }

   
    $stmt->close();
    $conn->close();
}
?>
