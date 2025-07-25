<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Staff Dashboard | Gallery</title>
  <link rel="stylesheet" href="css/staff.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
  <!-- header -->
  <?php include 'components/staff_header.php'; ?>

  <div class="main-wrapper">
    <!-- Sidebar -->
    <?php include 'components/staff_sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="content">
      <?php include '../assets/php/dbconnection.php'; ?>

      <div class="gallery-container">
        <h2>Gallery Management</h2>
        
        <!-- Form for uploading images -->
        <form action="../assets/php/StaffFunctions/Update_gallery.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="image" class="form-label">Choose an Image</label>
            <input type="file" class="form-control" name="image" id="image" required>
          </div>
          <div class="mb-3">
            <label for="title" class="form-label">Image Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
          </div>

          <button type="submit" class="btn btn-success">Upload to the gallery</button>
        </form>
        
        <div class="list row mt-4">
          <?php
          $sql = "SELECT id, title, image_path FROM gallery";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '
              <div class="col-md-4 mb-4">
                <div class="card">
                  <img src="../assets/Photo/Galleryimg/'.$row['image_path'].'" class="card-img-top" alt="'.$row['title'].'">
                  <div class="card-body">
                    <h5 class="card-title">'.$row['title'].'</h5>
                    <form action="../assets/php/StaffFunctions/Delete_gallery_item.php" method="POST">
                      <input type="hidden" name="id" value="'.$row['id'].'">
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              </div>';
            }
          } else {
            echo "<p class='text-center'>Gallery Still Updating</p>";
          }
          $conn->close();
          ?>
        </div>
      </div>
    </div>
  </div>

  <script defer src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>