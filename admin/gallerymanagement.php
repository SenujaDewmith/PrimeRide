<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="admin.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
}

.header {
  background-color: #343a40;
  color: white;
  padding: 1rem;
  position: relative;
  z-index: 1;
}

.header h1 {
  font-size: 1.8rem;
  margin-left: 1rem;
}

.navlogo {
  width: 50px;
  height: auto;
}

.header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.sidebar {
  height: calc(100vh - 70px);
  width: 220px;
  position: fixed;
  top: 70px;
  left: 0;
  background-color: #495057;
  padding-top: 20px;
  transition: 0.3s;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}

.sidebar a {
  padding: 15px 25px;
  text-decoration: none;
  font-size: 18px;
  color: #f8f9fa;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  background-color: #343a40;
  color: #fff;
}

.sidebar a.active {
  background-color: #17a2b8;
  color: white;
  font-weight: bold;
}


.sidebar a::before {
  content: '•';
  color: #6c757d;
  margin-right: 10px;
  font-size: 20px;
  vertical-align: middle;
  display: inline-block;
}

.sidebar a:hover::before {
  color: #f8f9fa;
}

section {
  margin-left: 230px;
  padding: 20px;
  padding-top: 80px;
}


@media screen and (max-width: 768px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
    top: 0;
  }
  .sidebar a {
    text-align: center;
    padding: 10px;
  }
  section {
    margin-left: 0;
    padding-top: 120px;
  }
}

  </style>
</head>
<body>
  <header class="p-3 text-bg-brown header">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="../assets/Photo/logo.png" class="navlogo" alt="">
                </a>
                <h1>Prime Ride Admin Dashboard</h1>
            </div>
            <div class="d-flex align-items-center ms-auto">                           
            </div>
        </div>
    </div>
</header>
  
 <!-- Sidebar -->
 <div class="sidebar">
    <a href="vehiclemanagement.php">Vehicle Management</a>
    <a href="bookingmanagement.php">Booking Management</a>
    <a href="staffmanagement.php">Staff Management</a>
    <a href="gallerymanagement.php">Gallery Management</a>
    <a href="Promotions.php">Promotions</a>
  </div>

  <!-- Main Content Area -->

  <?php

include '../assets/php/dbconnection.php';


?>
<div class="content">
  <h2>Gallery Management</h2>
  
  <!-- Form for uploading images -->
  <form action="../assets/php/AdminFunctions/Update_gallery.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="image" class="form-label">Choose an Image</label>
      <input type="file" class="form-control" name="image" id="image" required>
    </div>
    <button type="submit" class="btn btn-success">Upload to the gallery</button>
  </form>
  <div class="row mt-4">
    <?php
    // Fetch items from the gallery
    $sql = "SELECT id, title, image_path FROM gallery";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="../assets/Photo/Galleryimg/<?php echo $row['image_path']; ?>" class="card-img-top" alt="<?php echo $row['title']; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['title']; ?></h5>
              <form action="../assets/php/AdminFunctions/Delete_gallery_item.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p class='text-center'>Gallery Still Updating</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
  </div>
</div>
<footer>
    <p>&copy; 2024 Prime Ride. All Rights Reserved.</p>
</footer>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
