<?php
include '../dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    
    $sql = "SELECT image_path FROM gallery WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($image_path);
        $stmt->fetch();
        
       
        $sql = "DELETE FROM gallery WHERE id = ?";
        $stmt->close();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
           
            $target_file = "../../Photo/Galleryimg/" . $image_path;
            if (file_exists($target_file)) {
                unlink($target_file); 
            }
           
        } else {
            echo "Error deleting photo: " . $stmt->error;
        }
    } else {
        echo "Photo not found.";
    }

    $stmt->close();
    $conn->close();

   
    header("Location: ../../../staff/gallery_management.php"); 
    exit();
}
?>

