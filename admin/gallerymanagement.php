<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prime Ride | Admin Dashboard</title>
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/management.css"/>
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script defer src="../assets/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <!-- header -->
<?php include 'components/admin_header.php'; ?>

  
<!-- Sidebar -->
<?php include 'components/admin_sidebar.php';?>

  <!-- Main Content Area -->

  <?php
  include '../assets/php/dbconnection.php';
  ?>

<div class="content min-vh-100">
  <h2>Gallery Management</h2>
  
  <!-- Form for uploading images -->
  <form action="../assets/php/AdminFunctions/Update_gallery.php" method="POST" enctype="multipart/form-data">
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

<?php include 'components/admin_footer.php'; ?>

</body>
</html>
