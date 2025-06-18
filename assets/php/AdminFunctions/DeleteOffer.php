<?php
include '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Offer ID

    // Fetch the current image path from the database
    $sql = "SELECT image_path FROM offers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($image_path);
        $stmt->fetch();
        
        
        $stmt->close();

       
        $sql = "DELETE FROM offers WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        
        if ($stmt->execute()) {
           
            $target_file = "../../assets/Photo/Offerimg/" . $image_path;
            if (file_exists($target_file)) {
                unlink($target_file);
            }

           
            echo "Offer deleted successfully.";
        } else {
            
            echo "Error deleting offer: " . $stmt->error;
        }
    } else {
        
        echo "Offer not found.";
    }

   
    $stmt->close();
    $conn->close();

   
    header("Location: ../../../admin/Promotions.php");
    exit();
}
?>
