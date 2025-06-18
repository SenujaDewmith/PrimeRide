<?php
include '../dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $original_price = $_POST['original_price'];

    
    if (!empty($_FILES['image']['name'])) {
        
        $sql = "SELECT image_path FROM offers WHERE id='$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $existingImage = $row['image_path'];
        
        
        $oldImagePath = "../../Photo/Offerimg/" . $existingImage;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);  
        }

        
        $image = $_FILES['image']['name'];
        $target = "../../Photo/Offerimg/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        
        $sql = "UPDATE offers SET title='$title', description='$description', price='$price', original_price='$original_price', image_path='$image' WHERE id='$id'";
    } else {
        
        $sql = "UPDATE offers SET title='$title', description='$description', price='$price', original_price='$original_price' WHERE id='$id'";
    }

    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../../../admin/Promotions.php"); 
    } else {
        echo "Error updating offer: " . $conn->error;
    }

    $conn->close();
}
?>
